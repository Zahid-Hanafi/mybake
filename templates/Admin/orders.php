<?php $this->assign('title', 'Total Orders'); ?>

<!-- Filter Bar -->
<div style="background:#fff; border-radius:16px; padding:1.25rem; border:1px solid var(--border-light); margin-bottom:1.5rem; display:flex; align-items:center; gap:1rem; flex-wrap:wrap; box-shadow:var(--shadow-sm);">
    <span style="font-weight:600; font-size:0.875rem; color:var(--text-muted);">Filter by Status:</span>
    <?php foreach ([''=>'All','preparing'=>'Preparing','shipping'=>'Shipping','complete'=>'Completed','cancelled'=>'Cancelled'] as $val => $label): ?>
    <a href="<?= $this->Url->build('/admin/orders' . ($val ? '?status=' . $val : '')) ?>"
       class="btn btn-sm <?= $statusFilter === $val ? 'btn-primary' : 'btn-outline' ?>"
       style="<?= $statusFilter === $val ? '' : 'border-color:var(--border-light);' ?>">
        <?= $label ?>
    </a>
    <?php endforeach; ?>
    <span style="margin-left:auto; font-size:0.875rem; color:var(--text-muted);"><?= count($orders) ?> order(s) found</span>
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
                    <th>Update Status</th>
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
                            <?= h(substr($order->delivery_address, 0, 40)) ?>...
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
                        <select onchange="updateOrderStatus(<?= $order->id ?>, this.value, this)"
                                class="form-control" style="width:130px; font-size:0.8rem; padding:0.4rem 0.7rem;"
                                <?= $order->status === 'cancelled' ? 'disabled' : '' ?>>
                            <option value="preparing"   <?= $order->status === 'preparing'   ? 'selected' : '' ?>>Preparing</option>
                            <option value="shipping"  <?= $order->status === 'shipping'  ? 'selected' : '' ?>>Shipping</option>
                            <option value="complete"  <?= $order->status === 'complete'  ? 'selected' : '' ?>>Completed</option>
                            <option value="cancelled" <?= $order->status === 'cancelled' ? 'selected' : '' ?>>Cancelled</option>
                        </select>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php endif; ?>

<script>
function updateOrderStatus(orderId, status, selectEl) {
    const form = new FormData();
    form.append('status', status);
    selectEl.disabled = true;

    fetch('<?= $this->Url->build('/admin/orders/status/') ?>' + orderId, { method: 'POST', body: form })
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
                if (d.status === 'cancelled') selectEl.disabled = true;
            } else {
                showFlash('error', 'Failed to update status.');
            }
        })
        .catch(() => { selectEl.disabled = false; showFlash('error', 'Something went wrong.'); });
}
</script>
