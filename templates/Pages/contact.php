<?php $this->assign('title', 'Contact Us'); ?>

<!-- Hero -->
<div style="background:linear-gradient(135deg,var(--primary-emerald-dark),var(--primary-emerald)); padding:4rem 0; text-align:center;">
    <div class="container">
        <p style="color:var(--secondary-gold-light); font-size:0.8rem; font-weight:700; text-transform:uppercase; letter-spacing:0.1em; margin-bottom:0.75rem;">We're Here for You</p>
        <h1 style="font-family:'Playfair Display',serif; font-size:3rem; font-weight:800; color:#fff; margin-bottom:1rem;">Contact Us</h1>
        <p style="color:rgba(255,255,255,0.75); max-width:480px; margin:0 auto;">Have questions? Want to visit us? We'd love to hear from you.</p>
    </div>
</div>
<div style="background:linear-gradient(135deg,var(--primary-emerald-dark),var(--primary-emerald)); line-height:0;">
    <svg viewBox="0 0 1440 40" xmlns="http://www.w3.org/2000/svg"><path d="M0,40 C360,0 1080,40 1440,0 L1440,40 Z" fill="#FAF7F2"/></svg>
</div>

<div style="padding:3rem 0 4rem;">
<div class="container">

<div style="display:grid; grid-template-columns:1fr 1.6fr; gap:3rem; align-items:start;">

    <!-- Info Cards -->
    <div>
        <h2 style="font-family:'Playfair Display',serif; font-size:1.5rem; margin-bottom:1.5rem;">Our Information</h2>

        <div style="display:flex; flex-direction:column; gap:1rem; margin-bottom:2rem;">
            <!-- Location -->
            <div style="background:#fff; border-radius:16px; padding:1.25rem 1.5rem; border:1px solid var(--border-light); display:flex; align-items:flex-start; gap:1rem;">
                <div style="width:44px; height:44px; background:var(--primary-emerald-xlight); border-radius:12px; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                    <i class="fas fa-map-marker-alt" style="color:var(--primary-emerald); font-size:1.1rem;"></i>
                </div>
                <div>
                    <div style="font-weight:700; margin-bottom:0.35rem; font-size:0.9rem;">Our Location</div>
                    <div style="color:var(--text-muted); font-size:0.875rem; line-height:1.6;">Lot14191, Parit 7, Kampung Sungai Leman,<br>45400 Sekinchan, Selangor, Malaysia</div>
                </div>
            </div>

            <!-- Hours -->
            <div style="background:#fff; border-radius:16px; padding:1.25rem 1.5rem; border:1px solid var(--border-light); display:flex; align-items:flex-start; gap:1rem;">
                <div style="width:44px; height:44px; background:var(--secondary-gold-xlight); border-radius:12px; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                    <i class="fas fa-clock" style="color:var(--secondary-gold-dark); font-size:1.1rem;"></i>
                </div>
                <div>
                    <div style="font-weight:700; margin-bottom:0.35rem; font-size:0.9rem;">Operation Hours</div>
                    <div style="color:var(--text-muted); font-size:0.875rem; line-height:1.8;">
                        <div style="display:flex; justify-content:space-between; gap:1rem;"><span>Monday – Friday</span><strong style="color:var(--text-dark);">8:00 AM – 6:00 PM</strong></div>
                        <div style="display:flex; justify-content:space-between; gap:1rem;"><span>Saturday</span><strong style="color:var(--text-dark);">8:00 AM – 4:00 PM</strong></div>
                        <div style="display:flex; justify-content:space-between; gap:1rem;"><span>Sunday / Holiday</span><strong style="color:#DC2626;">Closed</strong></div>
                    </div>
                </div>
            </div>

            <!-- Phone -->
            <div style="background:#fff; border-radius:16px; padding:1.25rem 1.5rem; border:1px solid var(--border-light); display:flex; align-items:flex-start; gap:1rem;">
                <div style="width:44px; height:44px; background:var(--primary-emerald-xlight); border-radius:12px; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                    <i class="fas fa-phone" style="color:var(--primary-emerald); font-size:1.1rem;"></i>
                </div>
                <div>
                    <div style="font-weight:700; margin-bottom:0.35rem; font-size:0.9rem;">Phone Number</div>
                    <a href="tel:+60123456789" style="color:var(--primary-emerald); font-size:0.875rem; font-weight:600;">+60 12-345 6789</a>
                    <div style="color:var(--text-muted); font-size:0.8rem; margin-top:0.2rem;">WhatsApp also available</div>
                </div>
            </div>

            <!-- Email -->
            <div style="background:#fff; border-radius:16px; padding:1.25rem 1.5rem; border:1px solid var(--border-light); display:flex; align-items:flex-start; gap:1rem;">
                <div style="width:44px; height:44px; background:var(--secondary-gold-xlight); border-radius:12px; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                    <i class="fas fa-envelope" style="color:var(--secondary-gold-dark); font-size:1.1rem;"></i>
                </div>
                <div>
                    <div style="font-weight:700; margin-bottom:0.35rem; font-size:0.9rem;">Email</div>
                    <a href="mailto:hello@mybake.com.my" style="color:var(--primary-emerald); font-size:0.875rem; font-weight:600;">hello@mybake.com.my</a>
                </div>
            </div>
        </div>

        <!-- Social Links -->
        <div style="background:#fff; border-radius:16px; padding:1.25rem 1.5rem; border:1px solid var(--border-light);">
            <div style="font-weight:700; font-size:0.9rem; margin-bottom:0.875rem;">Follow Us</div>
            <div style="display:flex; gap:0.75rem;">
                <a href="https://www.facebook.com/zahid.hanafi.37" target="blank" style="width:40px; height:40px; border-radius:10px; background:var(--primary-emerald-xlight); color:var(--primary-emerald); display:flex; align-items:center; justify-content:center; text-decoration:none; transition:var(--transition);" onmouseover="this.style.background='var(--primary-emerald)'; this.style.color='#fff'" onmouseout="this.style.background='var(--primary-emerald-xlight)'; this.style.color='var(--primary-emerald)'">
                    <i class="fab fa-facebook-f"></i>
                </a>
                <a href="https://www.instagram.com/zahidhnfi.__/" target="blank" style="width:40px; height:40px; border-radius:10px; background:var(--primary-emerald-xlight); color:var(--primary-emerald); display:flex; align-items:center; justify-content:center; text-decoration:none; transition:var(--transition);" onmouseover="this.style.background='var(--primary-emerald)'; this.style.color='#fff'" onmouseout="this.style.background='var(--primary-emerald-xlight)'; this.style.color='var(--primary-emerald)'">
                    <i class="fab fa-instagram"></i>
                </a>
                <a href="https://www.tiktok.com/@pandagaming._____" target="blank" style="width:40px; height:40px; border-radius:10px; background:var(--primary-emerald-xlight); color:var(--primary-emerald); display:flex; align-items:center; justify-content:center; text-decoration:none; transition:var(--transition);" onmouseover="this.style.background='var(--primary-emerald)'; this.style.color='#fff'" onmouseout="this.style.background='var(--primary-emerald-xlight)'; this.style.color='var(--primary-emerald)'">
                    <i class="fab fa-tiktok"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Map -->
    <div>
        <h2 style="font-family:'Playfair Display',serif; font-size:1.5rem; margin-bottom:1.25rem;">Find Us Here</h2>
        <div style="border-radius:20px; overflow:hidden; box-shadow:var(--shadow-lg); border:1px solid var(--border-light);">
            <iframe
                src="https://www.google.com/maps?q=Lot14191,+Parit+7,+Kampung+Sungai+Leman,+45400+Sekinchan,+Selangor&output=embed"
                width="100%"
                height="420"
                style="border:0; display:block;"
                allowfullscreen=""
                loading="lazy"
                referrerpolicy="no-referrer-when-downgrade"
                title="MyBake Location — Sekinchan, Selangor">
            </iframe>
        </div>
        <div style="background:#fff; border-radius:12px; padding:1rem 1.25rem; margin-top:1rem; border:1px solid var(--border-light); display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:0.75rem;">
            <div style="font-size:0.875rem; color:var(--text-muted);">
                <i class="fas fa-map-pin" style="color:var(--primary-emerald); margin-right:0.4rem;"></i>
                Lot14191, Parit 7, Kg. Sungai Leman, 45400 Sekinchan, Selangor
            </div>
            <a href="https://maps.google.com/?q=Sekinchan+Selangor" target="_blank" class="btn btn-primary btn-sm">
                <i class="fas fa-directions"></i> Get Directions
            </a>
        </div>
    </div>

</div>
</div>
</div>

<style>
@media(max-width:900px){ [style*="grid-template-columns:1fr 1.6fr"]{grid-template-columns:1fr!important;} }
</style>
