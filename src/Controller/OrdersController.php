<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Http\Response;

class OrdersController extends AppController
{
    // GET /checkout — show checkout page with cart & addresses
    public function checkout(): Response|null
    {
        $this->setCartCount();
        $identity = $this->Authentication->getIdentity();
        $userId   = $identity->get('id');

        $Carts     = $this->fetchTable('Carts');
        $Addresses = $this->fetchTable('Addresses');
        $Users     = $this->fetchTable('Users');

        $cart = $Carts->find()
            ->where(['user_id' => $userId])
            ->contain(['CartItems.Products'])
            ->first();

        if (!$cart || empty($cart->cart_items)) {
            $this->Flash->error(__('Your cart is empty.'));
            return $this->redirect(['controller' => 'Products', 'action' => 'index']);
        }

        $addresses = $Addresses->find()->where(['user_id' => $userId])->order(['is_default' => 'DESC'])->all();
        $user      = $Users->get($userId);
        $subtotal = 0;
        foreach ($cart->cart_items as $item) {
            $subtotal += $item->product->price * $item->quantity;
        }
        
        $discount = ($subtotal >= 150) ? ($subtotal * 0.20) : 0;
        $deliveryFee = ($subtotal >= 100) ? 0.00 : 8.00;
        $total = ($subtotal - $discount) + $deliveryFee;

        // POST — place order
        if ($this->request->is('post')) {
            $data      = $this->request->getData();
            $addressId = (int)($data['address_id'] ?? 0);
            $notes     = $data['notes'] ?? '';

            // Determine delivery address text
            $deliveryAddress = 'To be confirmed';
            if ($addressId) {
                $addr = $Addresses->find()->where(['id' => $addressId, 'user_id' => $userId])->first();
                if ($addr) {
                    $deliveryAddress = implode(', ', array_filter([
                        $addr->address_line, $addr->unit_no, $addr->city, $addr->state, $addr->postal_code
                    ]));
                }
            }

            // Create order
            $order = $this->Orders->newEntity([
                'user_id'          => $userId,
                'address_id'       => $addressId ?: null,
                'delivery_address' => $deliveryAddress,
                'phone_no'         => $user->phone_no,
                'discount'         => $discount,
                'delivery_fee'     => $deliveryFee,
                'total_amount'     => $total,
                'status'           => 'preparing',
                'notes'            => $notes,
            ]);

            if ($this->Orders->save($order)) {
                // Save order items & reduce stock
                $OrderItems = $this->fetchTable('OrderItems');
                $Products   = $this->fetchTable('Products');
                $CartItems  = $this->fetchTable('CartItems');

                foreach ($cart->cart_items as $ci) {
                    $OrderItems->save($OrderItems->newEntity([
                        'order_id'     => $order->id,
                        'product_id'   => $ci->product_id,
                        'product_name' => $ci->product->name,
                        'unit_price'   => $ci->product->price,
                        'cost_price'   => $ci->product->cost_price ?? ($ci->product->price * 0.5),
                        'quantity'     => $ci->quantity,
                        'subtotal'     => $ci->product->price * $ci->quantity,
                    ]));

                    // Reduce stock
                    $p = $Products->get($ci->product_id);
                    $p->stock_quantity = max(0, $p->stock_quantity - $ci->quantity);
                    $Products->save($p);

                    $CartItems->delete($ci);
                }

                $this->Flash->success(__('Order placed successfully! Your order is preparing confirmation.'));
                return $this->redirect(['action' => 'myOrders']);
            }

            $this->Flash->error(__('Could not place order. Please try again.'));
        }

        $this->set(compact('cart', 'addresses', 'user', 'total'));
        return null;
    }

    // GET /my-orders — customer order history
    public function myOrders(): void
    {
        $this->setCartCount();
        $identity = $this->Authentication->getIdentity();
        $myOrders = $this->Orders->find()
            ->where(['user_id' => $identity->get('id')])
            ->contain(['OrderItems.Products'])
            ->order(['Orders.created_at' => 'DESC'])
            ->all();

        $this->set(compact('myOrders'));
    }

    // GET /my-orders/view/{id}
    public function view(int $id): void
    {
        $this->setCartCount();
        $identity = $this->Authentication->getIdentity();
        $order    = $this->Orders->get($id, ['contain' => ['OrderItems.Products', 'Users']]);

        if ($order->user_id !== $identity->get('id')) {
            $this->Flash->error(__('Access denied.'));
            $this->redirect(['action' => 'myOrders']);
            return;
        }

        $this->set(compact('order'));
    }

    // GET /my-orders/receipt/{id}
    public function receipt(int $id): Response|null
    {
        $identity = $this->Authentication->getIdentity();
        $order    = $this->Orders->get($id, ['contain' => ['OrderItems.Products', 'Users']]);

        if ($order->user_id !== $identity->get('id')) {
            $this->Flash->error(__('Access denied.'));
            return $this->redirect(['action' => 'myOrders']);
        }

        $this->viewBuilder()->disableAutoLayout();
        $this->set(compact('order'));
        return null;
    }

    // GET/POST /my-orders/edit/{id} — customer can edit address, qty, phone
    public function edit(int $id): Response|null
    {
        $this->setCartCount();
        $identity  = $this->Authentication->getIdentity();
        $Addresses = $this->fetchTable('Addresses');
        $order     = $this->Orders->get($id, ['contain' => ['OrderItems.Products']]);

        if ($order->user_id !== $identity->get('id')) {
            $this->Flash->error(__('Access denied.'));
            return $this->redirect(['action' => 'myOrders']);
        }

        if ($order->status !== 'preparing') {
            $this->Flash->error(__('Only preparing orders can be edited.'));
            return $this->redirect(['action' => 'myOrders']);
        }

        $addresses = $Addresses->find()->where(['user_id' => $identity->get('id')])->all();

        if ($this->request->is(['post', 'put'])) {
            $data = $this->request->getData();

            $order->phone_no = $data['phone_no'] ?? $order->phone_no;
            $order->notes    = $data['notes'] ?? $order->notes;

            if (!empty($data['address_id'])) {
                $addr = $Addresses->find()
                    ->where(['id' => $data['address_id'], 'user_id' => $identity->get('id')])
                    ->first();
                if ($addr) {
                    $order->address_id       = $addr->id;
                    $order->delivery_address = implode(', ', array_filter([
                        $addr->address_line, $addr->unit_no, $addr->city, $addr->state, $addr->postal_code
                    ]));
                }
            }

            if ($this->Orders->save($order)) {
                $this->Flash->success(__('Order updated successfully!'));
                return $this->redirect(['action' => 'myOrders']);
            }
            $this->Flash->error(__('Could not update order.'));
        }

        $this->set(compact('order', 'addresses'));
        return null;
    }

    // POST /my-orders/cancel/{id}
    public function cancel(int $id): Response
    {
        $this->request->allowMethod(['post']);
        $identity = $this->Authentication->getIdentity();
        $order    = $this->Orders->get($id, ['contain' => ['OrderItems']]);

        if ($order->user_id !== $identity->get('id') || $order->status !== 'preparing') {
            $this->Flash->error(__('Cannot cancel this order.'));
            return $this->redirect(['action' => 'myOrders']);
        }

        // Restore stock
        $Products = $this->fetchTable('Products');
        foreach ($order->order_items as $oi) {
            if ($oi->product_id) {
                $p = $Products->get($oi->product_id);
                $p->stock_quantity += $oi->quantity;
                $Products->save($p);
            }
        }

        $order->status = 'cancelled';
        $this->Orders->save($order);

        $this->Flash->success(__('Order cancelled successfully.'));
        return $this->redirect(['action' => 'myOrders']);
    }
}
