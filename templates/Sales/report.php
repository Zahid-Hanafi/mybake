<?php $this->assign('title', 'Sales Report'); ?>

<!-- Report Filters -->
<div style="background:#fff; border-radius:16px; padding:1.25rem; border:1px solid var(--border-light); margin-bottom:1.5rem; box-shadow:var(--shadow-sm);">
    <form method="get" action="<?= $this->Url->build('/admin/sales/report') ?>" style="display:flex; flex-wrap:wrap; gap:0.875rem; align-items:flex-end;">
        <div>
            <label class="form-label" style="margin-bottom:0.3rem;">Report Type</label>
            <select name="type" class="form-control" style="min-width:140px;" onchange="this.form.submit()">
                <option value="daily"   <?= $type === 'daily'   ? 'selected' : '' ?>>Daily</option>
                <option value="weekly"  <?= $type === 'weekly'  ? 'selected' : '' ?>>Weekly</option>
                <option value="monthly" <?= $type === 'monthly' ? 'selected' : '' ?>>Monthly</option>
            </select>
        </div>
        <div>
            <label class="form-label" style="margin-bottom:0.3rem;">Date</label>
            <input type="date" name="date" value="<?= h($date) ?>" class="form-control">
        </div>
        <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i> Generate</button>
        <a href="<?= $this->Url->build('/admin/sales/report?type=' . h($type) . '&date=' . h($date) . '&format=pdf') ?>" class="btn btn-gold" target="_blank">
            <i class="fas fa-file-pdf"></i> Export PDF
        </a>
    </form>
</div>

<?php
$rd = $reportData;
$period = $type === 'daily' ? "Daily Report — " . date('d M Y', strtotime($start))
    : ($type === 'weekly' ? "Weekly Report — " . date('d M', strtotime($start)) . " to " . date('d M Y', strtotime($end))
    : "Monthly Report — " . date('F Y', strtotime($start)));
?>

<!-- Period Header -->
<div style="background:linear-gradient(135deg,var(--primary-emerald-dark),var(--primary-emerald)); border-radius:16px; padding:1.5rem; margin-bottom:1.5rem; color:#fff; display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:1rem;">
    <div>
        <p style="font-size:0.75rem; opacity:0.7; text-transform:uppercase; letter-spacing:0.08em; margin-bottom:0.25rem;">Sales Report</p>
        <h2 style="font-family:'Playfair Display',serif; font-size:1.35rem; font-weight:700;"><?= $period ?></h2>
        <p style="font-size:0.75rem; opacity:0.6; margin-top:0.25rem;">Generated: <?= $rd['generatedAt'] ?></p>
    </div>
    <div style="display:flex; gap:1.5rem; flex-wrap:wrap;">
        <div style="text-align:center;">
            <div style="font-family:'Playfair Display',serif; font-size:1.5rem; font-weight:700; color:var(--secondary-gold-light);">RM <?= number_format($rd['grandTotal'], 2) ?></div>
            <div style="font-size:0.72rem; opacity:0.7;">Grand Total</div>
        </div>
        <div style="text-align:center;">
            <div style="font-family:'Playfair Display',serif; font-size:1.5rem; font-weight:700; color:var(--secondary-gold-light);">RM <?= number_format($rd['totalProfit'], 2) ?></div>
            <div style="font-size:0.72rem; opacity:0.7;">Total Profit</div>
        </div>
    </div>
</div>

<!-- Summary Cards -->
<div style="display:grid; grid-template-columns:repeat(3,1fr); gap:1.25rem; margin-bottom:2rem;">
    <div class="stat-card emerald">
        <p class="stat-label">Online Sales</p>
        <p class="stat-value" style="color:var(--primary-emerald);">RM <?= number_format($rd['onlineTotal'], 2) ?></p>
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

<!-- Online Orders Table -->
<?php if (count($rd['onlineOrders']) > 0): ?>
<div style="background:#fff; border-radius:20px; border:1px solid var(--border-light); overflow:hidden; margin-bottom:1.5rem; box-shadow:var(--shadow-sm);">
    <div style="padding:1.25rem 1.5rem; border-bottom:1px solid var(--border-light); font-weight:700; display:flex; align-items:center; gap:0.6rem;">
        <i class="fas fa-globe" style="color:var(--primary-emerald);"></i> Online Orders
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
                    <td style="font-weight:700; color:var(--primary-emerald);">RM <?= number_format($o->total_amount, 2) ?></td>
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

<style>@media(max-width:640px){ [style*="grid-template-columns:repeat(3,1fr)"]{grid-template-columns:1fr!important;} }</style>
