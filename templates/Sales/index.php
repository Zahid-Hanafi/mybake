<?php $this->assign('title', 'Sales Management'); ?>

<!-- Stats -->
<div style="display:grid; grid-template-columns:repeat(3,1fr); gap:1.25rem; margin-bottom:2rem;">
    <div class="stat-card gold">
        <div style="display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:0.75rem;">
            <p class="stat-label">Total Offline Revenue</p>
            <div class="stat-icon" style="background:var(--secondary-gold-xlight); color:var(--secondary-gold-dark);"><i class="fas fa-store"></i></div>
        </div>
        <p class="stat-value" style="color:var(--secondary-gold-dark);">RM <?= number_format($totalRevenue, 2) ?></p>
    </div>
    <div class="stat-card teal">
        <div style="display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:0.75rem;">
            <p class="stat-label">Estimated Profit</p>
            <div class="stat-icon" style="background:var(--primary-teal-xlight); color:var(--primary-teal);"><i class="fas fa-coins"></i></div>
        </div>
        <p class="stat-value" style="color:var(--primary-teal);">RM <?= number_format($totalProfit, 2) ?></p>
    </div>
    <div class="stat-card green">
        <div style="display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:0.75rem;">
            <p class="stat-label">Total Records</p>
            <div class="stat-icon" style="background:#DCFCE7; color:#15803D;"><i class="fas fa-file-invoice"></i></div>
        </div>
        <p class="stat-value" style="color:#15803D;"><?= count($sales) ?></p>
    </div>
</div>

<!-- Action Buttons -->
<div style="display:flex; gap:1rem; margin-bottom:1.5rem; flex-wrap:wrap;">
    <a href="<?= $this->Url->build('/admin/sales/add') ?>" class="btn btn-primary"><i class="fas fa-plus"></i> Add Offline Sale</a>
    <a href="<?= $this->Url->build('/admin/sales/report') ?>" class="btn btn-gold"><i class="fas fa-file-pdf"></i> Generate Report</a>
</div>

<!-- Sales Table -->
<div style="background:#fff; border-radius:20px; border:1px solid var(--border-light); overflow:hidden; box-shadow:var(--shadow-sm);">
    <div style="padding:1.25rem 1.5rem; border-bottom:1px solid var(--border-light);">
        <h2 style="font-size:1rem; font-weight:700; display:flex; align-items:center; gap:0.6rem;">
            <i class="fas fa-store" style="color:var(--secondary-gold-dark);"></i> Offline Sales Records
        </h2>
    </div>

    <?php if (empty($sales) || count($sales) === 0): ?>
    <div style="text-align:center; padding:3rem 2rem; color:var(--text-muted);">
        <i class="fas fa-inbox" style="font-size:3rem; opacity:0.25; display:block; margin-bottom:1rem;"></i>
        <p>No offline sales records yet. <a href="<?= $this->Url->build('/admin/sales/add') ?>" style="color:var(--primary-teal); font-weight:600;">Add one now</a>.</p>
    </div>
    <?php else: ?>
    <div class="table-wrapper" style="border:none; border-radius:0;">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Sale Date</th>
                    <th>Items Sold</th>
                    <th>Total Amount</th>
                    <th>Profit (50%)</th>
                    <th>Recorded By</th>
                </tr>
            </thead>
            <tbody>
                <?php $n = 1; foreach ($sales as $sale): ?>
                <tr>
                    <td style="font-weight:600; color:var(--text-muted);"><?= $n++ ?></td>
                    <td style="font-weight:600;"><?= $sale->sale_date instanceof \Cake\I18n\Date ? $sale->sale_date->format('d M Y') : ($sale->sale_date ?? '—') ?></td>
                    <td>
                        <?php foreach ($sale->offline_sale_items as $oi): ?>
                        <div style="font-size:0.78rem; color:var(--text-muted);"><?= h($oi->product_name) ?> ×<?= $oi->quantity ?></div>
                        <?php endforeach; ?>
                    </td>
                    <td style="font-weight:700; color:var(--secondary-gold-dark);">RM <?= number_format($sale->total_amount, 2) ?></td>
                    <td style="font-weight:600; color:#15803D;">RM <?= number_format($sale->total_amount * 0.5, 2) ?></td>
                    <td style="font-size:0.85rem; color:var(--text-muted);"><?= $sale->user ? h($sale->user->first_name . ' ' . $sale->user->last_name) : 'Admin' ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php endif; ?>
</div>
