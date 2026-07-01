<!DOCTYPE html>
<html lang="en">
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="MyBake — Authentic homemade Bahulu, Rempeyek, and Kerepek Ubi from Sekinchan, Selangor. Order fresh traditional snacks online.">
    <title>MyBake <?= !empty($this->fetch('title')) ? '— ' . $this->fetch('title') : '' ?></title>
    <?= $this->Html->meta('icon') ?>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700;800&family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <!-- Swiper -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">

    <!-- MyBake CSS -->
    <link rel="stylesheet" href="<?= $this->request->getAttribute('webroot') ?>css/mybake.css">

    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

    <?= $this->fetch('css') ?>
</head>
<body>

<?php
    $controller  = $this->request->getParam('controller');
    $action      = $this->request->getParam('action');
    $isAuthPage  = ($controller === 'Users' && in_array($action, ['login', 'register']));
    $identity    = $this->request->getAttribute('identity');
    $isAdmin     = $identity && $identity->get('role') === 'admin';
    $isAdminPage = ($controller === 'Admin' || $controller === 'Sales');
    $firstName   = $identity ? $identity->get('first_name') : 'Guest';
    $fullName    = $identity ? trim($identity->get('first_name') . ' ' . $identity->get('last_name')) : 'Guest';
    $userInitial = $identity ? strtoupper(substr($identity->get('first_name'), 0, 1)) : 'G';
    $cartCount   = $cartCount ?? 0;

    // Current route for active nav
    $currentRoute = '/' . strtolower($controller) . '/' . strtolower($action);
?>

<?php if (!$isAuthPage && !$isAdminPage): ?>
<!-- ══════════════════════════════════════════════════════════
     CUSTOMER LAYOUT
     ══════════════════════════════════════════════════════════ -->

<!-- Sidebar Overlay -->
<div class="sidebar-overlay" id="sidebarOverlay" onclick="closeSidebar()"></div>

<!-- Left Sidebar -->
<nav class="sidebar" id="mainSidebar" role="navigation" aria-label="Main navigation">
    <!-- Header -->
    <div class="sidebar-header">
        <div style="display:flex; align-items:center; justify-content:space-between;">
            <div style="display:flex; align-items:center; gap:0.75rem;">
                <div class="brand-icon">
                    <span>MB</span>
                </div>
                <div>
                    <div style="font-family:'Playfair Display',serif; font-weight:700; color:#fff; font-size:1.2rem;">MyBake</div>
                    <div style="font-size:0.65rem; color:rgba(255,255,255,0.6); letter-spacing:0.05em;">Since 1990 · Sekinchan</div>
                </div>
            </div>
            <button onclick="closeSidebar()" style="background:rgba(255,255,255,0.15); border:none; color:#fff; width:32px; height:32px; border-radius:8px; cursor:pointer; display:flex; align-items:center; justify-content:center;">
                <i class="fas fa-times"></i>
            </button>
        </div>
    </div>

    <!-- User Info -->
    <div class="sidebar-user">
        <div class="sidebar-avatar"><?= h($userInitial) ?></div>
        <div>
            <div style="font-weight:600; font-size:0.9rem; color:#1C1C1C;"><?= h($fullName) ?></div>
            <div style="font-size:0.75rem; color:#6B6B6B;"><?= $isAdmin ? 'Administrator' : 'Customer' ?></div>
        </div>
    </div>

    <!-- Navigation -->
    <div class="sidebar-nav">
        <p class="nav-section-label">Menu</p>
        <ul style="list-style:none;">
            <li>
                <a href="<?= $this->Url->build('/dashboard') ?>" class="nav-item <?= ($controller === 'Pages' && $action === 'dashboard') ? 'active' : '' ?>">
                    <i class="fas fa-house"></i> Dashboard
                </a>
            </li>
            <li>
                <a href="<?= $this->Url->build('/products') ?>" class="nav-item <?= ($controller === 'Products') ? 'active' : '' ?>">
                    <i class="fas fa-cookie-bite"></i> Our Products
                </a>
            </li>
            <li>
                <a href="<?= $this->Url->build('/my-orders') ?>" class="nav-item <?= ($controller === 'Orders') ? 'active' : '' ?>">
                    <i class="fas fa-bag-shopping"></i> My Orders
                </a>
            </li>

            <p class="nav-section-label" style="margin-top:1rem;">Information</p>
            <li>
                <a href="<?= $this->Url->build('/about') ?>" class="nav-item <?= ($action === 'about') ? 'active' : '' ?>">
                    <i class="fas fa-circle-info"></i> About Us
                </a>
            </li>
            <li>
                <a href="<?= $this->Url->build('/contact') ?>" class="nav-item <?= ($action === 'contact') ? 'active' : '' ?>">
                    <i class="fas fa-envelope"></i> Contact Us
                </a>
            </li>

            <p class="nav-section-label" style="margin-top:1rem;">Account</p>
            <li>
                <a href="<?= $this->Url->build('/profile') ?>" class="nav-item <?= ($controller === 'Users' && $action === 'profile') ? 'active' : '' ?>">
                    <i class="fas fa-user-circle"></i> My Profile
                </a>
            </li>
            <li>
                <a href="<?= $this->Url->build('/profile/addresses') ?>" class="nav-item <?= ($controller === 'Addresses') ? 'active' : '' ?>">
                    <i class="fas fa-map-marker-alt"></i> My Addresses
                </a>
            </li>
        </ul>
    </div>

    <!-- Logout -->
    <div class="sidebar-footer">
        <a href="<?= $this->Url->build('/logout') ?>" class="logout-btn" id="logoutBtn">
            <i class="fas fa-right-from-bracket"></i> Logout
        </a>
    </div>
</nav>

<!-- Cart Panel -->
<div class="sidebar-overlay" id="cartOverlay" onclick="closeCart()" style="z-index:350;"></div>
<aside class="cart-panel" id="cartPanel" aria-label="Shopping cart">
    <div class="cart-panel-header">
        <div style="display:flex; align-items:center; gap:0.75rem;">
            <i class="fas fa-bag-shopping"></i>
            <span style="font-weight:700; font-size:1rem;">My Cart</span>
            <span id="cartPanelCount" style="background:var(--secondary-gold); color:#fff; font-size:0.7rem; font-weight:700; padding:0.15rem 0.5rem; border-radius:20px;"><?= $cartCount ?></span>
        </div>
        <button onclick="closeCart()" style="background:rgba(255,255,255,0.15); border:none; color:#fff; width:32px; height:32px; border-radius:8px; cursor:pointer;">
            <i class="fas fa-times"></i>
        </button>
    </div>

    <div class="cart-items-list" id="cartItemsList">
        <div class="cart-empty" id="cartEmpty" style="display:none;">
            <i class="fas fa-bag-shopping"></i>
            <p style="font-weight:600; margin-bottom:0.5rem;">Your cart is empty</p>
            <p style="font-size:0.85rem;">Browse our products and add items to your cart!</p>
            <a href="<?= $this->Url->build('/products') ?>" class="btn btn-primary btn-sm" style="margin-top:1rem;" onclick="closeCart()">Browse Products</a>
        </div>
        <div id="cartItemsContainer"></div>
    </div>

    <div class="cart-panel-footer" id="cartFooter" style="display:none;">
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:1rem;">
            <span style="font-weight:600; color:var(--text-muted);">Total</span>
            <span style="font-size:1.25rem; font-weight:700; color:var(--primary-teal);" id="cartTotal">RM 0.00</span>
        </div>
        <a href="<?= $this->Url->build('/checkout') ?>" class="btn btn-gold btn-full btn-lg">
            <i class="fas fa-credit-card"></i> Proceed to Checkout
        </a>
    </div>
</aside>

<!-- ── HEADER ───────────────────────────────────── -->
<header class="site-header" id="siteHeader">
    <div class="container">
        <div class="header-inner">
            <!-- Left: Burger + Brand -->
            <div style="display:flex; align-items:center; gap:0.75rem;">
                <button class="burger-btn" id="burgerBtn" onclick="toggleSidebar()" aria-label="Toggle navigation">
                    <div class="burger-icon">
                        <span></span><span></span><span></span>
                    </div>
                </button>
                <a href="<?= $this->Url->build('/dashboard') ?>" class="brand-logo">
                    <div class="brand-icon"><span>MB</span></div>
                    <div>
                        <div class="brand-name">MyBake</div>
                        <div class="brand-tagline">Authentic · Homemade · Fresh</div>
                    </div>
                </a>
            </div>

            <!-- Center: Clock -->
            <div class="clock-display" id="clockDisplay">
                <i class="fas fa-clock" style="color:var(--primary-teal);"></i>
                <span id="clockText"></span>
            </div>

            <!-- Right: Cart + User -->
            <div style="display:flex; align-items:center; gap:0.5rem;">
                <?php if ($identity): ?>
                <button class="cart-btn" onclick="openCart()" aria-label="Shopping cart" id="cartBtn">
                    <i class="fas fa-bag-shopping"></i>
                    <span class="cart-badge <?= $cartCount === 0 ? 'hidden' : '' ?>" id="cartBadge"><?= $cartCount ?></span>
                </button>
                <?php endif; ?>

                <div style="position:relative;" id="userMenuWrapper">
                    <button onclick="toggleUserMenu()" style="display:flex; align-items:center; gap:0.6rem; background:none; border:none; cursor:pointer; padding:0.4rem 0.75rem; border-radius:12px; transition:background 0.2s;" onmouseover="this.style.background='var(--bg-light)'" onmouseout="this.style.background='none'">
                        <div class="sidebar-avatar" style="width:36px; height:36px; font-size:0.9rem; flex-shrink:0;"><?= h($userInitial) ?></div>
                        <div style="text-align:left; display:none;" class="user-info-desktop">
                            <div style="font-size:0.85rem; font-weight:600; color:var(--text-dark);"><?= h($firstName) ?></div>
                            <div style="font-size:0.7rem; color:var(--text-muted);"><?= $isAdmin ? 'Admin' : 'Customer' ?></div>
                        </div>
                        <i class="fas fa-chevron-down" style="font-size:0.65rem; color:var(--text-muted);"></i>
                    </button>

                    <div id="userDropdown" style="display:none; position:absolute; right:0; top:calc(100%+8px); width:200px; background:#fff; border-radius:16px; box-shadow:0 8px 32px rgba(0,0,0,0.12); border:1px solid var(--border-light); overflow:hidden; z-index:250;">
                        <div style="padding:0.875rem 1rem; border-bottom:1px solid var(--border-light); background:var(--bg-light);">
                            <div style="font-weight:600; font-size:0.875rem;"><?= h($fullName) ?></div>
                            <div style="font-size:0.75rem; color:var(--text-muted);"><?= h($identity ? $identity->get('email') : '') ?></div>
                        </div>
                        <a href="<?= $this->Url->build('/profile') ?>" style="display:flex; align-items:center; gap:0.6rem; padding:0.75rem 1rem; font-size:0.875rem; color:var(--text-dark); transition:background 0.15s;" onmouseover="this.style.background='var(--bg-light)'" onmouseout="this.style.background='none'">
                            <i class="fas fa-user" style="width:16px; color:var(--primary-teal);"></i> My Profile
                        </a>
                        <a href="<?= $this->Url->build('/my-orders') ?>" style="display:flex; align-items:center; gap:0.6rem; padding:0.75rem 1rem; font-size:0.875rem; color:var(--text-dark); transition:background 0.15s;" onmouseover="this.style.background='var(--bg-light)'" onmouseout="this.style.background='none'">
                            <i class="fas fa-bag-shopping" style="width:16px; color:var(--primary-teal);"></i> My Orders
                        </a>
                        <div style="border-top:1px solid var(--border-light); padding:0.5rem;">
                            <a href="<?= $this->Url->build('/logout') ?>" id="userLogoutBtn" style="display:flex; align-items:center; gap:0.6rem; padding:0.75rem 1rem; font-size:0.875rem; color:#DC2626; border-radius:10px; transition:background 0.15s;" onmouseover="this.style.background='#FFF1F2'" onmouseout="this.style.background='none'">
                                <i class="fas fa-right-from-bracket" style="width:16px;"></i> Logout
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>

<!-- ── MAIN ─────────────────────────────────────── -->
<main class="main-content">
    <?= $this->fetch('content') ?>
</main>

<!-- ── FOOTER ───────────────────────────────────── -->
<footer class="site-footer">
    <div class="container">
        <div class="footer-grid">
            <!-- Brand -->
            <div>
                <div style="display:flex; align-items:center; gap:0.75rem; margin-bottom:1rem;">
                    <div class="brand-icon" style="background:var(--secondary-gold);"><span style="color:#fff;">MB</span></div>
                    <div>
                        <div class="footer-brand-name">MyBake</div>
                        <div style="font-size:0.65rem; color:var(--secondary-gold); letter-spacing:0.05em;">Since 1990 · Sekinchan</div>
                    </div>
                </div>
                <p class="footer-desc">Authentic homemade traditional snacks crafted with love from the heart of Sekinchan, Selangor. Quality you can taste in every bite.</p>
                <div class="social-links">
                    <a href="#" class="social-link" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="social-link" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="social-link" aria-label="WhatsApp"><i class="fab fa-whatsapp"></i></a>
                    <a href="#" class="social-link" aria-label="TikTok"><i class="fab fa-tiktok"></i></a>
                </div>
            </div>

            <!-- Quick Links -->
            <div>
                <h6 class="footer-heading">Quick Links</h6>
                <ul class="footer-links">
                    <li><a href="<?= $this->Url->build('/dashboard') ?>"><i class="fas fa-chevron-right" style="font-size:0.6rem;"></i> Dashboard</a></li>
                    <li><a href="<?= $this->Url->build('/products') ?>"><i class="fas fa-chevron-right" style="font-size:0.6rem;"></i> Our Products</a></li>
                    <li><a href="<?= $this->Url->build('/my-orders') ?>"><i class="fas fa-chevron-right" style="font-size:0.6rem;"></i> My Orders</a></li>
                    <li><a href="<?= $this->Url->build('/profile') ?>"><i class="fas fa-chevron-right" style="font-size:0.6rem;"></i> My Profile</a></li>
                </ul>
            </div>

            <!-- Information -->
            <div>
                <h6 class="footer-heading">Information</h6>
                <ul class="footer-links">
                    <li><a href="<?= $this->Url->build('/about') ?>"><i class="fas fa-chevron-right" style="font-size:0.6rem;"></i> About Us</a></li>
                    <li><a href="<?= $this->Url->build('/contact') ?>"><i class="fas fa-chevron-right" style="font-size:0.6rem;"></i> Contact Us</a></li>
                    <li><a href="#"><i class="fas fa-chevron-right" style="font-size:0.6rem;"></i> Privacy Policy</a></li>
                    <li><a href="#"><i class="fas fa-chevron-right" style="font-size:0.6rem;"></i> FAQ</a></li>
                </ul>
            </div>

            <!-- Contact -->
            <div>
                <h6 class="footer-heading">Contact Us</h6>
                <div class="footer-info-item"><i class="fas fa-map-marker-alt"></i><span>Lot14191, Parit 7, Kg. Sungai Leman, 45400 Sekinchan, Selangor</span></div>
                <div class="footer-info-item"><i class="fas fa-clock"></i><span>Mon – Sat: 8:00 AM – 6:00 PM</span></div>
                <div class="footer-info-item"><i class="fas fa-phone"></i><span>+60 12-345 6789</span></div>
                <div class="footer-info-item"><i class="fas fa-envelope"></i><span>hello@mybake.com.my</span></div>
            </div>
        </div>
    </div>
    <div class="footer-bottom">
        <div class="container">
            <p>&copy; <?= date('Y') ?> MyBake. All rights reserved. Made with <i class="fas fa-heart" style="color:var(--secondary-gold);"></i> in Sekinchan, Selangor.</p>
        </div>
    </div>
</footer>

<!-- Scroll to Top -->
<button class="scroll-top" id="scrollTopBtn" onclick="window.scrollTo({top:0,behavior:'smooth'})" aria-label="Scroll to top">
    <i class="fas fa-chevron-up"></i>
</button>

<?php elseif ($isAdminPage): ?>
<!-- ══════════════════════════════════════════════════════════
     ADMIN LAYOUT
     ══════════════════════════════════════════════════════════ -->
<div class="admin-layout">
    <!-- Admin Sidebar -->
    <aside class="admin-sidebar" id="adminSidebar">
        <div style="padding:1.5rem; border-bottom:1px solid rgba(255,255,255,0.1);">
            <div style="display:flex; align-items:center; gap:0.75rem;">
                <div class="brand-icon" style="background:var(--secondary-gold); width:40px; height:40px;">
                    <span style="color:#fff; font-size:0.8rem;">MB</span>
                </div>
                <div>
                    <div style="font-family:'Playfair Display',serif; font-weight:700; color:#fff; font-size:1.1rem;">MyBake</div>
                    <div style="font-size:0.65rem; color:rgba(255,255,255,0.5);">Admin Panel</div>
                </div>
            </div>
        </div>

        <div style="padding:1rem 0.75rem; border-bottom:1px solid rgba(255,255,255,0.1);">
            <div style="display:flex; align-items:center; gap:0.75rem; padding:0.5rem 0.75rem;">
                <div class="sidebar-avatar" style="background:var(--secondary-gold); width:36px; height:36px; font-size:0.85rem;"><?= h($userInitial) ?></div>
                <div>
                    <div style="font-size:0.85rem; font-weight:600; color:#fff;"><?= h($fullName) ?></div>
                    <div style="font-size:0.7rem; color:rgba(255,255,255,0.5);">Administrator</div>
                </div>
            </div>
        </div>

        <nav style="padding:1rem 0.75rem; flex:1;">
            <p style="font-size:0.65rem; font-weight:700; text-transform:uppercase; letter-spacing:0.08em; color:rgba(255,255,255,0.4); padding:0 0.75rem; margin-bottom:0.5rem;">Admin Menu</p>
            <a href="<?= $this->Url->build('/admin/dashboard') ?>" class="admin-nav-item <?= ($action === 'dashboard') ? 'active' : '' ?>">
                <i class="fas fa-chart-line"></i> Dashboard
            </a>
            <a href="<?= $this->Url->build('/admin/orders') ?>" class="admin-nav-item <?= ($action === 'orders' || $action === 'updateStatus') ? 'active' : '' ?>">
                <i class="fas fa-clipboard-list"></i> Total Orders
            </a>
            <a href="<?= $this->Url->build('/admin/sales') ?>" class="admin-nav-item <?= ($controller === 'Sales') ? 'active' : '' ?>">
                <i class="fas fa-chart-bar"></i> Sales Management
            </a>
            <a href="<?= $this->Url->build('/admin/stock') ?>" class="admin-nav-item <?= ($action === 'stock' || $action === 'restock' || $action === 'toggleStatus') ? 'active' : '' ?>">
                <i class="fas fa-boxes-stacked"></i> Stock & Products
            </a>
            <div style="margin-top:1rem; border-top:1px solid rgba(255,255,255,0.1); padding-top:1rem;">
                <p style="font-size:0.65rem; font-weight:700; text-transform:uppercase; letter-spacing:0.08em; color:rgba(255,255,255,0.4); padding:0 0.75rem; margin-bottom:0.5rem;">Customer Site</p>
                <a href="<?= $this->Url->build('/dashboard') ?>" class="admin-nav-item">
                    <i class="fas fa-arrow-left"></i> Back to Store
                </a>
            </div>
        </nav>

        <div style="padding:1rem 0.75rem; border-top:1px solid rgba(255,255,255,0.1);">
            <a href="<?= $this->Url->build('/logout') ?>" class="logout-btn" style="background:rgba(255,255,255,0.1); color:rgba(255,255,255,0.8);" onmouseover="this.style.background='rgba(220,38,38,0.3)'; this.style.color='#fff'" onmouseout="this.style.background='rgba(255,255,255,0.1)'; this.style.color='rgba(255,255,255,0.8)'">
                <i class="fas fa-right-from-bracket"></i> Logout
            </a>
        </div>
    </aside>

    <!-- Admin Main -->
    <div class="admin-main">
        <!-- Admin Top Bar -->
        <div style="background:#fff; border-bottom:1px solid var(--border-light); padding:0 1.5rem; height:64px; display:flex; align-items:center; justify-content:space-between; position:sticky; top:0; z-index:50;">
            <div style="display:flex; align-items:center; gap:1rem;">
                <button onclick="document.getElementById('adminSidebar').classList.toggle('open')" style="background:none; border:none; cursor:pointer; padding:0.4rem; border-radius:8px; display:none;" class="admin-menu-toggle">
                    <i class="fas fa-bars" style="font-size:1.1rem; color:var(--text-dark);"></i>
                </button>
                <h1 style="font-family:'Playfair Display',serif; font-size:1.25rem; font-weight:700;"><?= $this->fetch('title') ?: 'Admin Panel' ?></h1>
            </div>
            <div style="display:flex; align-items:center; gap:1rem;">
                <div class="clock-display"><i class="fas fa-clock" style="color:var(--primary-teal);"></i><span id="clockText"></span></div>
                <span style="font-size:0.85rem; color:var(--text-muted);">Welcome, <?= h($firstName) ?></span>
            </div>
        </div>

        <div style="padding:1.5rem;">
            <?= $this->Flash->render() ?>
            <?= $this->fetch('content') ?>
        </div>
    </div>
</div>

<?php else: ?>
<!-- ══════════════════════════════════════════════════════════
     AUTH LAYOUT (Login / Register)
     ══════════════════════════════════════════════════════════ -->
    <?= $this->fetch('content') ?>
<?php endif; ?>

<!-- Flash Messages (for customer layout) -->
<?php if (!$isAuthPage && !$isAdminPage): ?>
<div id="flashContainer" style="position:fixed; top:80px; right:1rem; z-index:1000; width:320px;"></div>
<?php endif; ?>

<!-- ── SCRIPTS ─────────────────────────────────────────── -->
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@4/dist/chart.umd.min.js"></script>

<script>
// ── Real-time Clock ──────────────────────────────────
function updateClock() {
    const el = document.getElementById('clockText');
    if (!el) return;
    el.textContent = new Date().toLocaleString('en-MY', { dateStyle: 'medium', timeStyle: 'short' });
}
setInterval(updateClock, 1000);
updateClock();

// ── Sidebar ──────────────────────────────────────────
function toggleSidebar() {
    const sb  = document.getElementById('mainSidebar');
    const ov  = document.getElementById('sidebarOverlay');
    const btn = document.getElementById('burgerBtn');
    if (!sb) return;
    sb.classList.toggle('open');
    ov.classList.toggle('open');
    btn.classList.toggle('open');
}
function closeSidebar() {
    const sb  = document.getElementById('mainSidebar');
    const ov  = document.getElementById('sidebarOverlay');
    const btn = document.getElementById('burgerBtn');
    if (!sb) return;
    sb.classList.remove('open');
    ov.classList.remove('open');
    btn && btn.classList.remove('open');
}

// ── Cart Panel ───────────────────────────────────────
function openCart() {
    loadCart();
    document.getElementById('cartPanel').classList.add('open');
    document.getElementById('cartOverlay').classList.add('open');
}
function closeCart() {
    document.getElementById('cartPanel').classList.remove('open');
    document.getElementById('cartOverlay').classList.remove('open');
}

function loadCart() {
    fetch('<?= $this->Url->build('/cart') ?>', { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
        .then(r => r.json())
        .catch(() => null)
        .then(data => { if (data) renderCart(data); });
}

function renderCart(data) {
    const container = document.getElementById('cartItemsContainer');
    const empty     = document.getElementById('cartEmpty');
    const footer    = document.getElementById('cartFooter');
    const totalEl   = document.getElementById('cartTotal');
    const countEl   = document.getElementById('cartPanelCount');
    if (!container) return;

    const items = data.items || [];
    let total = 0, count = 0;

    if (items.length === 0) {
        container.innerHTML = '';
        empty.style.display = 'block';
        footer.style.display = 'none';
        updateCartBadge(0);
        return;
    }

    empty.style.display = 'none';
    footer.style.display = 'block';

    container.innerHTML = items.map(item => {
        const sub = parseFloat(item.product?.price || 0) * item.quantity;
        total += sub; count += item.quantity;
        return `<div class="cart-item" id="cartItem-${item.id}">
            <img src="<?= $this->Url->build('/img/products/${item.product?.image || 'default.jpg'}') ?>" class="cart-item-img" onerror="this.src='/img/products/default.jpg'" alt="${item.product?.name}">
            <div style="flex:1; min-width:0;">
                <div style="font-weight:600; font-size:0.875rem; margin-bottom:0.25rem; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">${item.product?.name || 'Product'}</div>
                <div style="font-size:0.8rem; color:var(--text-muted); margin-bottom:0.5rem;">RM ${parseFloat(item.product?.price || 0).toFixed(2)} each</div>
                <div style="display:flex; align-items:center; gap:0.5rem;">
                    <button class="cart-qty-btn" onclick="updateCartItem(${item.id}, ${item.quantity - 1})">−</button>
                    <span style="font-weight:600; min-width:20px; text-align:center;">${item.quantity}</span>
                    <button class="cart-qty-btn" onclick="updateCartItem(${item.id}, ${item.quantity + 1})">+</button>
                </div>
            </div>
            <div style="text-align:right; flex-shrink:0;">
                <div style="font-weight:700; color:var(--primary-teal); font-size:0.875rem;">RM ${sub.toFixed(2)}</div>
                <button onclick="removeCartItem(${item.id})" style="background:none; border:none; color:#DC2626; cursor:pointer; font-size:0.75rem; margin-top:0.5rem; padding:0.2rem;">
                    <i class="fas fa-trash-alt"></i>
                </button>
            </div>
        </div>`;
    }).join('');

    totalEl.textContent = 'RM ' + total.toFixed(2);
    updateCartBadge(count);
    if (countEl) countEl.textContent = count;
}

function updateCartItem(id, qty) {
    fetch(`/cart/update/${id}`, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
        body: JSON.stringify({ quantity: qty })
    }).then(r => r.json()).then(d => {
        if (d.success) loadCart();
    });
}

function removeCartItem(id) {
    fetch(`/cart/remove/${id}`, {
        method: 'POST',
        headers: { 'X-Requested-With': 'XMLHttpRequest' }
    }).then(r => r.json()).then(d => {
        if (d.success) loadCart();
    });
}

function addToCart(productId, quantity) {
    const formData = new FormData();
    formData.append('product_id', productId);
    formData.append('quantity', quantity);

    fetch('<?= $this->Url->build('/cart/add') ?>', {
        method: 'POST',
        body: formData,
        headers: { 'X-Requested-With': 'XMLHttpRequest' }
    })
    .then(r => r.json())
    .then(data => {
        if (data.success) {
            updateCartBadge(data.cartCount);
            showFlash('success', 'Item added to cart! 🛒');
        } else {
            showFlash('error', data.error || 'Could not add to cart.');
        }
    })
    .catch(() => showFlash('error', 'Something went wrong.'));
}

function updateCartBadge(count) {
    const badge   = document.getElementById('cartBadge');
    const panelCt = document.getElementById('cartPanelCount');
    if (badge) {
        badge.textContent = count;
        badge.classList.toggle('hidden', count === 0);
    }
    if (panelCt) panelCt.textContent = count;
}

// ── Flash Toast ──────────────────────────────────────
function showFlash(type, msg) {
    const c = document.getElementById('flashContainer');
    if (!c) return;
    const el = document.createElement('div');
    el.className = `flash-message flash-${type}`;
    el.innerHTML = `<i class="fas fa-${type === 'success' ? 'circle-check' : 'circle-xmark'}"></i> ${msg}`;
    c.appendChild(el);
    setTimeout(() => { el.style.opacity='0'; setTimeout(() => el.remove(), 300); }, 3500);
}

// ── User Dropdown ────────────────────────────────────
function toggleUserMenu() {
    const d = document.getElementById('userDropdown');
    if (d) d.style.display = d.style.display === 'none' ? 'block' : 'none';
}
document.addEventListener('click', function(e) {
    const wrapper = document.getElementById('userMenuWrapper');
    const d = document.getElementById('userDropdown');
    if (d && wrapper && !wrapper.contains(e.target)) {
        d.style.display = 'none';
    }
});

// ── Scroll to Top ────────────────────────────────────
const scrollBtn = document.getElementById('scrollTopBtn');
if (scrollBtn) {
    window.addEventListener('scroll', () => {
        scrollBtn.classList.toggle('visible', window.scrollY > 400);
    });
}

// ── Logout Confirm ───────────────────────────────────
function confirmLogout(e, url) {
    e.preventDefault();
    Swal.fire({
        title: 'Logging out?',
        text: 'You will be redirected to the login page.',
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: 'var(--primary-teal)',
        cancelButtonColor: '#9CA3AF',
        confirmButtonText: 'Yes, logout',
        cancelButtonText: 'Cancel',
        borderRadius: '16px',
    }).then((result) => {
        if (result.isConfirmed) window.location.href = url;
    });
}
document.querySelectorAll('#logoutBtn, #userLogoutBtn').forEach(btn => {
    btn.addEventListener('click', function(e) { confirmLogout(e, '/logout'); });
});
</script>

<?= $this->fetch('script') ?>
</body>
</html>