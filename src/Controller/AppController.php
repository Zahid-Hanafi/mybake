<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Controller\Controller;
use Cake\Event\EventInterface;

class AppController extends Controller
{
    public function initialize(): void
    {
        parent::initialize();
        $this->loadComponent('Flash');
        $this->loadComponent('Authentication.Authentication');
    }

    /**
     * Require admin role. Redirect to dashboard with error if not admin.
     */
    protected function requireAdmin(): void
    {
        $identity = $this->Authentication->getIdentity();
        if (!$identity || $identity->get('role') !== 'admin') {
            $this->Flash->error(__('Access denied. Admin only.'));
            $this->redirect(['controller' => 'Pages', 'action' => 'dashboard']);
        }
    }

    /**
     * Get the cart item count for the currently logged-in user.
     * Used by the layout to show cart badge count.
     */
    protected function setCartCount(): void
    {
        $identity = $this->Authentication->getIdentity();
        if ($identity) {
            $Carts = $this->fetchTable('Carts');
            $cart = $Carts->find()
                ->where(['user_id' => $identity->get('id')])
                ->contain(['CartItems'])
                ->first();
            $count = 0;
            if ($cart && !empty($cart->cart_items)) {
                foreach ($cart->cart_items as $item) {
                    $count += $item->quantity;
                }
            }
            $this->set('cartCount', $count);
        } else {
            $this->set('cartCount', 0);
        }
    }
}