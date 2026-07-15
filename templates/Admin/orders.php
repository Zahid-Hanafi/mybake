<?php $this->assign('title', 'Order Management'); ?>

<!-- Filter & Search Bar -->
<div style="background:#fff; border-radius:16px; padding:1.25rem; border:1px solid var(--border-light); margin-bottom:1.5rem; box-shadow:var(--shadow-sm);">
    <div style="display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:1rem;">
        <div style="display:flex; align-items:center; gap:0.5rem; flex-wrap:wrap;">
            <span style="font-weight:600; font-size:0.875rem; color:var(--text-muted); margin-right:0.5rem;">Filter by Status:</span>
            <?php foreach (['' => 'All','preparing'=>'Preparing','shipping'=>'Shipping','complete'=>'Completed','cancelled'=>'Cancelled'] as $val => $label): ?>
            <a href="<?= $this->Url->build('/admin/orders?' . http_build_query(array_merge($this->request->getQueryParams(), ['status' => $val]))) ?>"
               class="btn btn-sm <?= $statusFilter === $val ? 'btn-primary' : 'btn-outline' ?>"
               style="<?= $statusFilter === $val ? '' : 'border-color:var(--border-light);' ?>">
                <?= $label ?>
            </a>
            <?php endforeach; ?>
        </div>
        
        <form action="<?= $this->Url->build('/admin/orders') ?>" method="GET" style="display:flex; gap:0.5rem; flex:1; max-width:450px; min-width:250px;">
            <?php if ($statusFilter): ?>
            <input type="hidden" name="status" value="<?= h($statusFilter) ?>">
            <?php endif; ?>
            <input type="text" name="search" class="form-control" placeholder="Search by name, address, tracking, or date..." value="<?= h($search) ?>" style="font-size:0.875rem; padding:0.4rem 0.75rem;">
            <button type="submit" class="btn btn-sm btn-primary" style="padding:0.4rem 1rem;">Search</button>
            <?php if ($search): ?>
            <a href="<?= $this->Url->build('/admin/orders' . ($statusFilter ? '?status=' . h($statusFilter) : '')) ?>" class="btn btn-sm btn-outline" style="padding:0.4rem 1rem;">Clear</a>
            <?php endif; ?>
        </form>
    </div>
    <div style="font-size:0.875rem; color:var(--text-muted); margin-top:1rem; text-align:right;">
        <?= count($orders) ?> order(s) found
    </div>
</div>

<?php if (empty($orders) || count($orders) === 0): ?>
<div style="text-align:center; padding:4rem 2rem; background:#fff; border-radius:20px; border:1px solid var(--border-light);">
    <i class="fas fa-inbox" style="font-size:3rem; color:var(--text-muted); opacity:0.3; display:block; margin-bottom:1rem;"></i>
    <p style="color:var(--text-muted);">No orders found<?= $statusFilter ? " with status: $statusFilter" : '' ?>.</p>
</div>
<?php else: ?>



<div style="background:#fff; border-radius:20px; border:1px solid var(--border-light); overflow:hidden; box-shadow:var(--shadow-sm);">
    <div class="table-wrapper" style="border-radius:0; border:none;">
        <table>
            <thead>
                <tr>

                    <th>#</th>
                    <th>Customer</th>
                    <th>Date</th>
                    <th>Items</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Tracking</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php $num = 1; foreach ($orders as $order): ?>
                <tr id="orderRow-<?= $order->id ?>">

                    <td style="font-weight:600; color:var(--text-muted); font-size:0.85rem;">#<?= $num++ ?></td>
                    <td>
                        <div style="font-weight:600; font-size:0.875rem;"><?= $order->user ? h($order->user->first_name . ' ' . $order->user->last_name) : 'Guest' ?></div>
                        <div style="font-size:0.75rem; color:var(--text-muted); margin-top:0.1rem;">
                            <i class="fas fa-map-marker-alt" style="font-size:0.65rem;"></i>
                            <?= h(mb_substr($order->delivery_address, 0, 35)) ?>...
                        </div>
                    </td>
                    <td style="font-size:0.85rem; white-space:nowrap;"><?= $order->created_at ? $order->created_at->format('d M Y') : '—' ?></td>
                    <td>
                        <?php foreach ($order->order_items as $oi): ?>
                        <div style="font-size:0.78rem; color:var(--text-muted);"><?= h($oi->product_name) ?> ×<?= $oi->quantity ?></div>
                        <?php endforeach; ?>
                    </td>
                    <td style="font-weight:700; color:var(--primary-emerald); white-space:nowrap;">RM <?= number_format($order->total_amount, 2) ?></td>
                    <td>
                        <span class="status-badge status-<?= $order->status ?>" id="orderStatus-<?= $order->id ?>">
                            <?= ucfirst($order->status) ?>
                        </span>
                    </td>
                    <td>
                        <?php if ($order->tracking_number): ?>
                        <div style="font-size:0.78rem;">
                            <div style="font-weight:600; color:var(--primary-emerald);"><?= h($order->tracking_number) ?></div>
                            <div style="color:var(--text-muted); font-size:0.7rem;"><?= h($order->courier_name) ?></div>
                        </div>
                        <?php else: ?>
                        <span style="font-size:0.75rem; color:var(--text-muted);">—</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <div style="display:flex; gap:0.4rem; align-items:center; flex-wrap:nowrap;">
                            <!-- Status Dropdown -->
                            <select onchange="updateOrderStatus(<?= $order->id ?>, this.value, this)"
                                    class="form-control" style="width:115px; font-size:0.75rem; padding:0.35rem 0.5rem;"
                                    <?= $order->status === 'cancelled' || $order->status === 'complete' ? 'disabled' : '' ?>>
                                <?php if ($order->status === 'complete'): ?>
                                <option value="complete" selected>Completed</option>
                                <?php elseif ($order->status === 'cancelled'): ?>
                                <option value="cancelled" selected>Cancelled</option>
                                <?php else: ?>
                                <option value="preparing" <?= $order->status === 'preparing' ? 'selected' : '' ?>>Preparing</option>
                                <option value="shipping" <?= $order->status === 'shipping' ? 'selected' : '' ?>>Shipping</option>
                                <?php endif; ?>
                            </select>
                            <!-- QR Scan Link -->
                            <?php if ($order->qr_token): ?>
                            <a href="<?= $this->Url->build('/admin/orders/scan/' . $order->qr_token) ?>" target="_blank"
                               title="Open Scan Page" style="color:var(--primary-emerald); font-size:0.9rem; padding:0.25rem;">
                                <i class="fas fa-qrcode"></i>
                            </a>
                            <?php endif; ?>
                            <!-- Print Packing Slip -->
                            <a href="<?= $this->Url->build('/admin/orders/packing-slip/' . $order->id) ?>" target="_blank"
                               title="Print Packing Slip" style="color:var(--secondary-gold-dark); font-size:0.9rem; padding:0.25rem;">
                                <i class="fas fa-print"></i>
                            </a>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php endif; ?>

<!-- Shipping Modal (for entering tracking number when changing status to shipping) -->
<div id="shippingModal" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.5); z-index:500; align-items:center; justify-content:center; padding:1rem;">
    <div style="background:#fff; border-radius:20px; padding:2rem; max-width:420px; width:100%; box-shadow:0 20px 60px rgba(0,0,0,0.2);">
        <h3 style="font-family:'Playfair Display',serif; margin-bottom:0.5rem; display:flex; align-items:center; gap:0.5rem;">
            <i class="fas fa-truck" style="color:var(--primary-emerald);"></i> Ship Order
        </h3>
        <p style="font-size:0.85rem; color:var(--text-muted); margin-bottom:1.25rem;">Enter the tracking number from the courier to ship this order.</p>

        <div class="form-group">
            <label class="form-label">Courier</label>
            <select class="form-control" id="modalCourier">
                <option value="Pos Laju" selected>Pos Laju</option>
            </select>
        </div>
        <div class="form-group">
            <label class="form-label">Tracking Number *</label>
            <input type="text" class="form-control" id="modalTracking" value="EN" minlength="13" maxlength="13">
            <div style="font-size:0.75rem; color:var(--text-muted); margin-top:0.35rem;">Must be exactly 13 characters (e.g. EN123456789MY)</div>
        </div>

        <div style="display:flex; gap:0.75rem; margin-top:1.25rem;">
            <button onclick="closeShippingModal()" class="btn btn-outline" style="flex:1; border-color:var(--border-light);">Cancel</button>
            <button onclick="confirmShipping()" class="btn btn-primary" style="flex:1;" id="modalConfirmBtn">
                <i class="fas fa-truck-fast"></i> Confirm
            </button>
        </div>
    </div>
</div>

<script>
let pendingShipOrderId = null;
let pendingShipSelect = null;

function updateOrderStatus(orderId, status, selectEl) {
    // If shipping, show modal to enter tracking number
    if (status === 'shipping') {
        pendingShipOrderId = orderId;
        pendingShipSelect = selectEl;
        document.getElementById('modalTracking').value = '';
        document.getElementById('shippingModal').style.display = 'flex';
        document.getElementById('modalTracking').focus();
        return;
    }

    const form = new FormData();
    form.append('status', status);
    selectEl.disabled = true;

    fetch('<?= $this->Url->build('/admin/orders/status/') ?>' + orderId, { 
        method: 'POST', 
        headers: { 'X-CSRF-Token': '<?= $this->request->getAttribute('csrfToken') ?>' },
        body: form 
    })
        .then(r => r.json())
        .then(d => {
            selectEl.disabled = false;
            if (d.success) {
                const badge = document.getElementById('orderStatus-' + orderId);
                if (badge) {
                    badge.className = 'status-badge status-' + d.status;
                    badge.textContent = d.status.charAt(0).toUpperCase() + d.status.slice(1);
                }
                showFlash('success', 'Order status updated to: ' + d.status);
                if (d.status === 'cancelled' || d.status === 'complete') selectEl.disabled = true;
            } else {
                showFlash('error', 'Failed to update status.');
            }
        })
        .catch(() => { selectEl.disabled = false; showFlash('error', 'Something went wrong.'); });
}

function closeShippingModal() {
    document.getElementById('shippingModal').style.display = 'none';
    if (pendingShipSelect) {
        pendingShipSelect.value = 'preparing'; // Reset dropdown
    }
    pendingShipOrderId = null;
    pendingShipSelect = null;
}

function confirmShipping() {
    const tracking = document.getElementById('modalTracking').value.trim();
    const courier  = document.getElementById('modalCourier').value;

    if (!tracking || tracking.length !== 13) {
        showFlash('error', 'Please enter a valid 13-character tracking number.');
        return;
    }

    const btn = document.getElementById('modalConfirmBtn');
    btn.disabled = true;

    const form = new FormData();
    form.append('status', 'shipping');
    form.append('tracking_number', tracking);
    form.append('courier_name', courier);

    fetch('<?= $this->Url->build('/admin/orders/status/') ?>' + pendingShipOrderId, { 
        method: 'POST', 
        headers: { 'X-CSRF-Token': '<?= $this->request->getAttribute('csrfToken') ?>' },
        body: form 
    })
        .then(r => r.json())
        .then(d => {
            btn.disabled = false;
            if (d.success) {
                closeShippingModal();
                const badge = document.getElementById('orderStatus-' + pendingShipOrderId);
                if (badge) {
                    badge.className = 'status-badge status-shipping';
                    badge.textContent = 'Shipping';
                }
                showFlash('success', '🚚 Order shipped! Tracking: ' + d.tracking_number);
                setTimeout(() => location.reload(), 1500);
            } else {
                showFlash('error', d.error || 'Failed to ship order.');
            }
        })
        .catch(() => { btn.disabled = false; showFlash('error', 'Something went wrong.'); });
}


</script>

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
