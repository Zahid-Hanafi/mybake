<?php $this->assign('title', 'Edit Order #' . $order->id); ?>
<div style="padding:2rem 0 4rem;">
<div class="container" style="max-width:800px;">
    <div style="margin-bottom:1.5rem;">
        <a href="<?= $this->Url->build('/my-orders') ?>" style="color:var(--text-muted); font-size:0.875rem; display:inline-flex; align-items:center; gap:0.4rem; margin-bottom:0.75rem;">
            <i class="fas fa-arrow-left"></i> Back to My Orders
        </a>
        <h1 class="section-title">Edit Order #<?= $order->id ?></h1>
        <p style="color:var(--text-muted); font-size:0.875rem;">Update your delivery address or order notes. Product items cannot be changed.</p>
    </div>

    <?= $this->Flash->render() ?>

    <div style="background:#fff; border-radius:20px; border:1px solid var(--border-light); box-shadow:var(--shadow-sm); padding:2rem;">
        <?= $this->Form->create($order, ['url' => ['controller' => 'Orders', 'action' => 'edit', $order->id]]) ?>

        <div class="form-group">
            <label class="form-label">Delivery Address <span style="color:#DC2626;">*</span></label>
            <?php if (!empty($addresses)): ?>
                <div style="display:flex; flex-direction:column; gap:0.75rem; margin-bottom:1rem;">
                <?php foreach ($addresses as $addr): ?>
                    <label style="display:flex; align-items:flex-start; gap:0.875rem; padding:0.875rem; border:2px solid <?= $addr->id === $order->address_id ? 'var(--primary-emerald)' : 'var(--border-light)' ?>; border-radius:12px; cursor:pointer; background:<?= $addr->id === $order->address_id ? 'var(--primary-emerald-xlight)' : 'var(--white)' ?>;" onclick="this.parentElement.querySelectorAll('label').forEach(l=>{l.style.borderColor='var(--border-light)'; l.style.background='var(--white)';}); this.style.borderColor='var(--primary-emerald)'; this.style.background='var(--primary-emerald-xlight)';">
                        <input type="radio" name="address_id" value="<?= $addr->id ?>" style="margin-top:0.2rem; accent-color:var(--primary-emerald);" <?= $addr->id === $order->address_id ? 'checked' : '' ?>>
                        <div style="flex:1;">
                            <div style="font-weight:600; font-size:0.875rem; margin-bottom:0.2rem;"><?= h($addr->label ?? 'Address') ?></div>
                            <div style="color:var(--text-muted); font-size:0.8rem; line-height:1.6;">
                                <?= h($addr->address_line) ?><?= $addr->unit_no ? ', ' . h($addr->unit_no) : '' ?>,<br>
                                <?= h($addr->city) ?>, <?= h($addr->state) ?> <?= h($addr->postal_code) ?>
                            </div>
                        </div>
                    </label>
                <?php endforeach; ?>
                </div>
            <?php else: ?>
                <textarea name="delivery_address" class="form-control" rows="3" required><?= h($order->delivery_address) ?></textarea>
            <?php endif; ?>
        </div>

        <div class="form-group">
            <label class="form-label">Phone Number <span style="color:#DC2626;">*</span></label>
            <?= $this->Form->control('phone_no', ['label' => false, 'class' => 'form-control', 'required' => true]) ?>
        </div>

        <div class="form-group">
            <label class="form-label">Order Notes <span style="color:var(--text-muted); font-weight:400;">(optional)</span></label>
            <?= $this->Form->control('notes', ['label' => false, 'class' => 'form-control', 'type' => 'textarea', 'rows' => 3]) ?>
        </div>

        <div style="display:grid; grid-template-columns:1fr 1fr; gap:1rem; margin-top:2rem;">
            <a href="<?= $this->Url->build('/my-orders') ?>" class="btn btn-outline"><i class="fas fa-times"></i> Cancel</a>
            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Save Changes</button>
        </div>

        <?= $this->Form->end() ?>
    </div>
</div>
</div>
