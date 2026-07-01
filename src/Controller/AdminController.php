<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Http\Response;

class AdminController extends AppController
{
    public function beforeFilter(\Cake\Event\EventInterface $event): void
    {
        parent::beforeFilter($event);
        // All admin actions require admin role
        $this->requireAdmin();
    }

    // GET /admin/dashboard
    public function dashboard(): void
    {
        $Orders       = $this->fetchTable('Orders');
        $OfflineSales = $this->fetchTable('OfflineSales');
        $Products     = $this->fetchTable('Products');

        // Total online revenue
        $onlineRevenue = $Orders->find()
            ->where(['status IN' => ['preparing', 'shipping', 'complete']])
            ->all()->sumOf('total_amount') ?? 0;

        // Total offline revenue
        $offlineRevenue = $OfflineSales->find()->all()->sumOf('total_amount') ?? 0;

        $totalRevenue  = $onlineRevenue + $offlineRevenue;
        
        $totalProfit = $totalRevenue * 0.5;
        
        $totalOrders   = $Orders->find()->count();

        // Monthly revenue for chart (last 6 months)
        $chartData = [];
        for ($i = 5; $i >= 0; $i--) {
            $month     = date('Y-m', strtotime("-$i months"));
            $label     = date('M Y', strtotime("-$i months"));
            $monthlyOnline  = $Orders->find()
                ->where(function ($exp, $q) use ($month) {
                    return $exp->and([
                        $exp->eq($q->func()->date_format(['created_at' => 'identifier', '%Y-%m']), $month),
                        $exp->in('status', ['preparing', 'shipping', 'complete']),
                    ]);
                })
                ->all()->sumOf('total_amount') ?? 0;
            $monthlyOffline = $OfflineSales->find()
                ->where(function ($exp, $q) use ($month) {
                    return $exp->eq($q->func()->date_format(['sale_date' => 'identifier', '%Y-%m']), $month);
                })
                ->all()->sumOf('total_amount') ?? 0;
            $chartData[] = [
                'label'   => $label,
                'online'  => (float)$monthlyOnline,
                'offline' => (float)$monthlyOffline,
                'total'   => (float)$monthlyOnline + (float)$monthlyOffline,
            ];
        }

        // Products with stock levels
        $products = $Products->find()
            ->contain(['ProductLines'])
            ->order(['stock_quantity' => 'ASC'])
            ->all();

        $this->set(compact(
            'totalRevenue', 'totalProfit', 'totalOrders',
            'onlineRevenue', 'offlineRevenue', 'chartData', 'products'
        ));
    }

    // GET /admin/orders
    public function orders(): void
    {
        $Orders   = $this->fetchTable('Orders');
        $statusFilter = $this->request->getQuery('status', '');
        $conditions   = [];
        if (!empty($statusFilter)) {
            $conditions['Orders.status'] = $statusFilter;
        }

        $orders = $Orders->find()
            ->where($conditions)
            ->contain(['Users', 'OrderItems.Products'])
            ->order(['Orders.created_at' => 'DESC'])
            ->all();

        $this->set(compact('orders', 'statusFilter'));
    }

    // POST /admin/orders/status/{id}
    public function updateStatus(int $id): Response
    {
        $this->request->allowMethod(['post']);
        $Orders  = $this->fetchTable('Orders');
        $order   = $Orders->get($id);
        $status  = $this->request->getData('status');
        $allowed = ['preparing', 'shipping', 'complete', 'cancelled'];

        if (!in_array($status, $allowed)) {
            return $this->response->withType('json')
                ->withStringBody(json_encode(['error' => 'Invalid status']));
        }

        $order->status = $status;
        $Orders->save($order);

        return $this->response->withType('json')
            ->withStringBody(json_encode(['success' => true, 'status' => $status]));
    }

    // GET /admin/stock — manage product status & restock
    public function stock(): void
    {
        $Products = $this->fetchTable('Products');
        $products = $Products->find()->contain(['ProductLines'])->order(['ProductLines.sort_order' => 'ASC', 'Products.name' => 'ASC'])->all();
        $this->set(compact('products'));
    }

    // POST /admin/stock/restock/{id}
    public function restock(int $id): Response
    {
        $this->request->allowMethod(['post']);
        $Products = $this->fetchTable('Products');
        $product  = $Products->get($id);
        $qty      = (int)$this->request->getData('quantity', 0);

        if ($qty > 0) {
            $product->stock_quantity += $qty;
            $Products->save($product);
        }

        return $this->response->withType('json')
            ->withStringBody(json_encode(['success' => true, 'stock' => $product->stock_quantity]));
    }

    // POST /admin/stock/toggle/{id}
    public function toggleStatus(int $id): Response
    {
        $this->request->allowMethod(['post']);
        $Products = $this->fetchTable('Products');
        $product  = $Products->get($id);
        $product->status = ($product->status === 'open') ? 'closed' : 'open';
        $Products->save($product);

        return $this->response->withType('json')
            ->withStringBody(json_encode(['success' => true, 'status' => $product->status]));
    }
}
