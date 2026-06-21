<?php $this->assign('title', 'Our Products'); ?>

<!-- ── MARQUEE ─────────────────────────────────────────────── -->
<div class="marquee-strip">
    <div class="marquee-track">
        <span class="marquee-item">🍪 Bahulu Varieties — Cermai, Ikan, Pecah Lapan, Gulung <span>★</span></span>
        <span class="marquee-item">🌾 Rempeyek — Kacang Tanah, Dal, Hijau, Mini <span>★</span></span>
        <span class="marquee-item">🥔 Kerepek Ubi — BBQ, Black Pepper, Spicy, Salted <span>★</span></span>
        <span class="marquee-item">🚚 FREE DELIVERY on orders above RM80! <span>★</span></span>
        <span class="marquee-item">🍪 Bahulu Varieties — Cermai, Ikan, Pecah Lapan, Gulung <span>★</span></span>
        <span class="marquee-item">🌾 Rempeyek — Kacang Tanah, Dal, Hijau, Mini <span>★</span></span>
        <span class="marquee-item">🥔 Kerepek Ubi — BBQ, Black Pepper, Spicy, Salted <span>★</span></span>
        <span class="marquee-item">🚚 FREE DELIVERY on orders above RM80! <span>★</span></span>
    </div>
</div>

<div style="padding:2rem 0 4rem;">
<div class="container">

<!-- ── SEARCH & FILTER ────────────────────────────────────── -->
<div style="background:#fff; border-radius:16px; padding:1.25rem; box-shadow:var(--shadow-sm); border:1px solid var(--border-light); margin-bottom:2rem; display:flex; flex-wrap:wrap; gap:0.875rem; align-items:flex-end;">
    <form method="get" action="/products" style="display:flex; flex-wrap:wrap; gap:0.875rem; align-items:flex-end; flex:1;">
        <div style="flex:1; min-width:200px;">
            <label class="form-label" style="margin-bottom:0.3rem;">Search</label>
            <div style="position:relative;">
                <i class="fas fa-search" style="position:absolute; left:0.875rem; top:50%; transform:translateY(-50%); color:var(--text-muted); font-size:0.8rem;"></i>
                <input type="text" name="q" value="<?= h($search) ?>" placeholder="Search products..." class="form-control" style="padding-left:2.5rem;">
            </div>
        </div>
        <div style="min-width:200px;">
            <label class="form-label" style="margin-bottom:0.3rem;">Filter by Category</label>
            <select name="line" class="form-control" onchange="this.form.submit()">
                <option value="">All Categories</option>
                <?php foreach ($lines as $line): ?>
                <option value="<?= $line->id ?>" <?= $lineFilter == $line->id ? 'selected' : '' ?>><?= h($line->name) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i> Search</button>
        <?php if ($search || $lineFilter): ?>
        <a href="/products" class="btn btn-outline"><i class="fas fa-times"></i> Clear</a>
        <?php endif; ?>
    </form>
</div>

<!-- ── NEW ARRIVALS (top) ─────────────────────────────────── -->
<?php if (!empty($newArrivals) && $newArrivals->count() > 0 && !$lineFilter): ?>
<section id="new-arrival" style="margin-bottom:3rem;">
    <div class="section-header">
        <p class="section-label">🆕 Hot off the shelf</p>
        <h2 class="section-title">New Arrivals</h2>
    </div>
    <div style="display:grid; grid-template-columns:repeat(4,1fr); gap:1.25rem;">
        <?php foreach ($newArrivals as $product): ?>
        <?php echo renderProductCard($product, true); ?>
        <?php endforeach; ?>
    </div>
</section>
<?php endif; ?>

<!-- ── ALL PRODUCT LINES ──────────────────────────────────── -->
<?php
// Group products by line
$grouped = [];
foreach ($allProducts as $p) {
    $grouped[$p->product_line_id]['line'] = $p->product_line;
    $grouped[$p->product_line_id]['products'][] = $p;
}

// Skip New Arrival line (id=1) in main grid if already shown above
foreach ($grouped as $lineId => $data):
    if (!$lineFilter && $lineId == 1) continue; // Already shown as New Arrivals
    $lineProducts = $data['products'];
    $lineName     = $data['line']->name ?? 'Products';
?>
<section id="line-<?= $lineId ?>" style="margin-bottom:3.5rem;">
    <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:1.5rem; flex-wrap:wrap; gap:1rem;">
        <div>
            <h2 style="font-family:'Playfair Display',serif; font-size:1.5rem; font-weight:700;"><?= h($lineName) ?></h2>
            <p style="color:var(--text-muted); font-size:0.875rem; margin-top:0.25rem;"><?= count($lineProducts) ?> products in this category</p>
        </div>
        <span style="background:var(--primary-teal-xlight); color:var(--primary-teal); font-size:0.75rem; font-weight:700; padding:0.3rem 0.75rem; border-radius:20px; border:1px solid rgba(26,122,122,0.2);">
            <?= count($lineProducts) ?> items
        </span>
    </div>
    <div style="display:grid; grid-template-columns:repeat(4,1fr); gap:1.25rem;">
        <?php foreach ($lineProducts as $product): ?>
        <?= renderProductCard($product) ?>
        <?php endforeach; ?>
    </div>
</section>
<?php endforeach; ?>

<?php if (empty($grouped)): ?>
<div style="text-align:center; padding:4rem 1rem; background:#fff; border-radius:16px; border:1px solid var(--border-light);">
    <i class="fas fa-magnifying-glass" style="font-size:3rem; color:var(--text-muted); opacity:0.4; display:block; margin-bottom:1rem;"></i>
    <h3 style="font-family:'Playfair Display',serif; margin-bottom:0.5rem;">No products found</h3>
    <p style="color:var(--text-muted);">Try a different search term or browse all categories.</p>
    <a href="/products" class="btn btn-primary" style="margin-top:1.25rem;">View All Products</a>
</div>
<?php endif; ?>

<!-- ── MY ORDERS SECTION ──────────────────────────────────── -->
<div id="my-order" style="margin-top:4rem; scroll-margin-top:80px;">
    <div class="section-header" style="display:flex; align-items:flex-end; justify-content:space-between; flex-wrap:wrap; gap:1rem;">
        <div>
            <p class="section-label">📦 Your purchases</p>
            <h2 class="section-title">My Orders</h2>
        </div>
        <a href="/my-orders" class="btn btn-outline btn-sm">View All Orders</a>
    </div>

    <?php if (!empty($myOrders) && count($myOrders) > 0): ?>
    <div class="table-wrapper">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Date</th>
                    <th>Items</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php $count = 1; foreach ($myOrders as $order): ?>
                <tr>
                    <td style="font-weight:600;">#<?= $count++ ?></td>
                    <td><?= $order->created_at ? $order->created_at->format('d M Y') : '—' ?></td>
                    <td>
                        <?php foreach ($order->order_items as $oi): ?>
                        <div style="font-size:0.8rem;"><?= h($oi->product_name) ?> × <?= $oi->quantity ?></div>
                        <?php endforeach; ?>
                    </td>
                    <td style="font-weight:700; color:var(--primary-teal);">RM <?= number_format($order->total_amount, 2) ?></td>
                    <td>
                        <span class="status-badge status-<?= $order->status ?>">
                            <?= ucfirst($order->status) ?>
                        </span>
                    </td>
                    <td>
                        <?php if ($order->status === 'pending'): ?>
                        <a href="/my-orders/edit/<?= $order->id ?>" class="btn btn-outline btn-sm"><i class="fas fa-pencil"></i></a>
                        <?php else: ?>
                        <a href="/my-orders/view/<?= $order->id ?>" class="btn btn-outline btn-sm"><i class="fas fa-eye"></i></a>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php else: ?>
    <div style="text-align:center; padding:2.5rem; background:#fff; border-radius:16px; border:1px solid var(--border-light);">
        <i class="fas fa-bag-shopping" style="font-size:2.5rem; color:var(--text-muted); opacity:0.3; margin-bottom:1rem; display:block;"></i>
        <p style="color:var(--text-muted);">You haven't placed any orders yet.</p>
        <a href="#" onclick="window.scrollTo({top:0,behavior:'smooth'})" class="btn btn-primary btn-sm" style="margin-top:0.875rem;">Browse Products</a>
    </div>
    <?php endif; ?>
</div>

</div><!-- /container -->
</div>

<!-- Anchor: Scroll to My Order -->
<a href="#my-order" style="position:fixed; bottom:5.5rem; right:2rem; background:var(--secondary-gold); color:#fff; width:48px; height:48px; border-radius:50%; display:flex; align-items:center; justify-content:center; box-shadow:var(--shadow-gold); z-index:90; transition:all 0.3s;" title="Go to My Orders">
    <i class="fas fa-bag-shopping"></i>
</a>

<!-- ── ADD TO CART MODAL ──────────────────────────────────── -->
<div class="modal-overlay" id="addCartModal">
    <div class="modal" style="max-width:400px;">
        <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:1.25rem;">
            <h3 style="font-family:'Playfair Display',serif; font-size:1.25rem;">Add to Cart</h3>
            <button onclick="closeModal('addCartModal')" style="background:none; border:none; cursor:pointer; color:var(--text-muted); font-size:1.1rem;"><i class="fas fa-times"></i></button>
        </div>
        <div style="display:flex; align-items:center; gap:0.75rem; padding:0.875rem; background:var(--bg-light); border-radius:12px; margin-bottom:1.25rem;">
            <div style="width:52px; height:52px; border-radius:10px; background:var(--primary-teal-xlight); display:flex; align-items:center; justify-content:center; color:var(--primary-teal); font-size:1.25rem;"><i class="fas fa-cookie-bite"></i></div>
            <div>
                <div style="font-weight:600; font-size:0.9rem;" id="modalProductName">—</div>
                <div style="color:var(--primary-teal); font-weight:700; font-size:1.1rem;" id="modalProductPrice">RM 0.00</div>
                <div style="font-size:0.75rem; color:var(--text-muted);">Stock: <span id="modalStock">0</span> left</div>
            </div>
        </div>
        <div class="form-group">
            <label class="form-label">Quantity</label>
            <div style="display:flex; align-items:center; gap:0.75rem;">
                <button onclick="changeQty(-1)" class="cart-qty-btn" style="width:38px; height:38px;">−</button>
                <input type="number" id="modalQty" value="1" min="1" class="form-control" style="text-align:center; width:80px;" oninput="updateModalTotal()">
                <button onclick="changeQty(1)" class="cart-qty-btn" style="width:38px; height:38px;">+</button>
            </div>
        </div>
        <div style="display:flex; align-items:center; justify-content:space-between; padding:0.75rem; background:var(--primary-teal-xlight); border-radius:10px; margin-bottom:1.25rem;">
            <span style="font-weight:500; color:var(--text-muted);">Total</span>
            <span style="font-size:1.2rem; font-weight:700; color:var(--primary-teal);" id="modalTotal">RM 0.00</span>
        </div>
        <div style="display:grid; grid-template-columns:1fr 1fr; gap:0.75rem;">
            <button onclick="closeModal('addCartModal')" class="btn btn-outline">Cancel</button>
            <button onclick="confirmAddToCart()" class="btn btn-gold"><i class="fas fa-bag-shopping"></i> Add to Cart</button>
        </div>
    </div>
</div>

<?php
function renderProductCard($product, $isNewArrival = false) {
    $stockLevel = $product->stock_quantity > 50 ? 'high' : ($product->stock_quantity > 10 ? 'medium' : ($product->stock_quantity > 0 ? 'low' : 'out'));
    $stockLabel = $product->stock_quantity > 50 ? 'In Stock' : ($product->stock_quantity > 10 ? 'Limited' : ($product->stock_quantity > 0 ? 'Low Stock' : 'Out of Stock'));
    ob_start(); ?>
    <div class="product-card">
        <div class="product-card-img">
            <img src="/img/products/<?= htmlspecialchars($product->image ?? 'default.jpg') ?>"
                 onerror="this.src='https://placehold.co/280x280/E8F7F7/1A7A7A?text=MyBake'"
                 alt="<?= htmlspecialchars($product->name) ?>">
            <?php if ($product->status !== 'open'): ?>
                <span class="product-badge closed">Unavailable</span>
            <?php elseif ($isNewArrival || $product->is_new_arrival): ?>
                <span class="product-badge new">New</span>
            <?php elseif ($product->is_best_seller): ?>
                <span class="product-badge">⭐ Best Seller</span>
            <?php endif; ?>
        </div>
        <div class="product-card-body">
            <h3 style="font-size:0.875rem; font-weight:600; margin-bottom:0.2rem; line-height:1.3; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;" title="<?= htmlspecialchars($product->name) ?>"><?= htmlspecialchars($product->name) ?></h3>
            <p style="color:var(--text-muted); font-size:0.72rem; margin-bottom:0.5rem;"><?= htmlspecialchars($product->product_line->name ?? '') ?></p>
            <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:0.6rem;">
                <span style="font-family:'Playfair Display',serif; font-size:1.1rem; font-weight:700; color:var(--primary-teal);">RM <?= number_format($product->price, 2) ?></span>
                <span class="product-stock stock-<?= $stockLevel ?>"><?= $stockLabel ?></span>
            </div>
            <?php if ($product->status === 'open' && $product->stock_quantity > 0): ?>
            <button onclick="openAddToCartModal(<?= $product->id ?>, '<?= htmlspecialchars(addslashes($product->name)) ?>', <?= $product->price ?>, <?= $product->stock_quantity ?>)"
                    class="btn btn-primary btn-sm btn-full" style="margin-top:0.25rem;">
                <i class="fas fa-shopping-cart"></i> Add to Cart
            </button>
            <?php else: ?>
            <button disabled class="btn btn-sm btn-full" style="background:#F3F4F6; color:#9CA3AF; cursor:not-allowed; margin-top:0.25rem;">
                <?= $product->status !== 'open' ? 'Unavailable' : 'Out of Stock' ?>
            </button>
            <?php endif; ?>
        </div>
    </div>
    <?php return ob_get_clean();
}
?>

<script>
let _currentProductId = null, _currentPrice = 0, _maxStock = 999;

function openAddToCartModal(id, name, price, stock) {
    _currentProductId = id; _currentPrice = parseFloat(price); _maxStock = parseInt(stock);
    document.getElementById('modalProductName').textContent = name;
    document.getElementById('modalProductPrice').textContent = 'RM ' + _currentPrice.toFixed(2);
    document.getElementById('modalStock').textContent = stock;
    document.getElementById('modalQty').value = 1;
    document.getElementById('modalQty').max = stock;
    updateModalTotal();
    document.getElementById('addCartModal').classList.add('open');
}
function changeQty(delta) {
    const inp = document.getElementById('modalQty');
    let v = Math.max(1, Math.min(parseInt(inp.value) + delta, _maxStock));
    inp.value = v; updateModalTotal();
}
function updateModalTotal() {
    const qty = parseInt(document.getElementById('modalQty').value) || 1;
    document.getElementById('modalTotal').textContent = 'RM ' + (qty * _currentPrice).toFixed(2);
}
function confirmAddToCart() {
    const qty = parseInt(document.getElementById('modalQty').value) || 1;
    if (!_currentProductId) return;
    addToCart(_currentProductId, qty);
    closeModal('addCartModal');
}
function openModal(id)  { document.getElementById(id).classList.add('open'); }
function closeModal(id) { document.getElementById(id).classList.remove('open'); }
document.getElementById('addCartModal').addEventListener('click', function(e) {
    if (e.target === this) closeModal('addCartModal');
});
</script>

<style>
@media(max-width:1024px){ [style*="repeat(4,1fr)"]{grid-template-columns:repeat(2,1fr)!important;} }
@media(max-width:640px) { [style*="repeat(4,1fr)"],[style*="repeat(3,1fr)"]{grid-template-columns:repeat(2,1fr)!important;} }
@media(max-width:420px) { [style*="repeat(4,1fr)"],[style*="repeat(3,1fr)"],[style*="repeat(2,1fr)"]{grid-template-columns:1fr!important;} }
</style>
