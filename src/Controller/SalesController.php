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
        $sales = $OfflineSales->find()
            ->contain(['Users', 'OfflineSaleItems.Products'])
            ->orderBy(['sale_date' => 'DESC'])
            ->all();

        $totalRevenue = $OfflineSales->find()->sumOf('total_amount') ?? 0;
        
        $totalProfit = 0;
        foreach ($sales as $sale) {
            foreach ($sale->offline_sale_items as $item) {
                $totalProfit += ($item->unit_price - $item->cost_price) * $item->quantity;
            }
        }

        $this->set(compact('sales', 'totalRevenue', 'totalProfit'));
    }

    // GET/POST /admin/sales/add
    public function add(): Response|null
    {
        $identity = $this->Authentication->getIdentity();
        $Products = $this->fetchTable('Products');
        $products = $Products->find()
            ->where(['status' => 'open'])
            ->contain(['ProductLines'])
            ->orderBy(['ProductLines.sort_order' => 'ASC'])
            ->all();

        $sale = $this->OfflineSales->newEmptyEntity();

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

            $sale = $this->OfflineSales->patchEntity($sale, [
                'recorded_by'  => $identity->get('id'),
                'sale_date'    => $saleDate,
                'total_amount' => $total,
                'notes'        => $data['notes'] ?? '',
            ]);

            if ($this->OfflineSales->save($sale)) {
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

    // GET /admin/sales/report?type=daily|weekly|monthly&date=...
    public function report(): Response
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
            default: // daily
                $start = $end = $date;
        }

        $offlineSales = $OfflineSales->find()
            ->where(['sale_date >=' => $start, 'sale_date <=' => $end])
            ->contain(['Users', 'OfflineSaleItems.Products'])
            ->orderBy(['sale_date' => 'ASC'])
            ->all();

        $onlineOrders = $Orders->find()
            ->where(['DATE(created_at) >=' => $start, 'DATE(created_at) <=' => $end,
                     'status IN' => ['pending','shipping','complete']])
            ->contain(['Users', 'OrderItems.Products'])
            ->orderBy(['created_at' => 'ASC'])
            ->all();

        $offlineTotal = $offlineSales->sumOf('total_amount') ?? 0;
        $onlineTotal  = $onlineOrders->sumOf('total_amount') ?? 0;
        $grandTotal   = $offlineTotal + $onlineTotal;
        
        $totalProfit = 0;
        foreach ($offlineSales as $sale) {
            foreach ($sale->offline_sale_items as $item) {
                $totalProfit += ($item->unit_price - $item->cost_price) * $item->quantity;
            }
        }
        foreach ($onlineOrders as $order) {
            foreach ($order->order_items as $item) {
                $totalProfit += ($item->unit_price - $item->cost_price) * $item->quantity;
            }
        }

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
            'generatedAt'   => date('d/m/Y H:i'),
        ];

        $this->set(compact('reportData', 'type', 'start', 'end', 'date'));

        // If PDF requested
        if ($this->request->getQuery('format') === 'pdf') {
            $this->viewBuilder()->setLayout('pdf');
            $this->set(compact('reportData'));
        }

        return $this->response;
    }
}
