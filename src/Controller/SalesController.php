<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Http\Response;
use Cake\I18n\DateTime;

class SalesController extends AppController
{
    public function beforeFilter(\Cake\Event\EventInterface $event): void
    {
        parent::beforeFilter($event);
        $this->requireAdmin();
    }

    // GET /admin/sales
    public function index(): void
    {
        $OfflineSales = $this->fetchTable('OfflineSales');
        $Orders = $this->fetchTable('Orders');

        $selectedYear = (int)$this->request->getQuery('year', date('Y'));
        $availableYears = [2024, 2025, 2026];

        // Fetch offline sales
        $sales = $OfflineSales->find()
            ->where(['YEAR(sale_date)' => $selectedYear])
            ->contain(['Users', 'OfflineSaleItems.Products'])
            ->order(['sale_date' => 'DESC'])
            ->all();

        // Fetch online orders
        $onlineOrders = $Orders->find()
            ->where([
                'Orders.status IN' => ['preparing', 'shipping', 'complete'],
                'YEAR(Orders.created_at)' => $selectedYear
            ])
            ->contain(['Users', 'OrderItems.Products'])
            ->order(['Orders.created_at' => 'DESC'])
            ->all();

        $offlineRevenue = $sales->sumOf('total_amount') ?? 0;
        $onlineRevenue = $onlineOrders->sumOf('total_amount') ?? 0;
        $totalRevenue = $offlineRevenue + $onlineRevenue;
        
        $totalProfit = $totalRevenue * 0.5;

        $this->set(compact('sales', 'onlineOrders', 'offlineRevenue', 'onlineRevenue', 'totalRevenue', 'totalProfit', 'selectedYear', 'availableYears'));
    }

    // GET/POST /admin/sales/add
    public function add(): Response|null
    {
        $identity = $this->Authentication->getIdentity();
        $OfflineSales = $this->fetchTable('OfflineSales');
        $Products = $this->fetchTable('Products');
        $products = $Products->find()
            ->where(['status' => 'open'])
            ->contain(['ProductLines'])
            ->order(['ProductLines.sort_order' => 'ASC'])
            ->all();

        $sale = $OfflineSales->newEmptyEntity();

        if ($this->request->is('post')) {
            $data  = $this->request->getData();
            $items = $data['items'] ?? [];

            // Validate sale date >= today
            $saleDate = $data['sale_date'] ?? '';
            if (!empty($saleDate) && $saleDate < date('Y-m-d')) {
                $this->Flash->error(__('Sale date cannot be in the past.'));
                $this->set(compact('sale', 'products'));
                return null;
            }

            $total = 0;
            $lineItems = [];
            foreach ($items as $item) {
                if (empty($item['product_id']) || empty($item['quantity'])) continue;
                $product  = $Products->get((int)$item['product_id']);
                $qty      = (int)$item['quantity'];
                $price    = $product->price;
                $cost     = $product->cost_price ?? ($price * 0.5);
                $subtotal = $price * $qty;
                $total   += $subtotal;
                $lineItems[] = [
                    'product_id'   => $product->id,
                    'product_name' => $product->name,
                    'unit_price'   => $price,
                    'cost_price'   => $cost,
                    'quantity'     => $qty,
                    'subtotal'     => $subtotal,
                ];
            }

            $sale = $OfflineSales->patchEntity($sale, [
                'recorded_by'  => $identity->get('id'),
                'sale_date'    => $saleDate,
                'total_amount' => $total,
                'notes'        => $data['notes'] ?? '',
            ]);

            if ($OfflineSales->save($sale)) {
                $OfflineSaleItems = $this->fetchTable('OfflineSaleItems');
                foreach ($lineItems as $li) {
                    $li['offline_sale_id'] = $sale->id;
                    $OfflineSaleItems->save($OfflineSaleItems->newEntity($li));
                }

                $this->Flash->success(__('Sales record added successfully!'));
                return $this->redirect(['action' => 'index']);
            }

            $this->Flash->error(__('Could not save sales record.'));
        }

        $this->set(compact('sale', 'products'));
        return null;
    }

    // GET /admin/sales/report?type=daily|weekly|monthly|yearly&date=...
    public function report(): Response|null
    {
        $OfflineSales = $this->fetchTable('OfflineSales');
        $Orders       = $this->fetchTable('Orders');

        $type = $this->request->getQuery('type', 'daily');
        $date = $this->request->getQuery('date', date('Y-m-d'));

        // Date range
        switch ($type) {
            case 'weekly':
                $start = date('Y-m-d', strtotime('monday this week', strtotime($date)));
                $end   = date('Y-m-d', strtotime('sunday this week', strtotime($date)));
                break;
            case 'monthly':
                $start = date('Y-m-01', strtotime($date));
                $end   = date('Y-m-t', strtotime($date));
                break;
            case 'yearly':
                $start = date('Y-01-01', strtotime($date));
                $end   = date('Y-12-31', strtotime($date));
                break;
            default: // daily
                $start = $end = $date;
        }

        $offlineSales = $OfflineSales->find()
            ->where(['sale_date >=' => $start, 'sale_date <=' => $end])
            ->contain(['Users', 'OfflineSaleItems.Products'])
            ->order(['sale_date' => 'ASC'])
            ->all();

        $onlineOrders = $Orders->find()
            ->where(['DATE(Orders.created_at) >=' => $start, 'DATE(Orders.created_at) <=' => $end,
                     'Orders.status IN' => ['preparing','shipping','complete']])
            ->contain(['Users', 'OrderItems.Products'])
            ->order(['Orders.created_at' => 'ASC'])
            ->all();

        $offlineTotal = $offlineSales->sumOf('total_amount') ?? 0;
        $onlineTotal  = $onlineOrders->sumOf('total_amount') ?? 0;
        $grandTotal   = $offlineTotal + $onlineTotal;
        
        $totalProfit = $grandTotal * 0.5;

        // Product Performance data
        $Products = $this->fetchTable('Products');
        $products = $Products->find()->contain(['ProductLines'])->all();
        $productStats = [];
        foreach ($products as $p) {
            $productStats[$p->id] = [
                'name' => $p->name,
                'line' => $p->product_line->name ?? 'Other',
                'qty' => 0,
                'revenue' => 0
            ];
        }

        // Aggregate online product stats
        foreach ($onlineOrders as $o) {
            foreach ($o->order_items as $oi) {
                if (isset($productStats[$oi->product_id])) {
                    $productStats[$oi->product_id]['qty'] += $oi->quantity;
                    $productStats[$oi->product_id]['revenue'] += $oi->subtotal;
                }
            }
        }
        // Aggregate offline product stats
        foreach ($offlineSales as $s) {
            foreach ($s->offline_sale_items as $oi) {
                if (isset($productStats[$oi->product_id])) {
                    $productStats[$oi->product_id]['qty'] += $oi->quantity;
                    $productStats[$oi->product_id]['revenue'] += $oi->subtotal;
                }
            }
        }
        // Sort descending by revenue
        usort($productStats, fn($a, $b) => $b['revenue'] <=> $a['revenue']);

        // Build PDF content using mPDF-style HTML
        $reportData = [
            'type'          => $type,
            'start'         => $start,
            'end'           => $end,
            'offlineSales'  => $offlineSales,
            'onlineOrders'  => $onlineOrders,
            'offlineTotal'  => $offlineTotal,
            'onlineTotal'   => $onlineTotal,
            'grandTotal'    => $grandTotal,
            'totalProfit'   => $totalProfit,
            'productStats'  => $productStats,
            'generatedAt'   => date('d/m/Y H:i'),
        ];

        $this->set(compact('reportData', 'type', 'start', 'end', 'date'));

        // If PDF requested
        if ($this->request->getQuery('format') === 'pdf') {
            $view = new \Cake\View\View($this->request, $this->response);
            $view->set(compact('reportData', 'type', 'start', 'end', 'date'));
            $view->disableAutoLayout();
            $html = $view->render('Sales/pdf_report');

            $options = new \Dompdf\Options();
            $options->set('isRemoteEnabled', true);
            $options->set('defaultFont', 'sans-serif');
            
            $dompdf = new \Dompdf\Dompdf($options);
            $dompdf->loadHtml($html);
            $dompdf->setPaper('A4', 'portrait');
            $dompdf->render();

            return $this->response->withType('pdf')
                ->withStringBody($dompdf->output());
        }

        return null;
    }
}
