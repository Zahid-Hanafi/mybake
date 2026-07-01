<?php
$this->assign('title', 'Dashboard');
?>
<!-- ── MARQUEE ──────────────────────────────────────────── -->
<?php if (!empty($promotions) && count($promotions) > 0): ?>
<div class="marquee-strip">
    <div class="marquee-track">
        <?php foreach ($promotions as $promo): ?>
        <span class="marquee-item"><?= h($promo->message) ?> <span>★</span></span>
        <?php endforeach; ?>
        <?php foreach ($promotions as $promo): /* duplicate for seamless loop */ ?>
        <span class="marquee-item"><?= h($promo->message) ?> <span>★</span></span>
        <?php endforeach; ?>
    </div>
</div>
<?php endif; ?>

<!-- ── HERO SLIDESHOW ────────────────────────────────────── -->
<section style="padding:2rem 0 1.5rem;">
    <div class="container">
        <?php if (!empty($bestSellers) && $bestSellers->count() > 0): ?>
        <div class="swiper hero-swiper" id="heroSwiper">
            <div class="swiper-wrapper">
                <?php foreach ($bestSellers as $i => $product): ?>
                <div class="swiper-slide">
                    <div class="hero-slide" style="background:linear-gradient(135deg, <?= ['#0F5050','#1A5050','#0F6060','#1A6A4A','#254B5A','#1A4A7A'][$i % 6] ?>, var(--primary-teal));">
                        <div style="flex:1; padding-right:1.5rem;">
                            <span style="display:inline-block; background:var(--secondary-gold); color:#fff; font-size:0.7rem; font-weight:700; padding:0.2rem 0.75rem; border-radius:20px; text-transform:uppercase; letter-spacing:0.06em; margin-bottom:1rem;">⭐ Best Seller</span>
                            <h2 style="font-family:'Playfair Display',serif; font-size:1.75rem; font-weight:700; color:#fff; margin-bottom:0.5rem; line-height:1.2;"><?= h($product->name) ?></h2>
                            <p style="color:rgba(255,255,255,0.75); font-size:0.875rem; margin-bottom:1rem; line-height:1.6;"><?= h(substr($product->description ?? 'Authentic homemade goodness crafted fresh daily.', 0, 100)) ?>...</p>
                            <div style="display:flex; align-items:center; gap:1rem; flex-wrap:wrap;">
                                <span style="font-family:'Playfair Display',serif; font-size:1.75rem; font-weight:700; color:var(--secondary-gold-light);">RM <?= number_format($product->price, 2) ?></span>
                                <a href="<?= $this->Url->build('/products') ?>" class="btn" style="background:var(--secondary-gold); color:#fff; border:none;">
                                    <i class="fas fa-bag-shopping"></i> Order Now
                                </a>
                            </div>
                        </div>
                        <div style="flex-shrink:0; width:180px; height:180px; border-radius:16px; overflow:hidden; box-shadow:0 8px 32px rgba(0,0,0,0.25);">
                            <img src="<?= $this->Url->build('/img/products/<?= h($product->image ?? 'default.jpg') ?>') ?>"
                                 onerror="this.src='https://placehold.co/180x180/1A7A7A/E8C97A?text=MyBake'"
                                 alt="<?= h($product->name) ?>"
                                 style="width:100%; height:100%; object-fit:cover;">
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            <div class="swiper-pagination"></div>
            <div class="swiper-button-prev" style="color:rgba(255,255,255,0.8);"></div>
            <div class="swiper-button-next" style="color:rgba(255,255,255,0.8);"></div>
        </div>
        <?php else: ?>
        <!-- Default hero if no products yet -->
        <div class="hero-slide" style="border-radius:20px; min-height:280px;">
            <div style="flex:1; text-align:center; padding:2rem;">
                <p style="color:rgba(255,255,255,0.6); font-size:0.875rem; margin-bottom:0.5rem; text-transform:uppercase; letter-spacing:0.1em;">Welcome to</p>
                <h2 style="font-family:'Playfair Display',serif; font-size:2.5rem; font-weight:800; color:#fff; margin-bottom:1rem;">MyBake</h2>
                <p style="color:rgba(255,255,255,0.7); margin-bottom:1.5rem;">Authentic homemade taste since 1990.</p>
                <a href="<?= $this->Url->build('/products') ?>" class="btn btn-gold btn-lg">Explore Our Products</a>
            </div>
        </div>
        <?php endif; ?>
    </div>
</section>

<!-- ── NEW ARRIVALS ──────────────────────────────────────── -->
<?php if (!empty($newArrivals) && $newArrivals->count() > 0): ?>
<section style="padding:1.5rem 0 2rem;">
    <div class="container">
        <div class="section-header" style="display:flex; align-items:flex-end; justify-content:space-between; flex-wrap:wrap; gap:1rem;">
            <div>
                <p class="section-label">🆕 Just Arrived</p>
                <h2 class="section-title">New Arrivals</h2>
            </div>
            <a href="<?= $this->Url->build('/products?line=1') ?>" class="btn btn-outline btn-sm">View All <i class="fas fa-arrow-right"></i></a>
        </div>

        <div style="display:grid; grid-template-columns:repeat(4, 1fr); gap:1.25rem;">
            <?php foreach ($newArrivals as $product): ?>
            <div class="product-card" style="animation: fadeUp 0.5s ease both;">
                <div class="product-card-img">
                    <img src="<?= $this->Url->build('/img/products/<?= h($product->image ?? 'default.jpg') ?>') ?>"
                         onerror="this.src='https://placehold.co/280x280/E8F7F7/1A7A7A?text=MyBake'"
                         alt="<?= h($product->name) ?>">
                    <span class="product-badge new">New</span>
                </div>
                <div class="product-card-body">
                    <h3 style="font-size:0.875rem; font-weight:600; margin-bottom:0.35rem; line-height:1.3; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;"><?= h($product->name) ?></h3>
                    <p style="color:var(--text-muted); font-size:0.75rem; margin-bottom:0.75rem;"><?= h($product->product_line->name ?? '') ?></p>
                    <div style="display:flex; align-items:center; justify-content:space-between; gap:0.5rem;">
                        <span style="font-family:'Playfair Display',serif; font-size:1.1rem; font-weight:700; color:var(--primary-teal);">RM <?= number_format($product->price, 2) ?></span>
                        <?php if ($product->status === 'open'): ?>
                        <button onclick="openAddToCartModal(<?= $product->id ?>, '<?= h(addslashes($product->name)) ?>', <?= $product->price ?>, <?= $product->stock_quantity ?>)"
                                class="btn btn-primary btn-sm">
                            <i class="fas fa-plus"></i> Add
                        </button>
                        <?php else: ?>
                        <span class="product-badge closed">Closed</span>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- ── QUICK ACTIONS ─────────────────────────────────────── -->
<section style="padding:2rem 0;">
    <div class="container">
        <div class="section-header" style="text-align:center; margin-bottom:1.5rem;">
            <p class="section-label">What do you need?</p>
            <h2 class="section-title">Quick Access</h2>
        </div>
        <div style="display:grid; grid-template-columns:repeat(3, 1fr); gap:1.25rem; max-width:700px; margin:0 auto;">
            <a href="<?= $this->Url->build('/products') ?>" class="quick-action">
                <div class="quick-action-icon qa-teal"><i class="fas fa-cookie-bite"></i></div>
                <div>
                    <div style="font-weight:600; font-size:0.9rem;">Our Products</div>
                    <div style="font-size:0.75rem; color:var(--text-muted);">Browse all items</div>
                </div>
            </a>
            <a href="<?= $this->Url->build('/contact') ?>" class="quick-action">
                <div class="quick-action-icon qa-gold"><i class="fas fa-envelope"></i></div>
                <div>
                    <div style="font-weight:600; font-size:0.9rem;">Contact Us</div>
                    <div style="font-size:0.75rem; color:var(--text-muted);">Get in touch</div>
                </div>
            </a>
            <a href="<?= $this->Url->build('/about') ?>" class="quick-action">
                <div class="quick-action-icon qa-teal"><i class="fas fa-circle-info"></i></div>
                <div>
                    <div style="font-weight:600; font-size:0.9rem;">About MyBake</div>
                    <div style="font-size:0.75rem; color:var(--text-muted);">Our story</div>
                </div>
            </a>
        </div>
    </div>
</section>

<!-- ── ADD TO CART MODAL ─────────────────────────────────── -->
<div class="modal-overlay" id="addCartModal">
    <div class="modal" style="max-width:400px;">
        <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:1.25rem;">
            <h3 style="font-family:'Playfair Display',serif; font-size:1.25rem;">Add to Cart</h3>
            <button onclick="closeModal('addCartModal')" style="background:none; border:none; cursor:pointer; color:var(--text-muted); font-size:1.1rem; padding:0.25rem;"><i class="fas fa-times"></i></button>
        </div>
        <div style="display:flex; align-items:center; gap:0.75rem; padding:0.875rem; background:var(--bg-light); border-radius:12px; margin-bottom:1.25rem;">
            <div style="width:52px; height:52px; border-radius:10px; background:var(--primary-teal-xlight); display:flex; align-items:center; justify-content:center; color:var(--primary-teal); font-size:1.25rem;">
                <i class="fas fa-cookie-bite"></i>
            </div>
            <div>
                <div style="font-weight:600; font-size:0.9rem;" id="modalProductName">Product Name</div>
                <div style="color:var(--primary-teal); font-weight:700; font-size:1.1rem;" id="modalProductPrice">RM 0.00</div>
            </div>
        </div>

        <div class="form-group">
            <label class="form-label">Quantity</label>
            <div style="display:flex; align-items:center; gap:0.75rem;">
                <button onclick="changeQty(-1)" class="cart-qty-btn" style="width:38px; height:38px; font-size:1rem;">−</button>
                <input type="number" id="modalQty" value="1" min="1" class="form-control" style="text-align:center; width:80px;">
                <button onclick="changeQty(1)" class="cart-qty-btn" style="width:38px; height:38px; font-size:1rem;">+</button>
                <span style="font-size:0.8rem; color:var(--text-muted);">Stock: <strong id="modalStock">0</strong></span>
            </div>
        </div>

        <div style="display:flex; align-items:center; justify-content:space-between; padding:0.75rem; background:var(--primary-teal-xlight); border-radius:10px; margin-bottom:1.25rem;">
            <span style="font-weight:500; color:var(--text-muted);">Total</span>
            <span style="font-size:1.2rem; font-weight:700; color:var(--primary-teal);" id="modalTotal">RM 0.00</span>
        </div>

        <button onclick="confirmAddToCart()" class="btn btn-gold btn-full btn-lg">
            <i class="fas fa-bag-shopping"></i> Add to Cart
        </button>
    </div>
</div>

<script>
// Swiper
new Swiper('#heroSwiper', {
    loop: true,
    autoplay: { delay: 4000, disableOnInteraction: false },
    pagination: { el: '.swiper-pagination', clickable: true },
    navigation: { nextEl: '.swiper-button-next', prevEl: '.swiper-button-prev' },
    effect: 'slide',
});

// Cart modal
let _currentProductId = null, _currentPrice = 0, _maxStock = 999;

function openAddToCartModal(id, name, price, stock) {
    _currentProductId = id;
    _currentPrice     = parseFloat(price);
    _maxStock         = parseInt(stock);
    document.getElementById('modalProductName').textContent = name;
    document.getElementById('modalProductPrice').textContent = 'RM ' + _currentPrice.toFixed(2);
    document.getElementById('modalStock').textContent = stock;
    document.getElementById('modalQty').value = 1;
    document.getElementById('modalQty').max   = stock;
    updateModalTotal();
    openModal('addCartModal');
}

function changeQty(delta) {
    const inp = document.getElementById('modalQty');
    let v = parseInt(inp.value) + delta;
    v = Math.max(1, Math.min(v, _maxStock));
    inp.value = v;
    updateModalTotal();
}

document.getElementById('modalQty').addEventListener('input', updateModalTotal);

function updateModalTotal() {
    const qty   = parseInt(document.getElementById('modalQty').value) || 1;
    const total = qty * _currentPrice;
    document.getElementById('modalTotal').textContent = 'RM ' + total.toFixed(2);
}

function confirmAddToCart() {
    const qty = parseInt(document.getElementById('modalQty').value) || 1;
    if (!_currentProductId) return;
    addToCart(_currentProductId, qty);
    closeModal('addCartModal');
}

function openModal(id)  { document.getElementById(id).classList.add('open');  }
function closeModal(id) { document.getElementById(id).classList.remove('open'); }

document.getElementById('addCartModal').addEventListener('click', function(e) {
    if (e.target === this) closeModal('addCartModal');
});
</script>

<?php $this->append('css', '<style>
@media(max-width:768px){ 
    [style*="grid-template-columns:repeat(4"] { grid-template-columns:repeat(2,1fr)!important; }
    [style*="grid-template-columns:repeat(3"] { grid-template-columns:repeat(2,1fr)!important; }
}
@media(max-width:480px){
    [style*="grid-template-columns:repeat(4"] { grid-template-columns:1fr!important; }
    [style*="grid-template-columns:repeat(3"] { grid-template-columns:1fr!important; }
}
</style>'); ?>