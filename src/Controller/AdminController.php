<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Http\Response;
use Cake\I18n\FrozenTime;

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

        $selectedYear = (int)$this->request->getQuery('year', date('Y'));

        // Auto-complete shipped orders (7+ days)
        $Orders->autoCompleteShippedOrders();

        // Total online revenue (exclude cancelled) for the year
        $onlineRevenue = $Orders->find()
            ->where([
                'status IN' => ['preparing', 'shipping', 'complete'],
                'YEAR(created_at)' => $selectedYear
            ])
            ->all()->sumOf('total_amount') ?? 0;

        // Total offline revenue for the year
        $offlineRevenue = $OfflineSales->find()
            ->where(['YEAR(sale_date)' => $selectedYear])
            ->all()->sumOf('total_amount') ?? 0;

        $totalRevenue  = $onlineRevenue + $offlineRevenue;
        $totalProfit = $totalRevenue * 0.5;
        $totalOrders   = $Orders->find()
            ->where(['YEAR(created_at)' => $selectedYear])
            ->count();
            
        $totalCustomers = $this->fetchTable('Users')->find()
            ->where(['role' => 'customer', 'YEAR(created_at)' => $selectedYear])
            ->count();

        // Default chart data (monthly, for selected year)
        $chartData = $this->_buildChartData('monthly', $selectedYear);
        
        // Available years for dropdown
        $availableYears = [2024, 2025, 2026];

        $this->set(compact(
            'totalRevenue', 'totalProfit', 'totalOrders', 'totalCustomers',
            'onlineRevenue', 'offlineRevenue', 'chartData', 'availableYears', 'selectedYear'
        ));
    }

    // AJAX: GET /admin/chart-data?period=daily|weekly|monthly|yearly&year=2026
    public function chartData(): Response
    {
        $this->request->allowMethod(['get']);
        $period = $this->request->getQuery('period', 'monthly');
        $year = (int)$this->request->getQuery('year', date('Y'));
        $data = $this->_buildChartData($period, $year);

        return $this->response->withType('json')
            ->withStringBody(json_encode($data));
    }

    // AJAX: GET /admin/product-trends?year=2026
    public function productTrends(): Response
    {
        $this->request->allowMethod(['get']);
        $year = (int)$this->request->getQuery('year', date('Y'));

        $OrderItems = $this->fetchTable('OrderItems');
        $Products   = $this->fetchTable('Products');

        $products = $Products->find()->order(['name' => 'ASC'])->all();
        
        $labels = [];
        $data = [];

        foreach ($products as $product) {
            $start = sprintf('%04d-01-01', $year);
            $end   = sprintf('%04d-12-31', $year);

            $qty = $OrderItems->find()
                ->innerJoinWith('Orders', function ($q) use ($start, $end) {
                    return $q->where([
                        'Orders.created_at >=' => $start . ' 00:00:00',
                        'Orders.created_at <=' => $end . ' 23:59:59',
                        'Orders.status IN' => ['preparing', 'shipping', 'complete'],
                    ]);
                })
                ->where(['OrderItems.product_id' => $product->id])
                ->all()->sumOf('quantity') ?? 0;

            if ($qty > 0) {
                $labels[] = $product->name;
                $data[] = (int)$qty;
            }
        }

        // Sort by quantity descending
        array_multisort($data, SORT_DESC, $labels);

        return $this->response->withType('json')
            ->withStringBody(json_encode([
                'labels' => $labels,
                'data' => $data,
                'year' => $year,
            ]));
    }

    private function _buildChartData(string $period, int $year = null): array
    {
        if ($year === null) $year = (int)date('Y');
        $Orders       = $this->fetchTable('Orders');
        $OfflineSales = $this->fetchTable('OfflineSales');
        $chartData    = [];

        switch ($period) {
            case 'daily':
                for ($i = 6; $i >= 0; $i--) {
                    $date  = date('Y-m-d', strtotime("-$i days"));
                    $label = date('d M', strtotime("-$i days"));
                    $online = $Orders->find()
                        ->where(['DATE(created_at)' => $date, 'status IN' => ['preparing','shipping','complete']])
                        ->all()->sumOf('total_amount') ?? 0;
                    $offline = $OfflineSales->find()
                        ->where(['sale_date' => $date])
                        ->all()->sumOf('total_amount') ?? 0;
                    $chartData[] = ['label' => $label, 'online' => (float)$online, 'offline' => (float)$offline];
                }
                break;

            case 'weekly':
                for ($i = 3; $i >= 0; $i--) {
                    $refDate   = date('Y-m-d', strtotime("-$i weeks"));
                    $weekStart = date('Y-m-d', strtotime('monday this week', strtotime($refDate)));
                    $weekEnd   = date('Y-m-d', strtotime('sunday this week', strtotime($refDate)));
                    $label     = date('d M', strtotime($weekStart)) . ' - ' . date('d M', strtotime($weekEnd));
                    $online = $Orders->find()
                        ->where(['DATE(created_at) >=' => $weekStart, 'DATE(created_at) <=' => $weekEnd, 'status IN' => ['preparing','shipping','complete']])
                        ->all()->sumOf('total_amount') ?? 0;
                    $offline = $OfflineSales->find()
                        ->where(['sale_date >=' => $weekStart, 'sale_date <=' => $weekEnd])
                        ->all()->sumOf('total_amount') ?? 0;
                    $chartData[] = ['label' => $label, 'online' => (float)$online, 'offline' => (float)$offline];
                }
                break;

            case 'yearly':
                for ($y = 2024; $y <= (int)date('Y'); $y++) {
                    $online = $Orders->find()
                        ->where(['YEAR(created_at)' => $y, 'status IN' => ['preparing','shipping','complete']])
                        ->all()->sumOf('total_amount') ?? 0;
                    $offline = $OfflineSales->find()
                        ->where(['YEAR(sale_date)' => $y])
                        ->all()->sumOf('total_amount') ?? 0;
                    $chartData[] = ['label' => (string)$y, 'online' => (float)$online, 'offline' => (float)$offline];
                }
                break;

            default: // monthly - Jan to Dec of selected year
                for ($m = 1; $m <= 12; $m++) {
                    $monthStr = sprintf('%04d-%02d', $year, $m);
                    $label = date('M Y', strtotime($monthStr . '-01'));
                    $online = $Orders->find()
                        ->where(function ($exp, $q) use ($monthStr) {
                            return $exp->and([
                                $exp->eq($q->func()->date_format(['created_at' => 'identifier', '%Y-%m']), $monthStr),
                                $exp->in('status', ['preparing', 'shipping', 'complete']),
                            ]);
                        })
                        ->all()->sumOf('total_amount') ?? 0;
                    $offline = $OfflineSales->find()
                        ->where(function ($exp, $q) use ($monthStr) {
                            return $exp->eq($q->func()->date_format(['sale_date' => 'identifier', '%Y-%m']), $monthStr);
                        })
                        ->all()->sumOf('total_amount') ?? 0;
                    $chartData[] = ['label' => $label, 'online' => (float)$online, 'offline' => (float)$offline];
                }
        }

        return $chartData;
    }

    // GET /admin/orders
    public function orders(): void
    {
        $Orders = $this->fetchTable('Orders');

        // Auto-complete shipped orders (7+ days)
        $autoCompleted = $Orders->autoCompleteShippedOrders();
        if ($autoCompleted > 0) {
            $this->Flash->success(__("{$autoCompleted} order(s) auto-completed (shipped 7+ days ago)."));
        }

        $statusFilter = $this->request->getQuery('status', '');
        $search       = $this->request->getQuery('search', '');
        $conditions   = [];
        if (!empty($statusFilter)) {
            $conditions['Orders.status'] = $statusFilter;
        }

        $query = $Orders->find()
            ->where($conditions)
            ->contain(['Users', 'OrderItems.Products'])
            ->order(['Orders.created_at' => 'DESC']);

        // Search by customer name, order ID, address, tracking number, or date
        if (!empty($search)) {
            $query->where(function ($exp) use ($search) {
                $or = $exp->or([
                    'Users.first_name LIKE' => "%{$search}%",
                    'Users.last_name LIKE' => "%{$search}%",
                    'Orders.tracking_number LIKE' => "%{$search}%",
                    'Orders.delivery_address LIKE' => "%{$search}%",
                    'Orders.created_at LIKE' => "%{$search}%"
                ]);
                if (is_numeric($search)) {
                    $or->eq('Orders.id', (int)$search);
                }
                return $or;
            });
        }

        $orders = $query->all();

        $this->set(compact('orders', 'statusFilter', 'search'));
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

        $oldStatus = $order->status;
        $order->status = $status;

        // Set timestamps based on status
        if ($status === 'shipping' && !$order->shipped_at) {
            $trackingNumber = $this->request->getData('tracking_number');
            $courierName    = $this->request->getData('courier_name', 'Pos Laju');
            $order->shipped_at = new FrozenTime();
            $order->courier_name = $courierName;
            if ($trackingNumber) {
                $order->tracking_number = $trackingNumber;
            }
        }
        if ($status === 'complete' && !$order->completed_at) {
            $order->completed_at = new FrozenTime();
        }

        if ($Orders->save($order)) {
            // Log status change
            $identity = $this->Authentication->getIdentity();
            $StatusLogs = $this->fetchTable('OrderStatusLogs');
            $note = "Status changed from {$oldStatus} to {$status}";
            if ($status === 'shipping' && $order->tracking_number) {
                $note .= " — Tracking: {$order->tracking_number} ({$order->courier_name})";
            }
            $StatusLogs->save($StatusLogs->newEntity([
                'order_id' => $order->id,
                'status' => $status,
                'note' => $note,
                'created_by' => $identity->get('id'),
            ]));
        }

        return $this->response->withType('json')
            ->withStringBody(json_encode([
                'success' => true,
                'status' => $status,
                'tracking_number' => $order->tracking_number,
                'courier_name' => $order->courier_name,
            ]));
    }

    // POST /admin/orders/bulk-update
    public function bulkUpdate(): Response
    {
        $this->request->allowMethod(['post']);
        $Orders = $this->fetchTable('Orders');
        $StatusLogs = $this->fetchTable('OrderStatusLogs');
        $identity = $this->Authentication->getIdentity();

        $orderIds = $this->request->getData('order_ids', []);
        $newStatus = $this->request->getData('status');
        $trackingPrefix = $this->request->getData('tracking_prefix', '');
        $courierName = $this->request->getData('courier_name', 'Pos Laju');

        if (empty($orderIds) || !in_array($newStatus, ['preparing', 'shipping', 'complete', 'cancelled'])) {
            return $this->response->withType('json')
                ->withStringBody(json_encode(['error' => 'Invalid request']));
        }

        $updated = 0;
        foreach ($orderIds as $orderId) {
            $order = $Orders->get((int)$orderId);
            $oldStatus = $order->status;
            $order->status = $newStatus;

            if ($newStatus === 'shipping' && !$order->shipped_at) {
                $order->shipped_at = new FrozenTime();
                $order->courier_name = $courierName;
                // Auto-generate tracking number if prefix provided
                if ($trackingPrefix) {
                    $order->tracking_number = $trackingPrefix . str_pad((string)$order->id, 6, '0', STR_PAD_LEFT);
                }
            }
            if ($newStatus === 'complete' && !$order->completed_at) {
                $order->completed_at = new FrozenTime();
            }

            if ($Orders->save($order)) {
                $note = "Bulk update: {$oldStatus} → {$newStatus}";
                if ($order->tracking_number) {
                    $note .= " — Tracking: {$order->tracking_number}";
                }
                $StatusLogs->save($StatusLogs->newEntity([
                    'order_id' => $order->id,
                    'status' => $newStatus,
                    'note' => $note,
                    'created_by' => $identity->get('id'),
                ]));
                $updated++;
            }
        }

        return $this->response->withType('json')
            ->withStringBody(json_encode(['success' => true, 'updated' => $updated]));
    }

    // GET /admin/orders/scan/{token} — QR Scan Page
    public function scan(string $token): void
    {
        $Orders = $this->fetchTable('Orders');
        $order = $Orders->find()
            ->where(['qr_token' => $token])
            ->contain(['Users', 'OrderItems.Products', 'OrderStatusLogs'])
            ->first();

        if (!$order) {
            $this->Flash->error(__('Invalid QR code. Order not found.'));
            $this->redirect(['action' => 'orders']);
            return;
        }

        $this->viewBuilder()->disableAutoLayout();
        $this->set(compact('order'));
    }

    // POST /admin/orders/ship/{id} — Ship order with tracking number (from scan page)
    public function ship(int $id): Response
    {
        $this->request->allowMethod(['post']);
        $Orders = $this->fetchTable('Orders');
        $StatusLogs = $this->fetchTable('OrderStatusLogs');
        $identity = $this->Authentication->getIdentity();

        $order = $Orders->get($id);

        if ($order->status !== 'preparing') {
            return $this->response->withType('json')
                ->withStringBody(json_encode(['error' => 'Order is not in preparing status']));
        }

        $trackingNumber = $this->request->getData('tracking_number');
        $courierName = $this->request->getData('courier_name', 'Pos Laju');

        if (empty($trackingNumber)) {
            return $this->response->withType('json')
                ->withStringBody(json_encode(['error' => 'Tracking number is required']));
        }

        $order->status = 'shipping';
        $order->shipped_at = new FrozenTime();
        $order->courier_name = $courierName;
        $order->tracking_number = $trackingNumber;

        if ($Orders->save($order)) {
            $StatusLogs->save($StatusLogs->newEntity([
                'order_id' => $order->id,
                'status' => 'shipping',
                'note' => "Shipped via {$courierName} — Tracking: {$trackingNumber}",
                'created_by' => $identity->get('id'),
            ]));

            return $this->response->withType('json')
                ->withStringBody(json_encode(['success' => true, 'message' => 'Order shipped successfully!']));
        }

        return $this->response->withType('json')
            ->withStringBody(json_encode(['error' => 'Failed to update order']));
    }

    // GET /admin/orders/packing-slip/{id} — Printable packing slip with QR code
    public function packingSlip(int $id): void
    {
        $Orders = $this->fetchTable('Orders');
        $order = $Orders->get($id, ['contain' => ['Users', 'OrderItems.Products']]);

        $this->viewBuilder()->disableAutoLayout();
        $this->set(compact('order'));
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
