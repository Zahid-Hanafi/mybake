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
            ->order(['sort_order' => 'ASC'])
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
            ->order(['ProductLines.sort_order' => 'ASC', 'Products.name' => 'ASC'])
            ->all();

        // New arrivals (separate section at top)
        $newArrivals = $Products->find()
            ->where(['is_new_arrival' => 1])
            ->contain(['ProductLines'])
            ->limit(4)
            ->all();

        $this->set(compact('lines', 'allProducts', 'newArrivals', 'search', 'lineFilter'));
    }
}