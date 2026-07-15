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
        $userId = $identity ? $identity->get('id') : null;
        $sessionId = $this->request->getSession()->id();
        
        $Carts = $this->fetchTable('Carts');
        $conditions = $userId ? ['user_id' => $userId] : ['session_id' => $sessionId];
        
        $cart = $Carts->find()
            ->where($conditions)
            ->contain(['CartItems'])
            ->first();
            
        $count = 0;
        if ($cart && !empty($cart->cart_items)) {
            foreach ($cart->cart_items as $item) {
                $count += $item->quantity;
            }
        }
        $this->set('cartCount', $count);
    }
}