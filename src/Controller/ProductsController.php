<?php
declare(strict_types=1);

namespace App\Controller;

class ProductsController extends AppController
{
    public function beforeFilter(\Cake\Event\EventInterface $event): void
    {
        parent::beforeFilter($event);
        $this->Authentication->addUnauthenticatedActions(['index', 'view']);
    }
    public function index()
    {
        $this->setCartCount();
        $identity = $this->Authentication->getIdentity();

        $ProductLines = $this->fetchTable('ProductLines');
        $Products     = $this->fetchTable('Products');

        // All product lines ordered
        $lines = $ProductLines->find()
            ->orderBy(['sort_order' => 'ASC'])
            ->all();

        // Search & filter
        $search     = $this->request->getQuery('q', '');
        $lineFilter = $this->request->getQuery('line', '');

        $conditions = [];
        if (!empty($search)) {
            $conditions['Products.name LIKE'] = '%' . $search . '%';
        }
        if (!empty($lineFilter)) {
            $conditions['Products.product_line_id'] = $lineFilter;
        }

        // All products grouped by line for display
        $allProducts = $Products->find()
            ->where($conditions)
            ->contain(['ProductLines'])
            ->orderBy(['ProductLines.sort_order' => 'ASC', 'Products.name' => 'ASC'])
            ->all();

        // New arrivals (separate section at top)
        $newArrivals = $Products->find()
            ->where(['is_new_arrival' => 1, 'status' => 'open'])
            ->contain(['ProductLines'])
            ->limit(4)
            ->all();

        // My orders (customer's past orders)
        $myOrders = [];
        if ($identity) {
            $Orders = $this->fetchTable('Orders');
            $myOrders = $Orders->find()
                ->where(['user_id' => $identity->get('id')])
                ->contain(['OrderItems'])
                ->orderBy(['Orders.created_at' => 'DESC'])
                ->all();
        }

        $this->set(compact('lines', 'allProducts', 'newArrivals', 'myOrders', 'search', 'lineFilter'));
    }
}