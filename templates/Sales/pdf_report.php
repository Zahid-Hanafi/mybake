<?php
$rd = $reportData;
$period = $rd['type'] === 'daily' ? "Daily Report - " . date('d M Y', strtotime($rd['start']))
    : ($rd['type'] === 'weekly' ? "Weekly Report - " . date('d M', strtotime($rd['start'])) . " to " . date('d M Y', strtotime($rd['end']))
    : "Monthly Report - " . date('F Y', strtotime($rd['start'])));
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Sales Report</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; color: #333; }
        .header { border-bottom: 2px solid #00674F; padding-bottom: 10px; margin-bottom: 20px; }
        .title { color: #00674F; font-size: 24px; font-weight: bold; margin: 0; }
        .subtitle { color: #666; font-size: 14px; margin-top: 5px; }
        .summary-table { width: 100%; margin-bottom: 30px; border-collapse: collapse; }
        .summary-table th, .summary-table td { padding: 10px; border: 1px solid #ddd; text-align: center; }
        .summary-table th { background-color: #f5f5f5; color: #333; }
        .section-title { font-size: 16px; font-weight: bold; margin-bottom: 10px; border-bottom: 1px solid #ddd; padding-bottom: 5px; color: #00674F; }
        .data-table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        .data-table th, .data-table td { padding: 8px; border: 1px solid #ddd; text-align: left; }
        .data-table th { background-color: #f5f5f5; }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .total-row { font-weight: bold; background-color: #f9f9f9; }
    </style>
</head>
<body>

<div class="header">
    <table style="width: 100%;">
        <tr>
            <td>
                <h1 class="title">MyBake Sales Report</h1>
                <div class="subtitle"><?= $period ?></div>
                <div style="font-size: 10px; color: #999; margin-top: 5px;">Generated: <?= $rd['generatedAt'] ?></div>
            </td>
        </tr>
    </table>
</div>

<table class="summary-table">
    <tr>
        <th>Online Sales</th>
        <th>Offline Sales</th>
        <th>Grand Total</th>
        <th>Est. Profit (50%)</th>
    </tr>
    <tr>
        <td>RM <?= number_format($rd['onlineTotal'], 2) ?><br><small>(<?= count($rd['onlineOrders']) ?> orders)</small></td>
        <td>RM <?= number_format($rd['offlineTotal'], 2) ?><br><small>(<?= count($rd['offlineSales']) ?> records)</small></td>
        <td style="font-weight: bold; color: #00674F;">RM <?= number_format($rd['grandTotal'], 2) ?></td>
        <td style="font-weight: bold; color: #15803D;">RM <?= number_format($rd['totalProfit'], 2) ?></td>
    </tr>
</table>

<?php if (count($rd['onlineOrders']) > 0): ?>
<div class="section-title">Online Orders</div>
<table class="data-table">
    <thead>
        <tr>
            <th width="15%">Date</th>
            <th width="25%">Customer</th>
            <th width="45%">Items</th>
            <th width="15%" class="text-right">Amount</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($rd['onlineOrders'] as $o): ?>
        <tr>
            <td><?= $o->created_at ? $o->created_at->format('d M Y') : '—' ?></td>
            <td><?= $o->user ? htmlspecialchars($o->user->first_name . ' ' . $o->user->last_name) : 'Guest' ?></td>
            <td>
                <?php foreach ($o->order_items as $oi): ?>
                    <div><?= htmlspecialchars($oi->product_name) ?> &times; <?= $oi->quantity ?></div>
                <?php endforeach; ?>
            </td>
            <td class="text-right">RM <?= number_format($o->total_amount, 2) ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?php endif; ?>

<?php if (count($rd['offlineSales']) > 0): ?>
<div class="section-title">Offline Sales</div>
<table class="data-table">
    <thead>
        <tr>
            <th width="15%">Date</th>
            <th width="25%">Recorded By</th>
            <th width="45%">Items</th>
            <th width="15%" class="text-right">Amount</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($rd['offlineSales'] as $s): ?>
        <tr>
            <td><?= $s->sale_date ? (method_exists($s->sale_date, 'format') ? $s->sale_date->format('d M Y') : $s->sale_date) : '—' ?></td>
            <td><?= $s->user ? htmlspecialchars($s->user->first_name) : 'Admin' ?></td>
            <td>
                <?php foreach ($s->offline_sale_items as $oi): ?>
                    <div><?= htmlspecialchars($oi->product_name) ?> &times; <?= $oi->quantity ?></div>
                <?php endforeach; ?>
            </td>
            <td class="text-right">RM <?= number_format($s->total_amount, 2) ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?php endif; ?>

<?php if (count($rd['onlineOrders']) === 0 && count($rd['offlineSales']) === 0): ?>
    <div style="text-align: center; padding: 50px; color: #999;">No sales data found for the selected period.</div>
<?php endif; ?>

</body>
</html>
