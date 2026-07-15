<?php $this->assign('title', 'Sales Report'); ?>

<?php
$rd = $reportData;
$period = $type === 'daily' ? "Daily Report — " . date('d M Y', strtotime($start))
    : ($type === 'weekly' ? "Weekly Report — " . date('d M', strtotime($start)) . " to " . date('d M Y', strtotime($end))
    : ($type === 'monthly' ? "Monthly Report — " . date('F Y', strtotime($start))
    : "Yearly Report — " . date('Y', strtotime($start))));

// Prepare chart data for Sales Breakdown
$breakdownLabels = [];
$breakdownOnline = [];
$breakdownOffline = [];

if ($type === 'daily') {
    // Show one bar for the day, but normally this chart is better for ranges. 
    // We'll just show one bar.
    $breakdownLabels[] = date('d M', strtotime($start));
    $breakdownOnline[] = $rd['onlineTotal'];
    $breakdownOffline[] = $rd['offlineTotal'];
} elseif ($type === 'weekly') {
    // 7 days
    for ($i = 0; $i < 7; $i++) {
        $d = date('Y-m-d', strtotime("$start +$i days"));
        $breakdownLabels[] = date('D (d)', strtotime($d));
        $on = 0; $off = 0;
        foreach ($rd['onlineOrders'] as $o) if ($o->created_at && $o->created_at->format('Y-m-d') === $d) $on += $o->total_amount;
        foreach ($rd['offlineSales'] as $s) {
            $sd = method_exists($s->sale_date, 'format') ? $s->sale_date->format('Y-m-d') : $s->sale_date;
            if ($sd === $d) $off += $s->total_amount;
        }
        $breakdownOnline[] = $on;
        $breakdownOffline[] = $off;
    }
} elseif ($type === 'monthly') {
    // Days in month
    $days = (int)date('t', strtotime($start));
    for ($i = 1; $i <= $days; $i++) {
        $d = date('Y-m-', strtotime($start)) . sprintf('%02d', $i);
        $breakdownLabels[] = (string)$i;
        $on = 0; $off = 0;
        foreach ($rd['onlineOrders'] as $o) if ($o->created_at && $o->created_at->format('Y-m-d') === $d) $on += $o->total_amount;
        foreach ($rd['offlineSales'] as $s) {
            $sd = method_exists($s->sale_date, 'format') ? $s->sale_date->format('Y-m-d') : $s->sale_date;
            if ($sd === $d) $off += $s->total_amount;
        }
        $breakdownOnline[] = $on;
        $breakdownOffline[] = $off;
    }
} elseif ($type === 'yearly') {
    // 12 months
    for ($i = 1; $i <= 12; $i++) {
        $m = date('Y-', strtotime($start)) . sprintf('%02d', $i);
        $breakdownLabels[] = date('M', strtotime($m . '-01'));
        $on = 0; $off = 0;
        foreach ($rd['onlineOrders'] as $o) if ($o->created_at && $o->created_at->format('Y-m') === $m) $on += $o->total_amount;
        foreach ($rd['offlineSales'] as $s) {
            $sd = method_exists($s->sale_date, 'format') ? $s->sale_date->format('Y-m') : substr($s->sale_date, 0, 7);
            if ($sd === $m) $off += $s->total_amount;
        }
        $breakdownOnline[] = $on;
        $breakdownOffline[] = $off;
    }
}

// Product Performance Chart Data
$productLabels = [];
$productData = [];
$productColors = [];
$colors = ['#10B981', '#3B82F6', '#F59E0B', '#8B5CF6', '#EC4899', '#06B6D4', '#F97316'];
$colorMap = [];
$cIdx = 0;

foreach ($rd['productStats'] as $ps) {
    if ($ps['revenue'] > 0) {
        $productLabels[] = $ps['name'];
        $productData[] = $ps['revenue'];
        if (!isset($colorMap[$ps['line']])) {
            $colorMap[$ps['line']] = $colors[$cIdx % count($colors)];
            $cIdx++;
        }
        $productColors[] = $colorMap[$ps['line']];
    }
}
?>

<!-- Period Header -->
<div style="background:linear-gradient(135deg,var(--primary-emerald-dark),var(--primary-emerald)); border-radius:16px; padding:1.5rem; margin-bottom:1.5rem; color:#fff; display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:1rem;">
    <div>
        <p style="font-size:0.75rem; opacity:0.7; text-transform:uppercase; letter-spacing:0.08em; margin-bottom:0.25rem;">Sales Report</p>
        <h2 style="font-family:'Playfair Display',serif; font-size:1.35rem; font-weight:700;"><?= $period ?></h2>
        <p style="font-size:0.75rem; opacity:0.6; margin-top:0.25rem;">Generated: <?= $rd['generatedAt'] ?></p>
    </div>
    <div style="display:flex; gap:1.5rem; flex-wrap:wrap; align-items:center;">
        <div style="text-align:center;">
            <div style="font-family:'Playfair Display',serif; font-size:1.5rem; font-weight:700; color:var(--secondary-gold-light);">RM <?= number_format($rd['grandTotal'], 2) ?></div>
            <div style="font-size:0.72rem; opacity:0.7;">Grand Total</div>
        </div>
        <div style="text-align:center;">
            <div style="font-family:'Playfair Display',serif; font-size:1.5rem; font-weight:700; color:var(--secondary-gold-light);">RM <?= number_format($rd['totalProfit'], 2) ?></div>
            <div style="font-size:0.72rem; opacity:0.7;">Total Profit</div>
        </div>
        <div style="display:flex; gap:0.5rem; margin-left:1rem;">
            <a href="<?= $this->Url->build('/admin/sales') ?>" class="btn btn-outline" style="border-color: rgba(255,255,255,0.4); color:#fff;">
                <i class="fas fa-arrow-left"></i> Back
            </a>
            <a href="<?= $this->Url->build('/admin/sales/report?type=' . h($type) . '&date=' . h($date) . '&format=pdf') ?>" class="btn btn-gold" target="_blank">
                <i class="fas fa-file-pdf"></i> Download PDF
            </a>
        </div>
    </div>
</div>

<!-- Summary Cards -->
<div style="display:grid; grid-template-columns:repeat(3,1fr); gap:1.25rem; margin-bottom:2rem;">
    <div class="stat-card" style="border-left:4px solid #3B82F6;">
        <p class="stat-label">Online Sales</p>
        <p class="stat-value" style="color:#3B82F6;">RM <?= number_format($rd['onlineTotal'], 2) ?></p>
        <p style="font-size:0.75rem; color:var(--text-muted); margin-top:0.25rem;"><?= count($rd['onlineOrders']) ?> orders</p>
    </div>
    <div class="stat-card gold">
        <p class="stat-label">Offline Sales</p>
        <p class="stat-value" style="color:var(--secondary-gold-dark);">RM <?= number_format($rd['offlineTotal'], 2) ?></p>
        <p style="font-size:0.75rem; color:var(--text-muted); margin-top:0.25rem;"><?= count($rd['offlineSales']) ?> records</p>
    </div>
    <div class="stat-card green">
        <p class="stat-label">Est. Profit (50%)</p>
        <p class="stat-value" style="color:#15803D;">RM <?= number_format($rd['totalProfit'], 2) ?></p>
    </div>
</div>

<!-- Charts Section -->
<div style="display:grid; grid-template-columns:repeat(2,1fr); gap:1.5rem; margin-bottom:2rem;">
    <!-- Sales Breakdown Chart -->
    <div style="background:#fff; border-radius:20px; border:1px solid var(--border-light); padding:1.5rem; box-shadow:var(--shadow-sm);">
        <h3 style="font-size:1rem; font-weight:700; margin-bottom:1rem; display:flex; align-items:center; gap:0.5rem;">
            <i class="fas fa-chart-column" style="color:var(--primary-emerald);"></i> Sales Breakdown
        </h3>
        <div style="position:relative; height:300px; width:100%;">
            <canvas id="breakdownChart"></canvas>
        </div>
    </div>
    
    <!-- Product Performance Chart -->
    <div style="background:#fff; border-radius:20px; border:1px solid var(--border-light); padding:1.5rem; box-shadow:var(--shadow-sm);">
        <h3 style="font-size:1rem; font-weight:700; margin-bottom:1rem; display:flex; align-items:center; gap:0.5rem;">
            <i class="fas fa-ranking-star" style="color:var(--secondary-gold-dark);"></i> Product Performance
        </h3>
        <div style="position:relative; height:300px; width:100%;">
            <?php if (empty($productLabels)): ?>
                <div style="height:100%; display:flex; align-items:center; justify-content:center; color:var(--text-muted);">No product sales data.</div>
            <?php else: ?>
                <canvas id="productChart"></canvas>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Online Orders Table -->
<?php if (count($rd['onlineOrders']) > 0): ?>
<div style="background:#fff; border-radius:20px; border:1px solid var(--border-light); overflow:hidden; margin-bottom:1.5rem; box-shadow:var(--shadow-sm);">
    <div style="padding:1.25rem 1.5rem; border-bottom:1px solid var(--border-light); font-weight:700; display:flex; align-items:center; gap:0.6rem;">
        <i class="fas fa-globe" style="color:#3B82F6;"></i> Online Orders
    </div>
    <div class="table-wrapper" style="border:none; border-radius:0;">
        <table>
            <thead>
                <tr><th>Date</th><th>Customer</th><th>Items</th><th>Amount</th></tr>
            </thead>
            <tbody>
                <?php foreach ($rd['onlineOrders'] as $o): ?>
                <tr>
                    <td><?= $o->created_at ? $o->created_at->format('d M Y') : '—' ?></td>
                    <td><?= $o->user ? h($o->user->first_name . ' ' . $o->user->last_name) : 'Guest' ?></td>
                    <td style="font-size:0.8rem;">
                        <?php foreach ($o->order_items as $oi): ?><div><?= h($oi->product_name) ?> ×<?= $oi->quantity ?></div><?php endforeach; ?>
                    </td>
                    <td style="font-weight:700; color:#3B82F6;">RM <?= number_format($o->total_amount, 2) ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?php endif; ?>

<!-- Offline Sales Table -->
<?php if (count($rd['offlineSales']) > 0): ?>
<div style="background:#fff; border-radius:20px; border:1px solid var(--border-light); overflow:hidden; box-shadow:var(--shadow-sm);">
    <div style="padding:1.25rem 1.5rem; border-bottom:1px solid var(--border-light); font-weight:700; display:flex; align-items:center; gap:0.6rem;">
        <i class="fas fa-store" style="color:var(--secondary-gold-dark);"></i> Offline Sales
    </div>
    <div class="table-wrapper" style="border:none; border-radius:0;">
        <table>
            <thead>
                <tr><th>Date</th><th>Items</th><th>Amount</th><th>Recorded By</th></tr>
            </thead>
            <tbody>
                <?php foreach ($rd['offlineSales'] as $s): ?>
                <tr>
                    <td><?= $s->sale_date ? (method_exists($s->sale_date, 'format') ? $s->sale_date->format('d M Y') : $s->sale_date) : '—' ?></td>
                    <td style="font-size:0.8rem;">
                        <?php foreach ($s->offline_sale_items as $oi): ?><div><?= h($oi->product_name) ?> ×<?= $oi->quantity ?></div><?php endforeach; ?>
                    </td>
                    <td style="font-weight:700; color:var(--secondary-gold-dark);">RM <?= number_format($s->total_amount, 2) ?></td>
                    <td style="font-size:0.85rem; color:var(--text-muted);"><?= $s->user ? h($s->user->first_name) : 'Admin' ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?php endif; ?>

<?php if (count($rd['onlineOrders']) === 0 && count($rd['offlineSales']) === 0): ?>
<div style="text-align:center; padding:4rem 2rem; background:#fff; border-radius:20px; border:1px solid var(--border-light);">
    <i class="fas fa-file-invoice" style="font-size:3rem; color:var(--text-muted); opacity:0.2; display:block; margin-bottom:1rem;"></i>
    <p style="color:var(--text-muted);">No sales data found for the selected period.</p>
</div>
<?php endif; ?>

<?php $this->Html->scriptStart(['block' => true]); ?>
// Sales Breakdown Chart
const breakdownCtx = document.getElementById('breakdownChart');
if (breakdownCtx) {
    new Chart(breakdownCtx, {
        type: 'bar',
        data: {
            labels: <?= json_encode($breakdownLabels) ?>,
            datasets: [
                {
                    label: 'Online',
                    data: <?= json_encode($breakdownOnline) ?>,
                    backgroundColor: '#3B82F6',
                    borderRadius: 4
                },
                {
                    label: 'Offline',
                    data: <?= json_encode($breakdownOffline) ?>,
                    backgroundColor: '#C9A84C',
                    borderRadius: 4
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                x: { stacked: true, grid: { display: false } },
                y: { stacked: true, beginAtZero: true, ticks: { callback: v => 'RM ' + v.toLocaleString() } }
            },
            plugins: {
                tooltip: { callbacks: { label: ctx => ctx.dataset.label + ': RM ' + ctx.parsed.y.toFixed(2) } }
            }
        }
    });
}

// Product Performance Chart
const productCtx = document.getElementById('productChart');
if (productCtx && <?= count($productLabels) > 0 ? 'true' : 'false' ?>) {
    new Chart(productCtx, {
        type: 'bar',
        data: {
            labels: <?= json_encode($productLabels) ?>,
            datasets: [{
                label: 'Revenue',
                data: <?= json_encode($productData) ?>,
                backgroundColor: <?= json_encode($productColors) ?>,
                borderRadius: 4
            }]
        },
        options: {
            indexAxis: 'y', // Horizontal bar chart
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                x: { beginAtZero: true, ticks: { callback: v => 'RM ' + v.toLocaleString() } },
                y: { grid: { display: false }, ticks: { font: { size: 10 } } }
            },
            plugins: {
                legend: { display: false },
                tooltip: { callbacks: { label: ctx => 'Revenue: RM ' + ctx.parsed.x.toFixed(2) } }
            }
        }
    });
}
<?php $this->Html->scriptEnd(); ?>

<style>
@media(max-width:992px){ [style*="grid-template-columns:repeat(2,1fr)"]{grid-template-columns:1fr!important;} }
@media(max-width:640px){ [style*="grid-template-columns:repeat(3,1fr)"]{grid-template-columns:1fr!important;} }
</style>
