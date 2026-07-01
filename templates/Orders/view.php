<?php $this->assign('title', 'View Order #' . $order->id); ?>
<div style="padding:2rem 0 4rem;">
<div class="container" style="max-width:800px;">
    <div style="margin-bottom:1.5rem;">
        <a href="<?= $this->Url->build('/my-orders') ?>" style="color:var(--text-muted); font-size:0.875rem; display:inline-flex; align-items:center; gap:0.4rem; margin-bottom:0.75rem;">
            <i class="fas fa-arrow-left"></i> Back to My Orders
        </a>
        <div style="display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:1rem;">
            <h1 class="section-title" style="margin:0;">Order Details</h1>
            <span class="status-badge status-<?= $order->status ?>" style="font-size:0.875rem; padding:0.4rem 1rem;">
                <?= ucfirst($order->status) ?>
            </span>
        </div>
    </div>

    <?= $this->Flash->render() ?>

    <div style="background:#fff; border-radius:20px; border:1px solid var(--border-light); overflow:hidden; box-shadow:var(--shadow-sm); margin-bottom:1.5rem;">
        <div style="padding:1.25rem 1.5rem; background:var(--bg-light); border-bottom:1px solid var(--border-light); display:flex; justify-content:space-between; flex-wrap:wrap; gap:1rem;">
            <div>
                <p style="font-size:0.75rem; color:var(--text-muted); text-transform:uppercase; letter-spacing:0.05em; margin-bottom:0.25rem;">Order ID</p>
                <p style="font-weight:700;">#<?= $order->id ?></p>
            </div>
            <div>
                <p style="font-size:0.75rem; color:var(--text-muted); text-transform:uppercase; letter-spacing:0.05em; margin-bottom:0.25rem;">Date Placed</p>
                <p style="font-weight:600;"><?= $order->created_at ? $order->created_at->format('d M Y, h:i A') : '—' ?></p>
            </div>
        </div>

        <div style="padding:1.5rem;">
            <h3 style="font-size:1rem; font-weight:700; margin-bottom:1rem; display:flex; align-items:center; gap:0.5rem;">
                <i class="fas fa-box-open" style="color:var(--primary-teal);"></i> Items in Order
            </h3>
            <div style="display:flex; flex-direction:column; gap:1rem; margin-bottom:1.5rem;">
                <?php foreach ($order->order_items as $item): ?>
                <div style="display:flex; align-items:center; justify-content:space-between; padding:0.875rem; border:1px solid var(--border-light); border-radius:12px; background:var(--white);">
                    <div style="display:flex; align-items:center; gap:0.75rem;">
                        <div style="width:40px; height:40px; background:var(--primary-teal-xlight); border-radius:8px; display:flex; align-items:center; justify-content:center; color:var(--primary-teal);">
                            <i class="fas fa-cookie-bite"></i>
                        </div>
                        <div>
                            <div style="font-weight:600; font-size:0.875rem;"><?= h($item->product_name) ?></div>
                            <div style="font-size:0.75rem; color:var(--text-muted);">RM <?= number_format($item->unit_price, 2) ?> each</div>
                        </div>
                    </div>
                    <div style="text-align:right;">
                        <div style="font-size:0.75rem; color:var(--text-muted); margin-bottom:0.15rem;">Qty: <?= $item->quantity ?></div>
                        <div style="font-weight:700; color:var(--primary-teal); font-size:0.9rem;">RM <?= number_format($item->subtotal, 2) ?></div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>

            <div style="display:grid; grid-template-columns:1fr 1fr; gap:1.5rem; border-top:1px solid var(--border-light); padding-top:1.5rem;">
                <div>
                    <h3 style="font-size:0.9rem; font-weight:700; margin-bottom:0.75rem; color:var(--text-dark);">Delivery Information</h3>
                    <div style="font-size:0.875rem; color:var(--text-muted); line-height:1.6; margin-bottom:1rem;">
                        <i class="fas fa-map-marker-alt" style="color:var(--primary-teal); margin-right:0.4rem;"></i>
                        <?= h($order->delivery_address) ?>
                    </div>
                    <div style="font-size:0.875rem; color:var(--text-muted); line-height:1.6;">
                        <i class="fas fa-phone" style="color:var(--primary-teal); margin-right:0.4rem;"></i>
                        <?= h($order->phone_no) ?>
                    </div>
                    <?php if ($order->notes): ?>
                    <div style="margin-top:1rem; padding:0.75rem; background:var(--bg-light); border-radius:8px; font-size:0.8rem;">
                        <strong>Notes:</strong> <?= h($order->notes) ?>
                    </div>
                    <?php endif; ?>
                </div>

                <div style="background:var(--bg-light); padding:1.25rem; border-radius:12px;">
                    <h3 style="font-size:0.9rem; font-weight:700; margin-bottom:1rem; color:var(--text-dark);">Order Summary</h3>
                    <div style="display:flex; justify-content:space-between; font-size:0.875rem; margin-bottom:0.5rem;">
                        <span style="color:var(--text-muted);">Subtotal</span>
                        <span>RM <?= number_format($order->total_amount < 80 ? $order->total_amount - 8 : $order->total_amount, 2) ?></span>
                    </div>
                    <div style="display:flex; justify-content:space-between; font-size:0.875rem; margin-bottom:0.5rem; padding-bottom:0.75rem; border-bottom:1px solid var(--border-light);">
                        <span style="color:var(--text-muted);">Delivery Fee</span>
                        <span><?= $order->total_amount >= 80 ? 'FREE' : 'RM 8.00' ?></span>
                    </div>
                    <div style="display:flex; justify-content:space-between; font-weight:700; font-size:1.1rem; margin-top:0.75rem;">
                        <span>Total Paid</span>
                        <span style="color:var(--primary-teal);">RM <?= number_format($order->total_amount, 2) ?></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
