<?php $this->assign('title', 'View Order #' . $order->id); ?>
<div style="padding:2rem 0 4rem;">
<div class="container" style="max-width:800px;">
    <div style="margin-bottom:1.5rem;">
        <a href="<?= $this->Url->build('/my-orders') ?>" style="color:var(--text-muted); font-size:0.875rem; display:inline-flex; align-items:center; gap:0.4rem; margin-bottom:0.75rem;">
            <i class="fas fa-arrow-left"></i> Back to My Orders
        </a>
        <div style="display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:1rem;">
            <h1 class="section-title" style="margin:0;">Order Details</h1>
            <div style="display:flex; gap:0.5rem; align-items:center;">
                <span class="status-badge status-<?= $order->status ?>" style="font-size:0.875rem; padding:0.4rem 1rem;">
                    <?= ucfirst($order->status) ?>
                </span>
                <a href="<?= $this->Url->build('/my-orders/receipt/' . $order->id) ?>" target="_blank" class="btn btn-outline btn-sm" style="border-color:var(--primary-emerald); color:var(--primary-emerald);">
                    <i class="fas fa-file-pdf"></i> Download Receipt
                </a>
            </div>
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
            <!-- Tracking Timeline -->
            <h3 style="font-size:1rem; font-weight:700; margin-bottom:1.25rem; display:flex; align-items:center; gap:0.5rem;">
                <i class="fas fa-route" style="color:var(--primary-emerald);"></i> Order Tracking
            </h3>

            <?php
            // Build timeline steps
            $steps = [
                ['key' => 'preparing', 'icon' => 'fa-box', 'label' => 'Order Placed', 'desc' => 'Your order has been received and is being prepared'],
                ['key' => 'shipping',  'icon' => 'fa-truck', 'label' => 'Shipped', 'desc' => 'Your parcel has been picked up by our logistics partner'],
                ['key' => 'complete',  'icon' => 'fa-circle-check', 'label' => 'Delivered', 'desc' => 'Your order has been delivered successfully'],
            ];

            $statusOrder = ['preparing' => 1, 'shipping' => 2, 'complete' => 3, 'cancelled' => 0];
            $currentLevel = $statusOrder[$order->status] ?? 0;

            // Build log lookup
            $logLookup = [];
            if (!empty($order->order_status_logs)) {
                foreach ($order->order_status_logs as $log) {
                    $logLookup[$log->status] = $log;
                }
            }
            ?>

            <?php if ($order->status === 'cancelled'): ?>
            <div style="padding:1.5rem; background:#FFF1F2; border-radius:12px; border:1px solid #FECDD3; text-align:center; margin-bottom:1.5rem;">
                <i class="fas fa-ban" style="font-size:2rem; color:#DC2626; margin-bottom:0.5rem;"></i>
                <p style="font-weight:700; color:#DC2626;">Order Cancelled</p>
                <p style="font-size:0.85rem; color:#6B6B6B;">This order has been cancelled.</p>
            </div>
            <?php else: ?>
            <div class="tracking-timeline" style="margin-bottom:1.5rem;">
                <?php foreach ($steps as $i => $step):
                    $isDone = $currentLevel >= $statusOrder[$step['key']];
                    $isCurrent = $currentLevel === $statusOrder[$step['key']];
                    $log = $logLookup[$step['key']] ?? null;
                    $isLast = ($i === count($steps) - 1);
                ?>
                <div style="display:flex; gap:1rem; margin-bottom:<?= $isLast ? '0' : '0.5rem' ?>;">
                    <!-- Timeline dot & line -->
                    <div style="display:flex; flex-direction:column; align-items:center; flex-shrink:0; width:40px;">
                        <div style="width:36px; height:36px; border-radius:50%; display:flex; align-items:center; justify-content:center; font-size:0.9rem;
                            <?php if ($isDone): ?>
                                background: linear-gradient(135deg, #003D30, #00674F); color:#fff; box-shadow: 0 2px 8px rgba(0,103,79,0.3);
                            <?php elseif ($isCurrent): ?>
                                background: var(--secondary-gold); color:#fff;
                            <?php else: ?>
                                background: #F3F4F6; color:#9CA3AF;
                            <?php endif; ?>
                        ">
                            <i class="fas <?= $step['icon'] ?>"></i>
                        </div>
                        <?php if (!$isLast): ?>
                        <div style="width:2px; flex:1; min-height:30px;
                            <?= $isDone && $currentLevel > $statusOrder[$step['key']] ? 'background:#00674F;' : 'background:#E8E0D5;' ?>
                        "></div>
                        <?php endif; ?>
                    </div>
                    <!-- Content -->
                    <div style="flex:1; padding-bottom:<?= $isLast ? '0' : '1rem' ?>;">
                        <div style="font-weight:700; font-size:0.9rem; color:<?= $isDone ? '#1C1C1C' : '#9CA3AF' ?>;">
                            <?= $step['label'] ?>
                            <?php if ($isCurrent && $isDone): ?>
                            <span style="background:var(--secondary-gold); color:#fff; font-size:0.6rem; padding:0.15rem 0.5rem; border-radius:12px; margin-left:0.4rem; font-weight:700; text-transform:uppercase;">Current</span>
                            <?php endif; ?>
                        </div>
                        <div style="font-size:0.8rem; color:<?= $isDone ? '#6B6B6B' : '#C4C4C4' ?>; margin-top:0.15rem;">
                            <?= $step['desc'] ?>
                        </div>
                        <?php if ($log): ?>
                        <div style="font-size:0.75rem; color:var(--primary-emerald); margin-top:0.25rem; font-weight:500;">
                            <i class="fas fa-clock" style="font-size:0.65rem;"></i>
                            <?= $log->created_at ? $log->created_at->format('d M Y, h:i A') : '' ?>
                        </div>
                        <?php endif; ?>

                        <?php if ($step['key'] === 'shipping' && $order->tracking_number): ?>
                        <div style="margin-top:0.5rem; padding:0.75rem; background:var(--primary-emerald-xlight); border-radius:10px; border:1px solid rgba(0,103,79,0.15);">
                            <div style="font-size:0.8rem; color:var(--text-muted); margin-bottom:0.25rem;">
                                <i class="fas fa-box-open" style="color:var(--primary-emerald);"></i> Courier: <strong><?= h($order->courier_name) ?></strong>
                            </div>
                            <div style="font-size:0.85rem; font-weight:700; color:var(--primary-emerald); margin-bottom:0.4rem;">
                                Tracking: <?= h($order->tracking_number) ?>
                            </div>
                            <a href="https://www.tracking.my/poslaju/<?= h($order->tracking_number) ?>" target="_blank"
                               style="display:inline-flex; align-items:center; gap:0.3rem; font-size:0.78rem; color:var(--primary-emerald); font-weight:600; text-decoration:underline;">
                                <i class="fas fa-external-link-alt"></i> Track on Pos Laju Website
                            </a>
                        </div>
                        <?php endif; ?>

                        <?php if ($step['key'] === 'complete' && !$isDone && $order->status === 'shipping'): ?>
                        <div style="font-size:0.75rem; color:#9CA3AF; margin-top:0.25rem;">
                            Estimated delivery: 3-5 business days
                        </div>
                        <div style="margin-top:1rem;">
                            <form action="<?= $this->Url->build('/my-orders/receive/' . $order->id) ?>" method="post" onsubmit="return confirm('Have you received your order in good condition?');">
                                <input type="hidden" name="_csrfToken" value="<?= $this->request->getAttribute('csrfToken') ?>">
                                <button type="submit" class="btn btn-sm" style="background:var(--primary-emerald); color:#fff; font-weight:600; border-radius:8px;">
                                    <i class="fas fa-check-circle"></i> Order Received
                                </button>
                            </form>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>

            <!-- Items -->
            <h3 style="font-size:1rem; font-weight:700; margin-bottom:1rem; display:flex; align-items:center; gap:0.5rem; border-top:1px solid var(--border-light); padding-top:1.5rem;">
                <i class="fas fa-box-open" style="color:var(--primary-emerald);"></i> Items in Order
            </h3>
            <div style="display:flex; flex-direction:column; gap:1rem; margin-bottom:1.5rem;">
                <?php foreach ($order->order_items as $item): ?>
                <div style="display:flex; align-items:center; justify-content:space-between; padding:0.875rem; border:1px solid var(--border-light); border-radius:12px; background:var(--white);">
                    <div style="display:flex; align-items:center; gap:0.75rem;">
                        <div style="width:40px; height:40px; background:var(--primary-emerald-xlight); border-radius:8px; display:flex; align-items:center; justify-content:center; color:var(--primary-emerald);">
                            <i class="fas fa-cookie-bite"></i>
                        </div>
                        <div>
                            <div style="font-weight:600; font-size:0.875rem;"><?= h($item->product_name) ?></div>
                            <div style="font-size:0.75rem; color:var(--text-muted);">RM <?= number_format($item->unit_price, 2) ?> each</div>
                        </div>
                    </div>
                    <div style="text-align:right;">
                        <div style="font-size:0.75rem; color:var(--text-muted); margin-bottom:0.15rem;">Qty: <?= $item->quantity ?></div>
                        <div style="font-weight:700; color:var(--primary-emerald); font-size:0.9rem;">RM <?= number_format($item->subtotal, 2) ?></div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>

            <div style="display:grid; grid-template-columns:1fr 1fr; gap:1.5rem; border-top:1px solid var(--border-light); padding-top:1.5rem;">
                <div>
                    <h3 style="font-size:0.9rem; font-weight:700; margin-bottom:0.75rem; color:var(--text-dark);">Delivery Information</h3>
                    <div style="font-size:0.875rem; color:var(--text-muted); line-height:1.6; margin-bottom:1rem;">
                        <i class="fas fa-map-marker-alt" style="color:var(--primary-emerald); margin-right:0.4rem;"></i>
                        <?= h($order->delivery_address) ?>
                    </div>
                    <div style="font-size:0.875rem; color:var(--text-muted); line-height:1.6;">
                        <i class="fas fa-phone" style="color:var(--primary-emerald); margin-right:0.4rem;"></i>
                        <?= h($order->phone_no) ?>
                    </div>
                    <?php if ($order->notes): ?>
                    <div style="margin-top:1rem; padding:0.75rem; background:var(--bg-light); border-radius:8px; font-size:0.8rem;">
                        <strong>Notes:</strong> <?= h($order->notes) ?>
                    </div>
                    <?php endif; ?>
                </div>

                <div style="background:var(--bg-light); padding:1.25rem; border-radius:12px;">
                    <?php
                    $subtotal = 0;
                    foreach ($order->order_items as $item) {
                        $subtotal += $item->subtotal;
                    }
                    $discount = (float)($order->discount ?? 0);
                    $deliveryFee = (float)($order->delivery_fee ?? ($order->total_amount - $subtotal + $discount));
                    ?>
                    <h3 style="font-size:0.9rem; font-weight:700; margin-bottom:1rem; color:var(--text-dark);">Order Summary</h3>
                    <div style="display:flex; justify-content:space-between; font-size:0.875rem; margin-bottom:0.5rem;">
                        <span style="color:var(--text-muted);">Subtotal</span>
                        <span>RM <?= number_format($subtotal, 2) ?></span>
                    </div>
                    <?php if ($discount > 0): ?>
                    <div style="display:flex; justify-content:space-between; font-size:0.875rem; margin-bottom:0.5rem; color:#DC2626;">
                        <span>Discount (20%)</span>
                        <span>- RM <?= number_format($discount, 2) ?></span>
                    </div>
                    <?php endif; ?>
                    <div style="display:flex; justify-content:space-between; font-size:0.875rem; margin-bottom:0.5rem; padding-bottom:0.75rem; border-bottom:1px solid var(--border-light);">
                        <span style="color:var(--text-muted);">Delivery Fee</span>
                        <span><?= $deliveryFee > 0 ? 'RM ' . number_format($deliveryFee, 2) : 'FREE' ?></span>
                    </div>
                    <div style="display:flex; justify-content:space-between; font-weight:700; font-size:1.1rem; margin-top:0.75rem;">
                        <span>Total Paid</span>
                        <span style="color:var(--primary-emerald);">RM <?= number_format($order->total_amount, 2) ?></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
