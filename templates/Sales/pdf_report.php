<?php
$rd = $reportData;
$period = $rd['type'] === 'daily' ? "Daily Report - " . date('d M Y', strtotime($rd['start']))
    : ($rd['type'] === 'weekly' ? "Weekly Report - " . date('d M', strtotime($rd['start'])) . " to " . date('d M Y', strtotime($rd['end']))
    : ($rd['type'] === 'monthly' ? "Monthly Report - " . date('F Y', strtotime($rd['start']))
    : "Yearly Report - " . date('Y', strtotime($rd['start']))));

// Re-generate chart data (same logic as report.php)
$breakdownLabels = [];
$breakdownOnline = [];
$breakdownOffline = [];

if ($rd['type'] === 'daily') {
    $breakdownLabels[] = date('d M', strtotime($rd['start']));
    $breakdownOnline[] = $rd['onlineTotal'];
    $breakdownOffline[] = $rd['offlineTotal'];
} elseif ($rd['type'] === 'weekly') {
    for ($i = 0; $i < 7; $i++) {
        $d = date('Y-m-d', strtotime("{$rd['start']} +$i days"));
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
} elseif ($rd['type'] === 'monthly') {
    $days = (int)date('t', strtotime($rd['start']));
    for ($i = 1; $i <= $days; $i++) {
        $d = date('Y-m-', strtotime($rd['start'])) . sprintf('%02d', $i);
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
} elseif ($rd['type'] === 'yearly') {
    for ($i = 1; $i <= 12; $i++) {
        $m = date('Y-', strtotime($rd['start'])) . sprintf('%02d', $i);
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

// Product Performance
$productLabels = [];
$productData = [];
$productColors = [];
$colors = ['#10B981', '#3B82F6', '#F59E0B', '#8B5CF6', '#EC4899', '#06B6D4', '#F97316'];
$colorMap = [];
$cIdx = 0;

$topProducts = [];

foreach ($rd['productStats'] as $ps) {
    if ($ps['revenue'] > 0) {
        $topProducts[] = $ps; // collect for table
        $productLabels[] = $ps['name'];
        $productData[] = $ps['revenue'];
        if (!isset($colorMap[$ps['line']])) {
            $colorMap[$ps['line']] = $colors[$cIdx % count($colors)];
            $cIdx++;
        }
        $productColors[] = $colorMap[$ps['line']];
    }
}

// Limit chart to top 15 products to avoid huge chart
$productLabels = array_slice($productLabels, 0, 15);
$productData = array_slice($productData, 0, 15);
$productColors = array_slice($productColors, 0, 15);
$topProducts = array_slice($topProducts, 0, 15);

// Build QuickChart URLs
$breakdownChartConfig = [
    'type' => 'bar',
    'data' => [
        'labels' => $breakdownLabels,
        'datasets' => [
            ['label' => 'Online', 'data' => $breakdownOnline, 'backgroundColor' => '#3B82F6'],
            ['label' => 'Offline', 'data' => $breakdownOffline, 'backgroundColor' => '#C9A84C']
        ]
    ],
    'options' => [
        'title' => ['display' => true, 'text' => 'Sales Breakdown Trend (RM)', 'fontSize' => 16],
        'legend' => ['position' => 'bottom'],
        'scales' => [
            'xAxes' => [['stacked' => true]],
            'yAxes' => [['stacked' => true]]
        ]
    ]
];
$breakdownUrl = 'https://quickchart.io/chart?w=600&h=300&c=' . urlencode(json_encode($breakdownChartConfig));

$productChartConfig = [
    'type' => 'horizontalBar',
    'data' => [
        'labels' => $productLabels,
        'datasets' => [
            ['label' => 'Revenue (RM)', 'data' => $productData, 'backgroundColor' => $productColors]
        ]
    ],
    'options' => [
        'title' => ['display' => true, 'text' => 'Top Products by Revenue (RM)', 'fontSize' => 16],
        'legend' => ['display' => false],
        'scales' => [
            'xAxes' => [['ticks' => ['beginAtZero' => true]]]
        ]
    ]
];
$productUrl = 'https://quickchart.io/chart?w=600&h=400&c=' . urlencode(json_encode($productChartConfig));

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Sales Report</title>
    <style>
        body { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 13px; color: #333; line-height: 1.5; }
        .header { border-bottom: 3px solid #00674F; padding-bottom: 15px; margin-bottom: 25px; display: table; width: 100%; }
        .header td { vertical-align: middle; }
        .title { color: #00674F; font-size: 26px; font-weight: bold; margin: 0; }
        .subtitle { color: #666; font-size: 15px; margin-top: 5px; font-weight: bold; }
        
        .kpi-container { width: 100%; margin-bottom: 30px; display: table; }
        .kpi-box { display: table-cell; width: 25%; text-align: center; padding: 15px 5px; border: 1px solid #e0e0e0; background-color: #f9f9f9; }
        .kpi-title { font-size: 11px; color: #666; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 5px; }
        .kpi-value { font-size: 20px; font-weight: bold; color: #00674F; }
        .kpi-value.blue { color: #3B82F6; }
        .kpi-value.gold { color: #C9A84C; }
        .kpi-value.green { color: #15803D; }
        
        .section-title { font-size: 18px; font-weight: bold; margin-top: 30px; margin-bottom: 15px; border-bottom: 1px solid #ddd; padding-bottom: 5px; color: #00674F; }
        .chart-container { text-align: center; margin-bottom: 30px; }
        .chart-container img { max-width: 100%; height: auto; border: 1px solid #eaeaea; border-radius: 8px; }
        
        .data-table { width: 100%; border-collapse: collapse; margin-bottom: 20px; font-size: 12px; }
        .data-table th, .data-table td { padding: 10px; border: 1px solid #eee; text-align: left; }
        .data-table th { background-color: #f5f5f5; color: #555; text-transform: uppercase; font-size: 10px; letter-spacing: 0.5px; }
        .data-table tr:nth-child(even) { background-color: #fafafa; }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
    </style>
</head>
<body>

<div class="header">
    <table style="width: 100%;">
        <tr>
            <td>
                <h1 class="title">MyBake Executive Sales Report</h1>
                <div class="subtitle"><?= $period ?></div>
            </td>
            <td style="text-align: right;">
                <div style="font-size: 11px; color: #999;">Generated On:</div>
                <div style="font-size: 13px; font-weight: bold; color: #444;"><?= $rd['generatedAt'] ?></div>
            </td>
        </tr>
    </table>
</div>

<div class="kpi-container">
    <div class="kpi-box">
        <div class="kpi-title">Online Sales (<?= count($rd['onlineOrders']) ?>)</div>
        <div class="kpi-value blue">RM <?= number_format($rd['onlineTotal'], 2) ?></div>
    </div>
    <div class="kpi-box">
        <div class="kpi-title">Offline Sales (<?= count($rd['offlineSales']) ?>)</div>
        <div class="kpi-value gold">RM <?= number_format($rd['offlineTotal'], 2) ?></div>
    </div>
    <div class="kpi-box" style="background-color: #f0fdf4; border-color: #dcfce7;">
        <div class="kpi-title">Est. Profit (50%)</div>
        <div class="kpi-value green">RM <?= number_format($rd['totalProfit'], 2) ?></div>
    </div>
    <div class="kpi-box" style="background-color: #f8fafc;">
        <div class="kpi-title">Grand Total</div>
        <div class="kpi-value">RM <?= number_format($rd['grandTotal'], 2) ?></div>
    </div>
</div>

<div class="section-title">Sales Breakdown Trend</div>
<div class="chart-container">
    <img src="<?= $breakdownUrl ?>" alt="Sales Breakdown Chart">
</div>

<?php if (count($topProducts) > 0): ?>
<div class="section-title" style="page-break-before: always;">Top Performing Products</div>
<div class="chart-container">
    <img src="<?= $productUrl ?>" alt="Product Performance Chart">
</div>

<table class="data-table">
    <thead>
        <tr>
            <th width="5%">#</th>
            <th width="45%">Product Name</th>
            <th width="25%">Category</th>
            <th width="10%" class="text-center">Qty Sold</th>
            <th width="15%" class="text-right">Revenue</th>
        </tr>
    </thead>
    <tbody>
        <?php $rank = 1; foreach ($topProducts as $ps): ?>
        <tr>
            <td class="text-center" style="font-weight: bold; color: #999;"><?= $rank++ ?></td>
            <td style="font-weight: bold;"><?= htmlspecialchars($ps['name']) ?></td>
            <td><?= htmlspecialchars($ps['line']) ?></td>
            <td class="text-center"><?= $ps['qty'] ?></td>
            <td class="text-right" style="color: #00674F; font-weight: bold;">RM <?= number_format($ps['revenue'], 2) ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?php endif; ?>

<div style="margin-top: 40px; text-align: center; font-size: 10px; color: #aaa; border-top: 1px solid #eee; padding-top: 10px;">
    &copy; <?= date('Y') ?> MyBake Executive Reporting. This document contains confidential summary information.
</div>

</body>
</html>
