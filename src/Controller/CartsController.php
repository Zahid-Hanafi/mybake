<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Http\Response;

class CartsController extends AppController
{
    public function beforeFilter(\Cake\Event\EventInterface $event): void
    {
        parent::beforeFilter($event);
        $this->Authentication->addUnauthenticatedActions(['index', 'addItem', 'updateItem', 'removeItem', 'count']);
    }

    // Get or create user's cart
    private function getOrCreateCart(int $userId): object
    {
        $cart = $this->Carts->find()
            ->where(['user_id' => $userId])
            ->first();

        if (!$cart) {
            $cart = $this->Carts->newEntity(['user_id' => $userId]);
            $this->Carts->save($cart);
        }
        return $cart;
    }

    // GET /cart — show cart (for AJAX cart slide panel)
    public function index(): void
    {
        $this->setCartCount();
        $identity = $this->Authentication->getIdentity();
        $CartItems = $this->fetchTable('CartItems');

        $items = [];
        $total = 0;
        $cart = null;

        if ($identity) {
            $cart = $this->Carts->find()
                ->where(['user_id' => $identity->get('id')])
                ->first();
        }

        $items = [];
        $total = 0;
        if ($cart) {
            $items = $CartItems->find()
                ->where(['cart_id' => $cart->id])
                ->contain(['Products'])
                ->all()
                ->toArray();
            foreach ($items as $item) {
                $total += $item->product->price * $item->quantity;
            }
        }

        // Return JSON for AJAX cart panel
        if ($this->request->is('ajax')) {
            $this->viewBuilder()->setClassName('Json');
            $this->set(compact('items', 'total'));
            $this->viewBuilder()->setOption('serialize', ['items', 'total']);
        }

        $this->set(compact('items', 'total'));
    }

    // POST /cart/add — add item to cart
    public function addItem(): Response|null
    {
        $this->request->allowMethod(['post']);
        $identity = $this->Authentication->getIdentity();
        if (!$identity) {
            return $this->response->withType('json')->withStringBody(json_encode(['error' => 'unauthenticated', 'redirect' => \Cake\Routing\Router::url('/register')]));
        }
        $userId = $identity->get('id');
        $productId  = (int)$this->request->getData('product_id');
        $quantity   = (int)$this->request->getData('quantity', 1);

        $Products = $this->fetchTable('Products');
        $product  = $Products->get($productId);

        if ($product->status !== 'open' || $product->stock_quantity < $quantity) {
            return $this->response->withStatus(400)
                ->withStringBody(json_encode(['error' => 'Product unavailable or insufficient stock.']));
        }

        $cart      = $this->getOrCreateCart($userId);
        $CartItems = $this->fetchTable('CartItems');

        // Check if already in cart
        $existing = $CartItems->find()
            ->where(['cart_id' => $cart->id, 'product_id' => $productId])
            ->first();

        if ($existing) {
            $existing->quantity += $quantity;
            $CartItems->save($existing);
        } else {
            $item = $CartItems->newEntity([
                'cart_id'    => $cart->id,
                'product_id' => $productId,
                'quantity'   => $quantity,
            ]);
            $CartItems->save($item);
        }

        // Return updated count
        $count = $CartItems->find()->where(['cart_id' => $cart->id])->all()->sumOf('quantity') ?? 0;

        if ($this->request->is('ajax')) {
            $this->viewBuilder()->setLayout('ajax');
            return $this->response->withType('json')
                ->withStringBody(json_encode(['success' => true, 'cartCount' => $count]));
        }

        $this->Flash->success(__('Item added to cart!'));
        return $this->redirect(['controller' => 'Products', 'action' => 'index']);
    }

    // POST /cart/update/{id} — update item quantity
    public function updateItem(int $id): Response|null
    {
        $this->request->allowMethod(['post', 'put']);
        $identity  = $this->Authentication->getIdentity();
        $quantity  = (int)$this->request->getData('quantity', 1);
        $CartItems = $this->fetchTable('CartItems');

        $item = $CartItems->get($id, ['contain' => ['Carts']]);
        if ($item->cart->user_id !== $identity->get('id')) {
            return $this->response->withStatus(403)->withStringBody(json_encode(['error' => 'Forbidden']));
        }

        if ($quantity < 1) {
            $CartItems->delete($item);
        } else {
            $item->quantity = $quantity;
            $CartItems->save($item);
        }

        // Recalculate total
        $cart  = $this->fetchTable('Carts')->get($item->cart_id, ['contain' => ['CartItems.Products']]);
        $total = 0;
        $count = 0;
        foreach ($cart->cart_items as $ci) {
            $total += $ci->product->price * $ci->quantity;
            $count += $ci->quantity;
        }

        return $this->response->withType('json')
            ->withStringBody(json_encode(['success' => true, 'total' => number_format($total, 2), 'cartCount' => $count]));
    }

    // POST /cart/remove/{id}
    public function removeItem(int $id): Response|null
    {
        $this->request->allowMethod(['post', 'delete']);
        $identity  = $this->Authentication->getIdentity();
        $CartItems = $this->fetchTable('CartItems');

        $item = $CartItems->get($id, ['contain' => ['Carts']]);
        if ($item->cart->user_id !== $identity->get('id')) {
            return $this->response->withStatus(403)->withStringBody(json_encode(['error' => 'Forbidden']));
        }

        $CartItems->delete($item);

        $cart  = $this->fetchTable('Carts')->find()
            ->where(['user_id' => $identity->get('id')])
            ->contain(['CartItems.Products'])
            ->first();

        $total = 0;
        $count = 0;
        if ($cart) {
            foreach ($cart->cart_items as $ci) {
                $total += $ci->product->price * $ci->quantity;
                $count += $ci->quantity;
            }
        }

        return $this->response->withType('json')
            ->withStringBody(json_encode(['success' => true, 'total' => number_format($total, 2), 'cartCount' => $count]));
    }

    // GET /cart/count — return current cart count (for header badge)
    public function count(): Response
    {
        $identity  = $this->Authentication->getIdentity();
        $CartItems = $this->fetchTable('CartItems');
        $cart = $this->Carts->find()->where(['user_id' => $identity->get('id')])->first();
        $count = $cart ? ($CartItems->find()->where(['cart_id' => $cart->id])->all()->sumOf('quantity') ?? 0) : 0;
        return $this->response->withType('json')->withStringBody(json_encode(['count' => $count]));
    }
}
