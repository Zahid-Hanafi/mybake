<?php $this->assign('title', 'Admin Dashboard'); ?>

<!-- Stat Cards -->
<div style="display:grid; grid-template-columns:repeat(3,1fr); gap:1.25rem; margin-bottom:2rem;">
    <div class="stat-card emerald">
        <div style="display:flex; align-items:flex-start; justify-content:space-between; margin-bottom:1rem;">
            <div>
                <p class="stat-label">Total Revenue</p>
                <p class="stat-value" style="color:var(--primary-emerald);">RM <?= number_format($totalRevenue, 2) ?></p>
            </div>
            <div class="stat-icon" style="background:var(--primary-emerald-xlight); color:var(--primary-emerald);">
                <i class="fas fa-chart-line"></i>
            </div>
        </div>
        <div style="font-size:0.75rem; color:var(--text-muted);">
            Online: <strong style="color:var(--primary-emerald);">RM <?= number_format($onlineRevenue, 2) ?></strong> &nbsp;|&nbsp;
            Offline: <strong style="color:var(--secondary-gold-dark);">RM <?= number_format($offlineRevenue, 2) ?></strong>
        </div>
    </div>

    <div class="stat-card gold">
        <div style="display:flex; align-items:flex-start; justify-content:space-between; margin-bottom:1rem;">
            <div>
                <p class="stat-label">Total Profit (est.)</p>
                <p class="stat-value" style="color:var(--secondary-gold-dark);">RM <?= number_format($totalProfit, 2) ?></p>
            </div>
            <div class="stat-icon" style="background:var(--secondary-gold-xlight); color:var(--secondary-gold-dark);">
                <i class="fas fa-coins"></i>
            </div>
        </div>
        <div style="font-size:0.75rem; color:var(--text-muted);">Based on 50% profit margin</div>
    </div>

    <div class="stat-card green">
        <div style="display:flex; align-items:flex-start; justify-content:space-between; margin-bottom:1rem;">
            <div>
                <p class="stat-label">Total Orders</p>
                <p class="stat-value" style="color:#15803D;"><?= $totalOrders ?></p>
            </div>
            <div class="stat-icon" style="background:#DCFCE7; color:#15803D;">
                <i class="fas fa-bag-shopping"></i>
            </div>
        </div>
        <div style="font-size:0.75rem; color:var(--text-muted);">All time online orders</div>
    </div>
</div>

<!-- Revenue Chart -->
<div style="display:grid; grid-template-columns:1fr 340px; gap:1.5rem; margin-bottom:2rem; align-items:start;">
    <div style="background:#fff; border-radius:20px; border:1px solid var(--border-light); padding:1.5rem; box-shadow:var(--shadow-sm);">
        <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:1.5rem;">
            <div>
                <h2 style="font-size:1rem; font-weight:700;">Revenue Overview</h2>
                <p style="color:var(--text-muted); font-size:0.8rem;">Last 6 months — online vs offline</p>
            </div>
            <div style="display:flex; align-items:center; gap:1rem; font-size:0.75rem;">
                <span style="display:flex; align-items:center; gap:0.4rem;"><span style="width:12px; height:12px; border-radius:3px; background:var(--primary-emerald); display:inline-block;"></span> Online</span>
                <span style="display:flex; align-items:center; gap:0.4rem;"><span style="width:12px; height:12px; border-radius:3px; background:var(--secondary-gold); display:inline-block;"></span> Offline</span>
            </div>
        </div>
        <div style="position:relative; height:280px; width:100%;">
            <canvas id="revenueChart"></canvas>
        </div>
    </div>

    <!-- Quick Actions -->
    <div style="display:flex; flex-direction:column; gap:1rem;">
        <a href="<?= $this->Url->build('/admin/orders') ?>" style="background:#fff; border-radius:16px; border:1px solid var(--border-light); padding:1.25rem; display:flex; align-items:center; gap:1rem; text-decoration:none; color:var(--text-dark); transition:var(--transition); box-shadow:var(--shadow-sm);" onmouseover="this.style.borderColor='var(--primary-emerald)'; this.style.boxShadow='var(--shadow-md)';" onmouseout="this.style.borderColor='var(--border-light)'; this.style.boxShadow='var(--shadow-sm)';">
            <div style="width:48px; height:48px; background:var(--primary-emerald-xlight); border-radius:12px; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                <i class="fas fa-clipboard-list" style="color:var(--primary-emerald); font-size:1.2rem;"></i>
            </div>
            <div>
                <div style="font-weight:700; font-size:0.9rem;">Manage Orders</div>
                <div style="font-size:0.75rem; color:var(--text-muted);">Update order statuses</div>
            </div>
            <i class="fas fa-chevron-right" style="margin-left:auto; color:var(--text-muted); font-size:0.75rem;"></i>
        </a>

        <a href="<?= $this->Url->build('/admin/sales/add') ?>" style="background:#fff; border-radius:16px; border:1px solid var(--border-light); padding:1.25rem; display:flex; align-items:center; gap:1rem; text-decoration:none; color:var(--text-dark); transition:var(--transition); box-shadow:var(--shadow-sm);" onmouseover="this.style.borderColor='var(--secondary-gold)'; this.style.boxShadow='var(--shadow-md)';" onmouseout="this.style.borderColor='var(--border-light)'; this.style.boxShadow='var(--shadow-sm)';">
            <div style="width:48px; height:48px; background:var(--secondary-gold-xlight); border-radius:12px; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                <i class="fas fa-plus-circle" style="color:var(--secondary-gold-dark); font-size:1.2rem;"></i>
            </div>
            <div>
                <div style="font-weight:700; font-size:0.9rem;">Add Offline Sale</div>
                <div style="font-size:0.75rem; color:var(--text-muted);">Record in-store sales</div>
            </div>
            <i class="fas fa-chevron-right" style="margin-left:auto; color:var(--text-muted); font-size:0.75rem;"></i>
        </a>

        <a href="<?= $this->Url->build('/admin/sales/report') ?>" style="background:#fff; border-radius:16px; border:1px solid var(--border-light); padding:1.25rem; display:flex; align-items:center; gap:1rem; text-decoration:none; color:var(--text-dark); transition:var(--transition); box-shadow:var(--shadow-sm);" onmouseover="this.style.borderColor='#15803D'; this.style.boxShadow='var(--shadow-md)';" onmouseout="this.style.borderColor='var(--border-light)'; this.style.boxShadow='var(--shadow-sm)';">
            <div style="width:48px; height:48px; background:#DCFCE7; border-radius:12px; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                <i class="fas fa-file-pdf" style="color:#15803D; font-size:1.2rem;"></i>
            </div>
            <div>
                <div style="font-weight:700; font-size:0.9rem;">Generate Report</div>
                <div style="font-size:0.75rem; color:var(--text-muted);">View sales reports</div>
            </div>
            <i class="fas fa-chevron-right" style="margin-left:auto; color:var(--text-muted); font-size:0.75rem;"></i>
        </a>

        <a href="<?= $this->Url->build('/admin/stock') ?>" style="background:#fff; border-radius:16px; border:1px solid var(--border-light); padding:1.25rem; display:flex; align-items:center; gap:1rem; text-decoration:none; color:var(--text-dark); transition:var(--transition); box-shadow:var(--shadow-sm);" onmouseover="this.style.borderColor='#7C3AED'; this.style.boxShadow='var(--shadow-md)';" onmouseout="this.style.borderColor='var(--border-light)'; this.style.boxShadow='var(--shadow-sm)';">
            <div style="width:48px; height:48px; background:#F5F3FF; border-radius:12px; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                <i class="fas fa-boxes-stacked" style="color:#7C3AED; font-size:1.2rem;"></i>
            </div>
            <div>
                <div style="font-weight:700; font-size:0.9rem;">Stock Management</div>
                <div style="font-size:0.75rem; color:var(--text-muted);">Restock & status control</div>
            </div>
            <i class="fas fa-chevron-right" style="margin-left:auto; color:var(--text-muted); font-size:0.75rem;"></i>
        </a>
    </div>
</div>

<!-- Stock Table -->
<div style="background:#fff; border-radius:20px; border:1px solid var(--border-light); overflow:hidden; box-shadow:var(--shadow-sm);">
    <div style="padding:1.25rem 1.5rem; border-bottom:1px solid var(--border-light); display:flex; align-items:center; justify-content:space-between;">
        <div style="font-weight:700; font-size:1rem; display:flex; align-items:center; gap:0.6rem;">
            <i class="fas fa-boxes-stacked" style="color:var(--primary-emerald);"></i> Product Stock Overview
        </div>
        <a href="<?= $this->Url->build('/admin/stock') ?>" class="btn btn-outline btn-sm">Manage All</a>
    </div>

    <div class="table-wrapper" style="border-radius:0; border:none;">
        <table>
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Category</th>
                    <th>Price</th>
                    <th>Stock</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($products as $product): ?>
                <?php
                $stockLevel = $product->stock_quantity > 50 ? 'high' : ($product->stock_quantity > 10 ? 'medium' : ($product->stock_quantity > 0 ? 'low' : 'out'));
                $stockClass = ['high'=>'stock-high','medium'=>'stock-medium','low'=>'stock-low','out'=>'stock-out'][$stockLevel];
                ?>
                <tr id="row-<?= $product->id ?>">
                    <td style="font-weight:600;"><?= h($product->name) ?></td>
                    <td style="color:var(--text-muted); font-size:0.85rem;"><?= h($product->product_line->name ?? '—') ?></td>
                    <td>RM <?= number_format($product->price, 2) ?></td>
                    <td>
                        <span class="product-stock <?= $stockClass ?>" id="stock-<?= $product->id ?>"><?= $product->stock_quantity ?> pcs</span>
                    </td>
                    <td>
                        <span class="status-badge status-<?= $product->status ?>" id="statusBadge-<?= $product->id ?>">
                            <?= ucfirst($product->status) ?>
                        </span>
                    </td>
                    <td>
                        <div style="display:flex; gap:0.5rem; align-items:center;">
                            <button onclick="openRestockModal(<?= $product->id ?>, '<?= h(addslashes($product->name)) ?>')"
                                    class="btn btn-outline btn-sm" title="Restock">
                                <i class="fas fa-plus"></i>
                            </button>
                            <button onclick="toggleProductStatus(<?= $product->id ?>, this)"
                                    class="btn btn-sm <?= $product->status === 'open' ? 'btn-danger' : '' ?>"
                                    style="<?= $product->status !== 'open' ? 'background:var(--primary-emerald); color:#fff;' : '' ?>"
                                    title="<?= $product->status === 'open' ? 'Close' : 'Open' ?> product">
                                <i class="fas fa-<?= $product->status === 'open' ? 'lock' : 'lock-open' ?>"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Restock Modal -->
<div class="modal-overlay" id="restockModal">
    <div class="modal" style="max-width:380px;">
        <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:1.25rem;">
            <h3 style="font-family:'Playfair Display',serif; font-size:1.2rem;">Restock Product</h3>
            <button onclick="document.getElementById('restockModal').classList.remove('open')" style="background:none; border:none; cursor:pointer; color:var(--text-muted);">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <p style="color:var(--text-muted); font-size:0.875rem; margin-bottom:1.25rem;" id="restockProductName">—</p>
        <div class="form-group">
            <label class="form-label">Add Quantity</label>
            <input type="number" id="restockQty" min="1" value="10" class="form-control" placeholder="Enter quantity to add">
        </div>
        <button onclick="confirmRestock()" class="btn btn-primary btn-full">
            <i class="fas fa-plus"></i> Add Stock
        </button>
    </div>
</div>

<?php $this->Html->scriptStart(['block' => true]); ?>
// Chart.js Revenue
const chartData = <?= json_encode($chartData) ?>;
const ctx = document.getElementById('revenueChart');
if (ctx) {
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: chartData.map(d => d.label),
            datasets: [
                {
                    label: 'Online',
                    data: chartData.map(d => d.online),
                    backgroundColor: 'rgba(16,185,129,0.7)',
                    borderColor: 'var(--primary-emerald)',
                    borderWidth: 2,
                    borderRadius: 6,
                },
                {
                    label: 'Offline',
                    data: chartData.map(d => d.offline),
                    backgroundColor: 'rgba(201,168,76,0.7)',
                    borderColor: 'var(--secondary-gold)',
                    borderWidth: 2,
                    borderRadius: 6,
                },
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    callbacks: {
                        label: ctx => 'RM ' + ctx.parsed.y.toFixed(2)
                    }
                }
            },
            scales: {
                x: { grid: { display: false } },
                y: {
                    beginAtZero: true,
                    ticks: { callback: v => 'RM ' + v.toLocaleString() },
                    grid: { color: 'rgba(0,0,0,0.04)' }
                }
            }
        }
    });
}

// Restock
let _restockId = null;
function openRestockModal(id, name) {
    _restockId = id;
    document.getElementById('restockProductName').textContent = 'Product: ' + name;
    document.getElementById('restockQty').value = 10;
    document.getElementById('restockModal').classList.add('open');
}
function confirmRestock() {
    const qty = parseInt(document.getElementById('restockQty').value);
    if (!qty || qty < 1) return;
    const form = new FormData();
    form.append('quantity', qty);
    fetch('<?= $this->Url->build('/admin/stock/restock/') ?>' + _restockId, { method: 'POST', body: form })
        .then(r => r.json())
        .then(d => {
            if (d.success) {
                const el = document.getElementById('stock-' + _restockId);
                if (el) el.textContent = d.stock + ' pcs';
                document.getElementById('restockModal').classList.remove('open');
                showFlash('success', 'Stock updated to ' + d.stock + ' pcs');
            }
        });
}
function toggleProductStatus(id, btn) {
    fetch('<?= $this->Url->build('/admin/stock/toggle/') ?>' + id, { method: 'POST' })
        .then(r => r.json())
        .then(d => {
            if (d.success) {
                const badge = document.getElementById('statusBadge-' + id);
                if (d.status === 'open') {
                    badge.className = 'status-badge status-open'; badge.textContent = 'Open';
                    btn.innerHTML = '<i class="fas fa-lock"></i>';
                    btn.className = 'btn btn-sm btn-danger';
                } else {
                    badge.className = 'status-badge status-closed'; badge.textContent = 'Closed';
                    btn.innerHTML = '<i class="fas fa-lock-open"></i>';
                    btn.style.cssText = 'background:var(--primary-emerald); color:#fff;';
                }
            }
        });
}
document.getElementById('restockModal').addEventListener('click', function(e) {
    if (e.target === this) this.classList.remove('open');
});
<?php $this->Html->scriptEnd(); ?>

<style>
@media(max-width:1100px){ [style*="grid-template-columns:1fr 340px"]{grid-template-columns:1fr!important;} }
@media(max-width:640px) { [style*="grid-template-columns:repeat(3,1fr)"]{grid-template-columns:1fr!important;} }
</style>
