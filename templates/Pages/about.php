<?php $this->assign('title', 'About Us'); ?>

<!-- Hero Banner -->
<div style="background:linear-gradient(135deg, var(--primary-teal-dark), var(--primary-teal)); padding:4rem 0; text-align:center; margin-bottom:0;">
    <div class="container">
        <p style="color:var(--secondary-gold-light); font-size:0.8rem; font-weight:700; text-transform:uppercase; letter-spacing:0.1em; margin-bottom:0.75rem;">Est. 1990 · Sekinchan, Selangor</p>
        <h1 style="font-family:'Playfair Display',serif; font-size:3rem; font-weight:800; color:#fff; margin-bottom:1rem;">Our Story</h1>
        <p style="color:rgba(255,255,255,0.75); max-width:540px; margin:0 auto; line-height:1.7;">From a humble kitchen in Sekinchan to the hands of thousands of happy customers across Malaysia — this is the story of MyBake.</p>
    </div>
</div>

<!-- Wave divider -->
<div style="background:linear-gradient(135deg, var(--primary-teal-dark), var(--primary-teal)); line-height:0;">
    <svg viewBox="0 0 1440 40" xmlns="http://www.w3.org/2000/svg"><path d="M0,40 C360,0 1080,40 1440,0 L1440,40 Z" fill="#FAF7F2"/></svg>
</div>

<div style="padding:3rem 0 4rem;">
<div class="container">

<!-- About MyBake -->
<section style="display:grid; grid-template-columns:1fr 1fr; gap:4rem; align-items:center; margin-bottom:5rem;">
    <div>
        <p class="section-label">Who We Are</p>
        <h2 class="section-title" style="margin-bottom:1.25rem;">Authentic Taste, Crafted with Love</h2>
        <p style="color:var(--text-muted); line-height:1.8; margin-bottom:1rem;">MyBake was founded in 1990 by a passionate home baker in the heart of Sekinchan, Selangor. What started as a small family business sharing traditional Malay snacks with neighbors has grown into a beloved brand trusted by customers across Malaysia.</p>
        <p style="color:var(--text-muted); line-height:1.8; margin-bottom:1.5rem;">We specialize in three iconic traditional snacks — <strong style="color:var(--primary-teal);">Bahulu</strong>, <strong style="color:var(--primary-teal);">Rempeyek</strong>, and <strong style="color:var(--primary-teal);">Kerepek Ubi</strong> — each crafted using time-honored family recipes, fresh local ingredients, and genuine care in every step of preparation.</p>
        <div style="display:flex; gap:1rem; flex-wrap:wrap;">
            <div style="text-align:center; padding:1rem 1.25rem; background:var(--primary-teal-xlight); border-radius:12px; border:1px solid rgba(26,122,122,0.15);">
                <div style="font-family:'Playfair Display',serif; font-size:2rem; font-weight:800; color:var(--primary-teal);">35+</div>
                <div style="font-size:0.75rem; color:var(--text-muted); font-weight:500;">Years of Excellence</div>
            </div>
            <div style="text-align:center; padding:1rem 1.25rem; background:var(--secondary-gold-xlight); border-radius:12px; border:1px solid rgba(201,168,76,0.15);">
                <div style="font-family:'Playfair Display',serif; font-size:2rem; font-weight:800; color:var(--secondary-gold-dark);">16</div>
                <div style="font-size:0.75rem; color:var(--text-muted); font-weight:500;">Product Varieties</div>
            </div>
            <div style="text-align:center; padding:1rem 1.25rem; background:var(--primary-teal-xlight); border-radius:12px; border:1px solid rgba(26,122,122,0.15);">
                <div style="font-family:'Playfair Display',serif; font-size:2rem; font-weight:800; color:var(--primary-teal);">100%</div>
                <div style="font-size:0.75rem; color:var(--text-muted); font-weight:500;">Homemade Quality</div>
            </div>
        </div>
    </div>
    <div style="position:relative;">
        <div style="background:linear-gradient(135deg, var(--primary-teal-dark), var(--primary-teal-light)); border-radius:20px; padding:2.5rem; text-align:center; box-shadow:var(--shadow-lg);">
            <i class="fas fa-cookie-bite" style="font-size:5rem; color:var(--secondary-gold-light); margin-bottom:1rem; display:block;"></i>
            <div style="font-family:'Playfair Display',serif; font-size:1.25rem; font-weight:700; color:#fff; margin-bottom:0.5rem;">Traditional Recipes</div>
            <p style="color:rgba(255,255,255,0.7); font-size:0.875rem; line-height:1.6;">Every product is made using recipes passed down through generations, preserving the authentic taste of Malaysian heritage.</p>
        </div>
        <div style="position:absolute; bottom:-1.5rem; left:-1.5rem; background:#fff; border-radius:16px; padding:1rem 1.25rem; box-shadow:var(--shadow-md); border:1px solid var(--border-light);">
            <div style="display:flex; align-items:center; gap:0.5rem;">
                <i class="fas fa-award" style="color:var(--secondary-gold); font-size:1.25rem;"></i>
                <div>
                    <div style="font-weight:700; font-size:0.875rem; color:var(--text-dark);">Award Winning</div>
                    <div style="font-size:0.7rem; color:var(--text-muted);">Recognized quality</div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- What We Sell -->
<section style="margin-bottom:5rem;">
    <div style="text-align:center; margin-bottom:2.5rem;">
        <p class="section-label">Our Specialties</p>
        <h2 class="section-title">What We Make</h2>
    </div>
    <div style="display:grid; grid-template-columns:repeat(3,1fr); gap:1.5rem;">
        <?php
        $products_info = [
            ['🍪','Bahulu','Traditional pandan-scented sponge cakes baked in decorative molds. Available in 4 varieties: Cermai, Ikan, Pecah Lapan, and Gulung. Light, airy and perfectly sweet.','var(--primary-teal)','var(--primary-teal-xlight)'],
            ['🌾','Rempeyek','Crispy rice crackers topped with various legumes. Our Rempeyek Kacang Tanah (peanut) is our best seller! Available in Kacang Tanah, Dal, Hijau, and Mini.','var(--secondary-gold-dark)','var(--secondary-gold-xlight)'],
            ['🥔','Kerepek Ubi','Premium cassava chips in exciting flavors. Thinly sliced and fried to a perfect crunch. Available in BBQ, Black Pepper, Spicy, and Salted.','#15803D','#DCFCE7'],
        ];
        foreach ($products_info as $info): ?>
        <div class="card" style="text-align:center; padding:2rem;">
            <div style="font-size:3rem; margin-bottom:1rem;"><?= $info[0] ?></div>
            <h3 style="font-family:'Playfair Display',serif; font-size:1.25rem; margin-bottom:0.75rem; color:<?= $info[2] ?>;"><?= $info[1] ?></h3>
            <p style="color:var(--text-muted); font-size:0.875rem; line-height:1.7;"><?= $info[3] ?></p>
        </div>
        <?php endforeach; ?>
    </div>
</section>

<!-- Testimonials -->
<?php if (!empty($testimonials) && count($testimonials) > 0): ?>
<section style="margin-bottom:5rem;">
    <div style="text-align:center; margin-bottom:2.5rem;">
        <p class="section-label">💬 Happy Customers</p>
        <h2 class="section-title">What People Say</h2>
    </div>
    <div style="display:grid; grid-template-columns:repeat(3,1fr); gap:1.25rem;">
        <?php foreach ($testimonials as $t): ?>
        <div style="background:#fff; border-radius:16px; padding:1.5rem; border:1px solid var(--border-light); box-shadow:var(--shadow-sm); transition:var(--transition);" onmouseover="this.style.boxShadow='var(--shadow-md)'; this.style.transform='translateY(-2px)'" onmouseout="this.style.boxShadow='var(--shadow-sm)'; this.style.transform='none'">
            <div style="color:var(--secondary-gold); font-size:1.1rem; margin-bottom:0.875rem;">
                <?php for ($i = 0; $i < $t->rating; $i++): ?><i class="fas fa-star"></i><?php endfor; ?>
            </div>
            <p style="color:var(--text-muted); font-size:0.875rem; line-height:1.7; margin-bottom:1rem; font-style:italic;">"<?= h($t->content) ?>"</p>
            <div style="display:flex; align-items:center; gap:0.6rem; border-top:1px solid var(--border-light); padding-top:0.875rem;">
                <div class="sidebar-avatar" style="width:36px; height:36px; font-size:0.85rem; background:linear-gradient(135deg,var(--secondary-gold-dark),var(--secondary-gold));">
                    <?= strtoupper(substr($t->author_name, 0, 1)) ?>
                </div>
                <div>
                    <div style="font-weight:600; font-size:0.875rem;"><?= h($t->author_name) ?></div>
                    <div style="font-size:0.7rem; color:var(--text-muted);">Verified Customer</div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</section>
<?php endif; ?>

<!-- PDF Achievements + Contact CTA -->
<section style="display:grid; grid-template-columns:1fr 1fr; gap:1.5rem;">
    <div style="background:linear-gradient(135deg,var(--secondary-gold-dark),var(--secondary-gold)); border-radius:20px; padding:2.5rem; color:#fff; text-align:center;">
        <i class="fas fa-trophy" style="font-size:3rem; margin-bottom:1rem; display:block; opacity:0.9;"></i>
        <h3 style="font-family:'Playfair Display',serif; font-size:1.4rem; margin-bottom:0.75rem;">Awards & Achievements</h3>
        <p style="opacity:0.85; font-size:0.875rem; line-height:1.7; margin-bottom:1.5rem;">MyBake has been recognized for its exceptional quality and contribution to preserving traditional Malaysian culinary heritage.</p>
        <a href="/img/mybake-achievements.pdf" target="_blank" class="btn" style="background:rgba(255,255,255,0.2); color:#fff; border:2px solid rgba(255,255,255,0.4); border-radius:10px;">
            <i class="fas fa-file-pdf"></i> View Our Achievements (PDF)
        </a>
    </div>

    <div style="background:linear-gradient(135deg,var(--primary-teal-dark),var(--primary-teal)); border-radius:20px; padding:2.5rem; color:#fff; text-align:center;">
        <i class="fas fa-envelope" style="font-size:3rem; margin-bottom:1rem; display:block; opacity:0.9;"></i>
        <h3 style="font-family:'Playfair Display',serif; font-size:1.4rem; margin-bottom:0.75rem;">Get In Touch</h3>
        <p style="opacity:0.85; font-size:0.875rem; line-height:1.7; margin-bottom:1.5rem;">Have questions or want to place a bulk order? We'd love to hear from you. Visit our contact page for all our details.</p>
        <a href="/contact" class="btn" style="background:rgba(255,255,255,0.2); color:#fff; border:2px solid rgba(255,255,255,0.4); border-radius:10px;">
            <i class="fas fa-arrow-right"></i> Contact Us
        </a>
    </div>
</section>

</div>
</div>

<style>
@media(max-width:768px){
    [style*="grid-template-columns:1fr 1fr"]{grid-template-columns:1fr!important; gap:2rem!important;}
    [style*="grid-template-columns:repeat(3,1fr)"]{grid-template-columns:1fr!important;}
}
</style>
