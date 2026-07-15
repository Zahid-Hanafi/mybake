<?php $this->assign('title', 'Admin Dashboard'); ?>

<!-- Global Year Filter -->
<div style="display:flex; justify-content:flex-end; margin-bottom: 1.5rem;">
    <div style="display:flex; align-items:center; gap:0.5rem; background:#fff; padding:0.5rem 1rem; border-radius:12px; border:1px solid var(--border-light); box-shadow:var(--shadow-sm);">
        <label style="font-size:0.875rem; font-weight:600; color:var(--text-muted); margin:0;">Dashboard Year:</label>
        <select id="globalYear" onchange="window.location.href='?year='+this.value" class="form-control" style="width:auto; font-size:0.875rem; padding:0.3rem 1.5rem 0.3rem 0.6rem; border:none; background:transparent; font-weight:700; color:var(--primary-emerald); cursor:pointer;">
            <?php foreach ($availableYears as $y): ?>
            <option value="<?= $y ?>" <?= $y == $selectedYear ? 'selected' : '' ?>><?= $y ?></option>
            <?php endforeach; ?>
        </select>
    </div>
</div>

<!-- Stat Cards -->
<div style="display:grid; grid-template-columns:repeat(4,1fr); gap:1.25rem; margin-bottom:2rem;">
    <div class="stat-card emerald">
        <div style="display:flex; align-items:flex-start; justify-content:space-between; margin-bottom:1rem;">
            <div>
                <p class="stat-label">Total Revenue</p>
                <p class="stat-value" style="color:var(--primary-emerald);"><span style="white-space:nowrap;">RM <?= number_format($totalRevenue, 2) ?></span></p>
            </div>
            <div class="stat-icon" style="background:var(--primary-emerald-xlight); color:var(--primary-emerald);">
                <i class="fas fa-chart-line"></i>
            </div>
        </div>
        <div style="font-size:0.75rem; color:var(--text-muted);">
            Online: <strong style="color:var(--primary-emerald);"><span style="white-space:nowrap;">RM <?= number_format($onlineRevenue, 2) ?></span></strong> &nbsp;|&nbsp;
            Offline: <strong style="color:var(--secondary-gold-dark);"><span style="white-space:nowrap;">RM <?= number_format($offlineRevenue, 2) ?></span></strong>
        </div>
    </div>

    <div class="stat-card gold">
        <div style="display:flex; align-items:flex-start; justify-content:space-between; margin-bottom:1rem;">
            <div>
                <p class="stat-label">Total Profit (est.)</p>
                <p class="stat-value" style="color:var(--secondary-gold-dark);"><span style="white-space:nowrap;">RM <?= number_format($totalProfit, 2) ?></span></p>
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

    <div class="stat-card" style="border-left:4px solid #7C3AED;">
        <div style="display:flex; align-items:flex-start; justify-content:space-between; margin-bottom:1rem;">
            <div>
                <p class="stat-label">Total Customers</p>
                <p class="stat-value" style="color:#7C3AED;"><?= $totalCustomers ?></p>
            </div>
            <div class="stat-icon" style="background:#F5F3FF; color:#7C3AED;">
                <i class="fas fa-users"></i>
            </div>
        </div>
        <div style="font-size:0.75rem; color:var(--text-muted);">Registered customers</div>
    </div>
</div>

<!-- Revenue Chart + Quick Actions -->
<div style="display:grid; grid-template-columns:1fr 340px; gap:1.5rem; margin-bottom:2rem; align-items:start;">
    <div style="background:#fff; border-radius:20px; border:1px solid var(--border-light); padding:1.5rem; box-shadow:var(--shadow-sm);">
        <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:1rem; flex-wrap:wrap; gap:0.75rem;">
            <div>
                <h2 style="font-size:1rem; font-weight:700;">Revenue Overview</h2>
                <p style="color:var(--text-muted); font-size:0.8rem;" id="chartSubtitle">Last 12 months — online vs offline</p>
            </div>
            <div style="display:flex; align-items:center; gap:0.5rem; font-size:0.75rem;">
                <span style="display:flex; align-items:center; gap:0.4rem;"><span style="width:12px; height:12px; border-radius:3px; background:var(--primary-emerald); display:inline-block;"></span> Online</span>
                <span style="display:flex; align-items:center; gap:0.4rem;"><span style="width:12px; height:12px; border-radius:3px; background:var(--secondary-gold); display:inline-block;"></span> Offline</span>
            </div>
        </div>
        <!-- Period Filter -->
        <div style="display:flex; gap:0.4rem; margin-bottom:1.25rem; flex-wrap:wrap;">
            <button onclick="loadChart('daily')" class="btn btn-sm btn-outline chart-period-btn" data-period="daily" style="font-size:0.72rem; padding:0.3rem 0.75rem;">Daily</button>
            <button onclick="loadChart('weekly')" class="btn btn-sm btn-outline chart-period-btn" data-period="weekly" style="font-size:0.72rem; padding:0.3rem 0.75rem;">Weekly</button>
            <button onclick="loadChart('monthly')" class="btn btn-sm btn-primary chart-period-btn" data-period="monthly" style="font-size:0.72rem; padding:0.3rem 0.75rem;">Monthly</button>
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

        <a href="<?= $this->Url->build('/admin/sales') ?>" style="background:#fff; border-radius:16px; border:1px solid var(--border-light); padding:1.25rem; display:flex; align-items:center; gap:1rem; text-decoration:none; color:var(--text-dark); transition:var(--transition); box-shadow:var(--shadow-sm);" onmouseover="this.style.borderColor='#15803D'; this.style.boxShadow='var(--shadow-md)';" onmouseout="this.style.borderColor='var(--border-light)'; this.style.boxShadow='var(--shadow-sm)';">
            <div style="width:48px; height:48px; background:#DCFCE7; border-radius:12px; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                <i class="fas fa-file-pdf" style="color:#15803D; font-size:1.2rem;"></i>
            </div>
            <div>
                <div style="font-weight:700; font-size:0.9rem;">Sales & Reports</div>
                <div style="font-size:0.75rem; color:var(--text-muted);">View sales & generate reports</div>
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

<!-- Product Trends Chart -->
<div style="background:#fff; border-radius:20px; border:1px solid var(--border-light); padding:1.5rem; box-shadow:var(--shadow-sm); margin-bottom:2rem;">
    <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:1rem; flex-wrap:wrap; gap:0.75rem;">
        <div>
            <h2 style="font-size:1rem; font-weight:700; display:flex; align-items:center; gap:0.5rem;">
                <i class="fas fa-chart-line" style="color:var(--primary-emerald);"></i> Product Trends
            </h2>
            <p style="color:var(--text-muted); font-size:0.8rem;">Units sold per month — all products</p>
        </div>
    </div>
    <div style="position:relative; height:320px; width:100%;">
        <canvas id="productTrendsChart"></canvas>
    </div>
</div>

<?php $this->Html->scriptStart(['block' => true]); ?>
// ═══ Revenue Chart ═══
const chartDataUrl = '<?= $this->Url->build('/admin/chart-data') ?>';
const trendsUrl    = '<?= $this->Url->build('/admin/product-trends') ?>';
let revenueChart = null;

function initRevenueChart(data) {
    const ctx = document.getElementById('revenueChart');
    if (revenueChart) revenueChart.destroy();
    revenueChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: data.map(d => d.label),
            datasets: [
                {
                    label: 'Online',
                    data: data.map(d => d.online),
                    backgroundColor: 'rgba(16,185,129,0.7)',
                    borderColor: '#10B981',
                    borderWidth: 2,
                    borderRadius: 6,
                },
                {
                    label: 'Offline',
                    data: data.map(d => d.offline),
                    backgroundColor: 'rgba(201,168,76,0.7)',
                    borderColor: '#C9A84C',
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
                tooltip: { callbacks: { label: ctx => 'RM ' + ctx.parsed.y.toFixed(2) } }
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

const subtitles = {
    daily: 'Last 7 days — online vs offline',
    weekly: 'Last 4 weeks — online vs offline',
    monthly: 'Jan - Dec <?= $selectedYear ?> — online vs offline',
};

function loadChart(period) {
    document.querySelectorAll('.chart-period-btn').forEach(b => {
        b.className = 'btn btn-sm btn-outline chart-period-btn';
    });
    document.querySelector('[data-period="'+period+'"]').className = 'btn btn-sm btn-primary chart-period-btn';
    document.getElementById('chartSubtitle').textContent = subtitles[period] || '';

    fetch(chartDataUrl + '?period=' + period + '&year=<?= $selectedYear ?>')
        .then(r => r.json())
        .then(data => initRevenueChart(data))
        .catch(() => showFlash('error', 'Failed to load chart data.'));
}

// Init with server-rendered data
initRevenueChart(<?= json_encode($chartData) ?>);

// ═══ Product Trends Chart ═══
const trendColors = [
    '#10B981','#C9A84C','#3B82F6','#EF4444','#8B5CF6',
    '#F97316','#06B6D4','#EC4899','#14B8A6','#F59E0B',
    '#6366F1','#84CC16','#D946EF','#0EA5E9','#FB923C','#A3E635'
];
let trendsChart = null;

function loadProductTrends(year) {
    fetch(trendsUrl + '?year=' + year)
        .then(r => r.json())
        .then(data => {
            const ctx = document.getElementById('productTrendsChart');
            if (trendsChart) trendsChart.destroy();

            // Assign colors dynamically
            const colors = data.labels.map((_, i) => trendColors[i % trendColors.length]);

            trendsChart = new Chart(ctx, {
                type: 'bar', // Changed from line to bar
                data: { 
                    labels: data.labels, 
                    datasets: [{
                        label: 'Total Units Sold',
                        data: data.data,
                        backgroundColor: colors,
                        borderRadius: 4
                    }] 
                },
                options: {
                    indexAxis: 'y', // Makes it horizontal
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            callbacks: { label: ctx => 'Total Units: ' + ctx.parsed.x }
                        }
                    },
                    scales: {
                        x: {
                            beginAtZero: true,
                            title: { display: true, text: 'Total Units Sold', font: { size: 11 } },
                            grid: { color: 'rgba(0,0,0,0.04)' }
                        },
                        y: { grid: { display: false }, ticks: { font: { size: 10 } } }
                    }
                }
            });
        })
        .catch(() => showFlash('error', 'Failed to load product trends.'));
}

// Load default year
loadProductTrends(<?= $selectedYear ?>);
<?php $this->Html->scriptEnd(); ?>

<style>
@media(max-width:1100px){ [style*="grid-template-columns:1fr 340px"]{grid-template-columns:1fr!important;} }
@media(max-width:768px) { [style*="grid-template-columns:repeat(4,1fr)"]{grid-template-columns:repeat(2,1fr)!important;} }
@media(max-width:480px) { [style*="grid-template-columns:repeat(4,1fr)"]{grid-template-columns:1fr!important;} }
</style>
