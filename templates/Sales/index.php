<?php $this->assign('title', 'Sales Management'); ?>

<!-- Global Year Filter -->
<div style="display:flex; justify-content:flex-end; margin-bottom: 1.5rem;">
    <div style="display:flex; align-items:center; gap:0.5rem; background:#fff; padding:0.5rem 1rem; border-radius:12px; border:1px solid var(--border-light); box-shadow:var(--shadow-sm);">
        <label style="font-size:0.875rem; font-weight:600; color:var(--text-muted); margin:0;">Sales Year:</label>
        <select id="globalYear" onchange="window.location.href='?year='+this.value" class="form-control" style="width:auto; font-size:0.875rem; padding:0.3rem 1.5rem 0.3rem 0.6rem; border:none; background:transparent; font-weight:700; color:var(--primary-emerald); cursor:pointer;">
            <?php foreach ($availableYears as $y): ?>
            <option value="<?= $y ?>" <?= $y == $selectedYear ? 'selected' : '' ?>><?= $y ?></option>
            <?php endforeach; ?>
        </select>
    </div>
</div>

<!-- Stats -->
<div style="display:grid; grid-template-columns:repeat(4,1fr); gap:1.25rem; margin-bottom:2rem;">
    <div class="stat-card emerald">
        <div style="display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:0.75rem;">
            <p class="stat-label">Total Revenue</p>
            <div class="stat-icon" style="background:var(--primary-emerald-xlight); color:var(--primary-emerald);"><i class="fas fa-chart-line"></i></div>
        </div>
        <p class="stat-value" style="color:var(--primary-emerald);">RM <?= number_format($totalRevenue, 2) ?></p>
    </div>
    <div class="stat-card" style="border-left:4px solid #3B82F6;">
        <div style="display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:0.75rem;">
            <p class="stat-label">Online Revenue</p>
            <div class="stat-icon" style="background:#EFF6FF; color:#3B82F6;"><i class="fas fa-globe"></i></div>
        </div>
        <p class="stat-value" style="color:#3B82F6;">RM <?= number_format($onlineRevenue, 2) ?></p>
    </div>
    <div class="stat-card gold">
        <div style="display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:0.75rem;">
            <p class="stat-label">Offline Revenue</p>
            <div class="stat-icon" style="background:var(--secondary-gold-xlight); color:var(--secondary-gold-dark);"><i class="fas fa-store"></i></div>
        </div>
        <p class="stat-value" style="color:var(--secondary-gold-dark);">RM <?= number_format($offlineRevenue, 2) ?></p>
    </div>
    <div class="stat-card green">
        <div style="display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:0.75rem;">
            <p class="stat-label">Estimated Profit (50%)</p>
            <div class="stat-icon" style="background:#DCFCE7; color:#15803D;"><i class="fas fa-coins"></i></div>
        </div>
        <p class="stat-value" style="color:#15803D;">RM <?= number_format($totalProfit, 2) ?></p>
    </div>
</div>

<!-- Extra Stats Row -->
<div style="display:grid; grid-template-columns:repeat(2,1fr); gap:1.25rem; margin-bottom:2rem;">
    <div class="stat-card" style="border-left:4px solid #8B5CF6;">
        <div style="display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:0.75rem;">
            <p class="stat-label">Total Online Orders</p>
            <div class="stat-icon" style="background:#F5F3FF; color:#8B5CF6;"><i class="fas fa-bag-shopping"></i></div>
        </div>
        <p class="stat-value" style="color:#8B5CF6;"><?= count($onlineOrders) ?></p>
    </div>
    <div class="stat-card" style="border-left:4px solid #F59E0B;">
        <div style="display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:0.75rem;">
            <p class="stat-label">Total Offline Records</p>
            <div class="stat-icon" style="background:#FEF3C7; color:#F59E0B;"><i class="fas fa-file-invoice"></i></div>
        </div>
        <p class="stat-value" style="color:#F59E0B;"><?= count($sales) ?></p>
    </div>
</div>

<!-- Action Buttons & Filters -->
<div style="display:flex; gap:1rem; margin-bottom:1.5rem; flex-wrap:wrap; justify-content:space-between; align-items:center;">
    <div style="display:flex; gap:1rem;">
        <a href="<?= $this->Url->build('/admin/sales/add') ?>" class="btn btn-primary"><i class="fas fa-plus"></i> Add Offline Sale</a>
        <button type="button" class="btn btn-gold" onclick="document.getElementById('reportModal').classList.add('open')"><i class="fas fa-file-pdf"></i> Generate Report</button>
    </div>
    
    <div style="display:flex; gap:1rem; align-items:center; flex-wrap:wrap;">
        <select id="salesFilter" style="padding:0.6rem 1rem; border-radius:10px; border:1px solid var(--border-light); outline:none; background:#fff; font-family:'Inter',sans-serif;" onchange="filterSales()">
            <option value="all">All Sales</option>
            <option value="online">Online Orders Only</option>
            <option value="offline">Offline Sales Only</option>
        </select>
        
        <div style="position:relative;">
            <i class="fas fa-search" style="position:absolute; left:1rem; top:50%; transform:translateY(-50%); color:var(--text-muted);"></i>
            <input type="text" id="salesSearch" placeholder="Search by customer, date, items..." style="padding:0.6rem 1rem 0.6rem 2.5rem; border-radius:10px; border:1px solid var(--border-light); width:280px; outline:none; font-family:'Inter',sans-serif;" onkeyup="filterSales()">
        </div>
    </div>
</div>

<!-- Online Orders Table -->
<div id="onlineOrdersSection" style="background:#fff; border-radius:20px; border:1px solid var(--border-light); overflow:hidden; box-shadow:var(--shadow-sm); margin-bottom:2rem;">
    <div style="padding:1.25rem 1.5rem; border-bottom:1px solid var(--border-light);">
        <h2 style="font-size:1rem; font-weight:700; display:flex; align-items:center; gap:0.6rem;">
            <i class="fas fa-globe" style="color:#3B82F6;"></i> Online Orders
        </h2>
    </div>
    <?php if (empty($onlineOrders) || count($onlineOrders) === 0): ?>
    <div style="text-align:center; padding:3rem 2rem; color:var(--text-muted);">
        <i class="fas fa-inbox" style="font-size:3rem; opacity:0.25; display:block; margin-bottom:1rem;"></i>
        <p>No online orders found.</p>
    </div>
    <?php else: ?>
    <div class="table-wrapper" style="border:none; border-radius:0;">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Date</th>
                    <th>Customer</th>
                    <th>Items</th>
                    <th>Total Amount</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php $n = 1; foreach ($onlineOrders as $o): ?>
                <tr class="sales-row online-row">
                    <td style="font-weight:600; color:var(--text-muted);"><?= $n++ ?></td>
                    <td style="font-weight:600;"><?= $o->created_at ? $o->created_at->format('d M Y') : '—' ?></td>
                    <td style="font-size:0.9rem;"><?= $o->user ? h($o->user->first_name . ' ' . $o->user->last_name) : 'Guest' ?></td>
                    <td>
                        <?php foreach ($o->order_items as $oi): ?>
                        <div style="font-size:0.78rem; color:var(--text-muted);"><?= h($oi->product_name) ?> ×<?= $oi->quantity ?></div>
                        <?php endforeach; ?>
                    </td>
                    <td style="font-weight:700; color:#3B82F6;">RM <?= number_format($o->total_amount, 2) ?></td>
                    <td>
                        <?php if ($o->status === 'preparing'): ?>
                            <span class="status-badge" style="background:#DBEAFE; color:#1E40AF;">Preparing</span>
                        <?php elseif ($o->status === 'shipping'): ?>
                            <span class="status-badge" style="background:#FEF3C7; color:#92400E;">Shipping</span>
                        <?php elseif ($o->status === 'complete'): ?>
                            <span class="status-badge" style="background:#DCFCE7; color:#166534;">Complete</span>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php endif; ?>
</div>

<!-- Offline Sales Table -->
<div id="offlineSalesSection" style="background:#fff; border-radius:20px; border:1px solid var(--border-light); overflow:hidden; box-shadow:var(--shadow-sm);">
    <div style="padding:1.25rem 1.5rem; border-bottom:1px solid var(--border-light);">
        <h2 style="font-size:1rem; font-weight:700; display:flex; align-items:center; gap:0.6rem;">
            <i class="fas fa-store" style="color:var(--secondary-gold-dark);"></i> Offline Sales Records
        </h2>
    </div>

    <?php if (empty($sales) || count($sales) === 0): ?>
    <div style="text-align:center; padding:3rem 2rem; color:var(--text-muted);">
        <i class="fas fa-inbox" style="font-size:3rem; opacity:0.25; display:block; margin-bottom:1rem;"></i>
        <p>No offline sales records yet. <a href="<?= $this->Url->build('/admin/sales/add') ?>" style="color:var(--primary-emerald); font-weight:600;">Add one now</a>.</p>
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
                <tr class="sales-row offline-row">
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

<!-- Report Generation Modal -->
<div id="reportModal" class="modal-overlay">
    <div class="modal">
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:1.5rem;">
            <h3 style="font-size:1.2rem; font-weight:700;">Generate Sales Report</h3>
            <button class="modal-close" onclick="document.getElementById('reportModal').classList.remove('open')"><i class="fas fa-times"></i></button>
        </div>
        <form method="get" action="<?= $this->Url->build('/admin/sales/report') ?>">
            <div class="form-group">
                <label class="form-label">Report Type</label>
                <select name="type" id="reportType" class="form-control" onchange="updateReportDateInput()">
                    <option value="daily">Daily</option>
                    <option value="weekly">Weekly</option>
                    <option value="monthly">Monthly</option>
                    <option value="yearly">Yearly</option>
                </select>
            </div>
            
            <div class="form-group" id="dateInputContainer">
                <label class="form-label" id="dateLabel">Select Date</label>
                <input type="date" name="date" id="reportDate" class="form-control" value="<?= date('Y-m-d') ?>" required>
            </div>
            
            <div style="display:flex; justify-content:flex-end; gap:0.5rem; margin-top:2rem;">
                <button type="button" class="btn btn-outline" onclick="document.getElementById('reportModal').classList.remove('open')">Cancel</button>
                <button type="submit" class="btn btn-primary"><i class="fas fa-file-invoice"></i> Generate Report</button>
            </div>
        </form>
    </div>
</div>

<script>
function filterSales() {
    const filter = document.getElementById('salesFilter').value;
    const search = document.getElementById('salesSearch').value.toLowerCase();
    
    // Toggle table sections
    const onlineSection = document.getElementById('onlineOrdersSection');
    const offlineSection = document.getElementById('offlineSalesSection');
    
    if (filter === 'all') {
        onlineSection.style.display = 'block';
        offlineSection.style.display = 'block';
    } else if (filter === 'online') {
        onlineSection.style.display = 'block';
        offlineSection.style.display = 'none';
    } else if (filter === 'offline') {
        onlineSection.style.display = 'none';
        offlineSection.style.display = 'block';
    }
    
    // Filter rows by search term
    const rows = document.querySelectorAll('.sales-row');
    rows.forEach(row => {
        const text = row.innerText.toLowerCase();
        if (text.includes(search)) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
}

function updateReportDateInput() {
    const type = document.getElementById('reportType').value;
    const container = document.getElementById('dateInputContainer');
    
    if (type === 'yearly') {
        container.innerHTML = `
            <label class="form-label" id="dateLabel">Select Year</label>
            <select name="date" id="reportDate" class="form-control">
                <option value="2026-01-01">2026</option>
                <option value="2025-01-01">2025</option>
                <option value="2024-01-01">2024</option>
            </select>
        `;
    } else if (type === 'monthly') {
        container.innerHTML = `
            <label class="form-label" id="dateLabel">Select Month</label>
            <input type="month" name="date" id="reportDate" class="form-control" value="<?= date('Y-m') ?>" required>
        `;
    } else {
        container.innerHTML = `
            <label class="form-label" id="dateLabel">${type === 'weekly' ? 'Select Date in Week' : 'Select Date'}</label>
            <input type="date" name="date" id="reportDate" class="form-control" value="<?= date('Y-m-d') ?>" required>
        `;
    }
}
</script>

<style>
/* Remove local .modal CSS so it uses mybake.css correctly */
.modal-close {
    background: none;
    border: none;
    font-size: 1.25rem;
    color: var(--text-muted);
    cursor: pointer;
    padding: 0.5rem;
    transition: color 0.2s;
}
.modal-close:hover {
    color: #ef4444;
}

@media(max-width:768px) { 
    [style*="grid-template-columns:repeat(4,1fr)"]{grid-template-columns:repeat(2,1fr)!important;} 
    [style*="grid-template-columns:repeat(2,1fr)"]{grid-template-columns:1fr!important;}
}
@media(max-width:480px) { [style*="grid-template-columns:repeat(4,1fr)"]{grid-template-columns:1fr!important;} }
</style>

<!-- Scroll to Top Button for Admin -->
<button id="adminScrollTopBtn" onclick="window.scrollTo({top:0, behavior:'auto'}); document.querySelector('.admin-main').scrollTo({top:0, behavior:'auto'});" aria-label="Scroll to top" style="
    position: fixed;
    bottom: 2rem;
    right: 2rem;
    width: 3.5rem;
    height: 3.5rem;
    border-radius: 50%;
    background-color: var(--primary-emerald);
    color: #ffffff;
    border: none;
    box-shadow: var(--shadow-md);
    cursor: pointer;
    z-index: 999;
    font-size: 1.25rem;
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    visibility: hidden;
    transition: all 0.3s ease;
">
    <i class="fas fa-arrow-up"></i>
</button>
<style>
    #adminScrollTopBtn.visible {
        opacity: 1;
        visibility: visible;
    }
    #adminScrollTopBtn:hover {
        background-color: var(--primary-emerald-dark);
    }
</style>
<script>
    const adminScrollBtn = document.getElementById('adminScrollTopBtn');
    if (adminScrollBtn) {
        const checkScroll = () => {
            const adminMain = document.querySelector('.admin-main');
            const scrolled = window.scrollY > 200 || 
                             document.documentElement.scrollTop > 200 || 
                             document.body.scrollTop > 200 ||
                             (adminMain && adminMain.scrollTop > 200);
            
            if (scrolled) {
                adminScrollBtn.classList.add('visible');
            } else {
                adminScrollBtn.classList.remove('visible');
            }
        };
        
        window.addEventListener('scroll', checkScroll, true);
    }
</script>
