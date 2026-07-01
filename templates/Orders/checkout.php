<?php $this->assign('title', 'Checkout'); ?>

<div style="padding:2rem 0 4rem;">
<div class="container" style="max-width:960px;">

<div style="margin-bottom:2rem;">
    <a href="<?= $this->Url->build('/products') ?>" style="color:var(--text-muted); font-size:0.875rem; display:inline-flex; align-items:center; gap:0.4rem; margin-bottom:0.75rem; transition:color 0.2s;">
        <i class="fas fa-arrow-left"></i> Continue Shopping
    </a>
    <p class="section-label">Order Confirmation</p>
    <h1 class="section-title">Checkout</h1>
</div>

<?= $this->Flash->render() ?>

<?= $this->Form->create(null, ['url' => ['controller' => 'Orders', 'action' => 'checkout']]) ?>
<div style="display:grid; grid-template-columns:1fr 380px; gap:2rem; align-items:start;">

    <!-- LEFT: Order Details -->
    <div>
        <!-- Cart Items Summary -->
        <div style="background:#fff; border-radius:20px; border:1px solid var(--border-light); overflow:hidden; margin-bottom:1.5rem; box-shadow:var(--shadow-sm);">
            <div style="padding:1.25rem 1.5rem; background:linear-gradient(135deg,var(--primary-emerald-dark),var(--primary-emerald)); color:#fff; display:flex; align-items:center; gap:0.6rem;">
                <i class="fas fa-bag-shopping"></i>
                <span style="font-weight:700;">Your Items (<?= count($cart->cart_items) ?> products)</span>
            </div>
            <div style="padding:1rem;">
                <?php foreach ($cart->cart_items as $item): ?>
                <div style="display:flex; align-items:center; gap:1rem; padding:0.875rem 0; border-bottom:1px solid var(--border-light);">
                    <img src="<?= $this->Url->build('/img/products/' . h($item->product->image ?? 'default.jpg')) ?>"
                         onerror="this.src='https://placehold.co/56x56/E8F7F7/1A7A7A?text=MB'"
                         alt="<?= h($item->product->name) ?>"
                         style="width:56px; height:56px; border-radius:10px; object-fit:cover; background:var(--bg-light); flex-shrink:0;">
                    <div style="flex:1; min-width:0;">
                        <div style="font-weight:600; font-size:0.875rem; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;"><?= h($item->product->name) ?></div>
                        <div style="font-size:0.78rem; color:var(--text-muted);">RM <?= number_format($item->product->price, 2) ?> × <?= $item->quantity ?></div>
                    </div>
                    <div style="font-weight:700; color:var(--primary-emerald); font-size:0.9rem; flex-shrink:0;">
                        RM <?= number_format($item->product->price * $item->quantity, 2) ?>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Delivery Address -->
        <div style="background:#fff; border-radius:20px; border:1px solid var(--border-light); overflow:hidden; margin-bottom:1.5rem; box-shadow:var(--shadow-sm);">
            <div style="padding:1.25rem 1.5rem; border-bottom:1px solid var(--border-light); display:flex; align-items:center; justify-content:space-between;">
                <div style="display:flex; align-items:center; gap:0.6rem; font-weight:700;">
                    <i class="fas fa-map-marker-alt" style="color:var(--primary-emerald);"></i> Delivery Address
                </div>
                <a href="<?= $this->Url->build('/profile/addresses/add') ?>" style="font-size:0.8rem; color:var(--primary-emerald); font-weight:600;">+ Add New</a>
            </div>
            <div style="padding:1.25rem 1.5rem;">
                <?php if (!empty($addresses) && count($addresses) > 0): ?>
                <div style="display:flex; flex-direction:column; gap:0.75rem;">
                    <?php foreach ($addresses as $addr): ?>
                    <label style="display:flex; align-items:flex-start; gap:0.875rem; padding:0.875rem; border:2px solid <?= $addr->is_default ? 'var(--secondary-gold)' : 'var(--border-light)' ?>; border-radius:12px; cursor:pointer; transition:var(--transition); background:<?= $addr->is_default ? 'var(--secondary-gold-xlight)' : 'var(--white)' ?>;">
                        <input type="radio" name="address_id" value="<?= $addr->id ?>" style="margin-top:0.2rem; accent-color:var(--primary-emerald);" <?= $addr->is_default ? 'checked' : '' ?>>
                        <div style="flex:1;">
                            <div style="font-weight:600; font-size:0.875rem; margin-bottom:0.2rem;"><?= h($addr->label ?? 'Address') ?></div>
                            <div style="color:var(--text-muted); font-size:0.8rem; line-height:1.6;">
                                <?= h($addr->address_line) ?><?= $addr->unit_no ? ', ' . h($addr->unit_no) : '' ?>,<br>
                                <?= h($addr->city) ?>, <?= h($addr->state) ?> <?= h($addr->postal_code) ?>
                            </div>
                        </div>
                        <?php if ($addr->is_default): ?>
                        <span style="font-size:0.65rem; font-weight:700; background:var(--secondary-gold); color:#fff; padding:0.15rem 0.4rem; border-radius:4px; flex-shrink:0;">DEFAULT</span>
                        <?php endif; ?>
                    </label>
                    <?php endforeach; ?>
                </div>
                <?php else: ?>
                <div style="text-align:center; padding:1.5rem; color:var(--text-muted);">
                    <i class="fas fa-map-marker-alt" style="font-size:2rem; opacity:0.3; margin-bottom:0.75rem; display:block;"></i>
                    <p style="font-size:0.875rem;">No saved addresses. <a href="<?= $this->Url->build('/profile/addresses/add') ?>" style="color:var(--primary-emerald); font-weight:600;">Add one now</a>.</p>
                </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Payment Method -->
        <div style="background:#fff; border-radius:20px; border:1px solid var(--border-light); overflow:hidden; margin-bottom:1.5rem; box-shadow:var(--shadow-sm);">
            <div style="padding:1.25rem 1.5rem; border-bottom:1px solid var(--border-light);">
                <div style="font-weight:700; display:flex; align-items:center; gap:0.6rem;">
                    <i class="fas fa-credit-card" style="color:var(--secondary-gold-dark);"></i> Payment Method
                </div>
            </div>
            <div style="padding:1.25rem 1.5rem;">
                <div style="display:flex; flex-direction:column; gap:0.75rem;">
                    <label style="display:flex; align-items:center; gap:0.875rem; padding:1rem; border:2px solid var(--primary-emerald); border-radius:12px; cursor:pointer; background:var(--primary-emerald-xlight);" onclick="this.parentElement.querySelectorAll('label').forEach(l=>{l.style.borderColor='var(--border-light)'; l.style.background='var(--white)';}); this.style.borderColor='var(--primary-emerald)'; this.style.background='var(--primary-emerald-xlight)';">
                        <input type="radio" name="payment_method" value="fpx" checked style="accent-color:var(--primary-emerald);">
                        <div style="flex:1;">
                            <div style="font-weight:600; font-size:0.9rem;">FPX Online Banking</div>
                            <div style="color:var(--text-muted); font-size:0.8rem;">Maybank2u, CIMB Clicks, RHB Now, etc.</div>
                        </div>
                        <i class="fas fa-building-columns" style="font-size:1.5rem; color:var(--primary-emerald); opacity:0.8;"></i>
                    </label>
                    <label style="display:flex; align-items:center; gap:0.875rem; padding:1rem; border:2px solid var(--border-light); border-radius:12px; cursor:pointer; background:var(--white);" onclick="this.parentElement.querySelectorAll('label').forEach(l=>{l.style.borderColor='var(--border-light)'; l.style.background='var(--white)';}); this.style.borderColor='var(--primary-emerald)'; this.style.background='var(--primary-emerald-xlight)';">
                        <input type="radio" name="payment_method" value="card" style="accent-color:var(--primary-emerald);">
                        <div style="flex:1;">
                            <div style="font-weight:600; font-size:0.9rem;">Credit / Debit Card</div>
                            <div style="color:var(--text-muted); font-size:0.8rem;">Visa, Mastercard</div>
                        </div>
                        <div style="display:flex; gap:0.4rem; color:#1434CB; font-size:1.5rem; opacity:0.8;">
                            <i class="fab fa-cc-visa"></i> <i class="fab fa-cc-mastercard" style="color:#EB001B;"></i>
                        </div>
                    </label>
                </div>
            </div>
        </div>

        <!-- Notes -->
        <div style="background:#fff; border-radius:20px; border:1px solid var(--border-light); overflow:hidden; box-shadow:var(--shadow-sm);">
            <div style="padding:1.25rem 1.5rem; border-bottom:1px solid var(--border-light);">
                <div style="font-weight:700; display:flex; align-items:center; gap:0.6rem;">
                    <i class="fas fa-note-sticky" style="color:var(--secondary-gold-dark);"></i> Order Notes
                </div>
            </div>
            <div style="padding:1.25rem 1.5rem;">
                <textarea name="notes" rows="3" placeholder="Any special requests? (optional)" class="form-control" style="resize:vertical;"></textarea>
            </div>
        </div>
    </div>

    <!-- RIGHT: Order Summary -->
    <div style="position:sticky; top:90px;">
        <div style="background:#fff; border-radius:20px; border:1px solid var(--border-light); overflow:hidden; box-shadow:var(--shadow-sm);">
            <div style="padding:1.25rem 1.5rem; background:linear-gradient(135deg,var(--primary-emerald-dark),var(--primary-emerald)); color:#fff;">
                <div style="font-weight:700; font-size:1rem; display:flex; align-items:center; gap:0.6rem;">
                    <i class="fas fa-receipt"></i> Order Summary
                </div>
            </div>
            <div style="padding:1.5rem;">
                <?php foreach ($cart->cart_items as $item): ?>
                <div style="display:flex; justify-content:space-between; font-size:0.825rem; color:var(--text-muted); margin-bottom:0.5rem;">
                    <span><?= h($item->product->name) ?> × <?= $item->quantity ?></span>
                    <span>RM <?= number_format($item->product->price * $item->quantity, 2) ?></span>
                </div>
                <?php endforeach; ?>

                <?php
                $subtotal = 0;
                foreach ($cart->cart_items as $item) {
                    $subtotal += $item->product->price * $item->quantity;
                }
                $discount = ($subtotal >= 150) ? ($subtotal * 0.20) : 0;
                $deliveryFee = ($subtotal >= 100) ? 0 : 8.00;
                $grandTotal = ($subtotal - $discount) + $deliveryFee;
                ?>

                <div style="border-top:1px solid var(--border-light); margin:1rem 0; padding-top:1rem;">
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
                    <div style="display:flex; justify-content:space-between; font-size:0.875rem; margin-bottom:0.5rem;">
                        <span style="color:var(--text-muted);">Delivery Fee</span>
                        <span style="color:#15803D; font-weight:600;"><?= $deliveryFee == 0 ? 'FREE' : 'RM 8.00' ?></span>
                    </div>
                </div>

                <div style="display:flex; justify-content:space-between; align-items:center; padding-top:0.75rem; border-top:2px solid var(--border-light);">
                    <span style="font-weight:700; font-size:1rem;">Total</span>
                    <span style="font-family:'Playfair Display',serif; font-size:1.5rem; font-weight:800; color:var(--primary-emerald);">
                        RM <?= number_format($grandTotal, 2) ?>
                    </span>
                </div>

                <?php if ($subtotal < 100): ?>
                <div style="background:var(--secondary-gold-xlight); border:1px solid rgba(201,168,76,0.3); border-radius:10px; padding:0.75rem; margin-top:1rem; font-size:0.8rem; color:var(--secondary-gold-dark);">
                    <i class="fas fa-truck"></i> Add RM <?= number_format(100 - $subtotal, 2) ?> more for FREE delivery!
                </div>
                <?php endif; ?>
                <?php if ($subtotal >= 100 && $subtotal < 150): ?>
                <div style="background:var(--primary-emerald-xlight); border:1px solid rgba(16,185,129,0.3); border-radius:10px; padding:0.75rem; margin-top:1rem; font-size:0.8rem; color:var(--primary-emerald);">
                    <i class="fas fa-tags"></i> Add RM <?= number_format(150 - $subtotal, 2) ?> more to get 20% OFF your entire order!
                </div>
                <?php endif; ?>

                <button type="submit" class="btn btn-gold btn-full btn-lg" style="margin-top:1.5rem;" onclick="this.disabled=true; this.innerHTML='<i class=\'fas fa-spinner fa-spin\'></i> Processing Payment...'; this.form.submit();">
                    <i class="fas fa-lock"></i> Confirm & Pay RM <?= number_format($grandTotal, 2) ?>
                </button>

                <p style="text-align:center; color:var(--text-muted); font-size:0.75rem; margin-top:0.875rem;">
                    <i class="fas fa-shield-halved" style="color:var(--primary-emerald);"></i>
                    Secure simulated checkout via ToyyibPay.
                </p>
            </div>
        </div>

        <!-- Contact info reminder -->
        <div style="background:#fff; border-radius:16px; border:1px solid var(--border-light); padding:1.25rem; margin-top:1rem; box-shadow:var(--shadow-sm);">
            <div style="font-size:0.8rem; color:var(--text-muted); display:flex; align-items:flex-start; gap:0.5rem;">
                <i class="fas fa-phone" style="color:var(--primary-emerald); margin-top:0.1rem; flex-shrink:0;"></i>
                <div>Your order will be delivered to your saved address. Contact us at <a href="tel:+60123456789" style="color:var(--primary-emerald); font-weight:600;">+60 12-345 6789</a> for bulk orders.</div>
            </div>
        </div>
    </div>

</div>
<?= $this->Form->end() ?>
</div>
</div>

<style>
@media(max-width:900px){ [style*="grid-template-columns:1fr 380px"]{grid-template-columns:1fr!important;} }
</style>
