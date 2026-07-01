<?php $this->assign('title', 'My Orders'); ?>
<div style="padding:2rem 0 4rem;">
<div class="container">

<div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:2rem; flex-wrap:wrap; gap:1rem;">
    <div>
        <p class="section-label">Order History</p>
        <h1 class="section-title">My Orders</h1>
    </div>
    <a href="<?= $this->Url->build('/products') ?>" class="btn btn-primary"><i class="fas fa-bag-shopping"></i> Continue Shopping</a>
</div>

<?= $this->Flash->render() ?>

<?php if (empty($myOrders) || count($myOrders) === 0): ?>
<div style="text-align:center; padding:5rem 2rem; background:#fff; border-radius:20px; border:1px solid var(--border-light);">
    <i class="fas fa-box-open" style="font-size:4rem; color:var(--text-muted); opacity:0.2; display:block; margin-bottom:1rem;"></i>
    <h3 style="font-family:'Playfair Display',serif; margin-bottom:0.5rem;">No orders yet</h3>
    <p style="color:var(--text-muted); margin-bottom:1.5rem;">You haven't placed any orders. Start shopping now!</p>
    <a href="<?= $this->Url->build('/products') ?>" class="btn btn-primary btn-lg"><i class="fas fa-cookie-bite"></i> Browse Products</a>
</div>
<?php else: ?>

<!-- Stats -->
<?php
$counts = ['preparing'=>0,'shipping'=>0,'complete'=>0,'cancelled'=>0];
$totalSpent = 0;
foreach ($myOrders as $o) { $counts[$o->status] = ($counts[$o->status] ?? 0) + 1; if ($o->status !== 'cancelled') $totalSpent += $o->total_amount; }
?>
<div style="display:grid; grid-template-columns:repeat(4,1fr); gap:1rem; margin-bottom:2rem;">
    <?php
    $stats = [
        ['Preparing',   $counts['preparing'],   'fa-clock',        '#B45309','#FEF3C7'],
        ['Shipping',  $counts['shipping'],  'fa-truck',        '#1D4ED8','#DBEAFE'],
        ['Completed', $counts['complete'],  'fa-circle-check', '#15803D','#DCFCE7'],
        ['Cancelled', $counts['cancelled'], 'fa-circle-xmark', '#6B7280','#F3F4F6'],
    ];
    foreach ($stats as $s): ?>
    <div style="background:#fff; border-radius:16px; padding:1.25rem; border:1px solid var(--border-light); text-align:center;">
        <div style="width:44px; height:44px; border-radius:12px; background:<?= $s[4] ?>; display:flex; align-items:center; justify-content:center; margin:0 auto 0.75rem;">
            <i class="fas <?= $s[0] === 'Shipping' ? 'fa-truck' : $s[2] ?>" style="color:<?= $s[3] ?>; font-size:1.1rem;"></i>
        </div>
        <div style="font-family:'Playfair Display',serif; font-size:1.75rem; font-weight:700; color:<?= $s[3] ?>;"><?= $s[1] ?></div>
        <div style="font-size:0.75rem; color:var(--text-muted); font-weight:500;"><?= $s[0] ?></div>
    </div>
    <?php endforeach; ?>
</div>

<!-- Order Cards -->
<div style="display:flex; flex-direction:column; gap:1rem;">
    <?php foreach ($myOrders as $order): ?>
    <div style="background:#fff; border-radius:20px; border:1px solid var(--border-light); overflow:hidden; box-shadow:var(--shadow-sm); transition:var(--transition);" onmouseover="this.style.boxShadow='var(--shadow-md)'" onmouseout="this.style.boxShadow='var(--shadow-sm)'">
        <!-- Order Header -->
        <div style="padding:1rem 1.5rem; background:var(--bg-light); border-bottom:1px solid var(--border-light); display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:0.75rem;">
            <div style="display:flex; align-items:center; gap:1rem; flex-wrap:wrap;">
                <div>
                    <div style="font-size:0.7rem; color:var(--text-muted); text-transform:uppercase; letter-spacing:0.05em;">Order Date</div>
                    <div style="font-weight:600; font-size:0.875rem;"><?= $order->created_at ? $order->created_at->format('d M Y, h:i A') : '—' ?></div>
                </div>
                <div style="width:1px; height:32px; background:var(--border-light);"></div>
                <div>
                    <div style="font-size:0.7rem; color:var(--text-muted); text-transform:uppercase; letter-spacing:0.05em;">Total Amount</div>
                    <div style="font-weight:700; color:var(--primary-emerald); font-family:'Playfair Display',serif; font-size:1rem;">RM <?= number_format($order->total_amount, 2) ?></div>
                </div>
            </div>
            <span class="status-badge status-<?= $order->status ?>">
                <i class="fas fa-<?= ['preparing'=>'clock','shipping'=>'truck','complete'=>'check-circle','cancelled'=>'times-circle'][$order->status] ?? 'circle' ?>"></i>
                <?= ucfirst($order->status) ?>
            </span>
        </div>

        <!-- Items -->
        <div style="padding:1rem 1.5rem;">
            <div style="display:flex; flex-wrap:wrap; gap:0.75rem; margin-bottom:1rem;">
                <?php foreach ($order->order_items as $oi): ?>
                <div style="display:flex; align-items:center; gap:0.6rem; background:var(--bg-light); padding:0.5rem 0.75rem; border-radius:10px; font-size:0.8rem;">
                    <i class="fas fa-cookie-bite" style="color:var(--primary-emerald);"></i>
                    <span style="font-weight:500;"><?= h($oi->product_name) ?></span>
                    <span style="color:var(--text-muted);">× <?= $oi->quantity ?></span>
                    <span style="color:var(--primary-emerald); font-weight:600;">RM <?= number_format($oi->subtotal, 2) ?></span>
                </div>
                <?php endforeach; ?>
            </div>

            <!-- Delivery address -->
            <div style="font-size:0.8rem; color:var(--text-muted); display:flex; align-items:flex-start; gap:0.5rem; margin-bottom:1rem;">
                <i class="fas fa-map-marker-alt" style="color:var(--primary-emerald); margin-top:0.1rem; flex-shrink:0;"></i>
                <?= h($order->delivery_address) ?>
            </div>

            <!-- Actions -->
            <div style="display:flex; gap:0.75rem; flex-wrap:wrap;">
                <a href="<?= $this->Url->build('/my-orders/view/' . $order->id) ?>" class="btn btn-outline btn-sm"><i class="fas fa-eye"></i> View Details</a>
                <?php if ($order->status === 'preparing'): ?>
                <a href="<?= $this->Url->build('/my-orders/edit/' . $order->id) ?>" class="btn btn-primary btn-sm"><i class="fas fa-pencil"></i> Edit Order</a>
                <?= $this->Form->postLink(
                    '<i class="fas fa-times"></i> Cancel',
                    ['action' => 'cancel', $order->id],
                    [
                        'confirm' => 'Cancel this order? Stock will be restored.',
                        'escape' => false,
                        'class' => 'btn btn-sm',
                        'style' => 'background:#FFF1F2; color:#DC2626; border:none;'
                    ]
                ) ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
</div>
<?php endif; ?>

</div>
</div>
<style>@media(max-width:640px){ [style*="grid-template-columns:repeat(4,1fr)"]{grid-template-columns:repeat(2,1fr)!important;} }</style>
