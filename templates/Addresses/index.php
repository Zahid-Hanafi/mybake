<?php $this->assign('title', 'My Addresses'); ?>

<div style="padding:2rem 0 4rem;">
<div class="container" style="max-width:800px;">

<div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:2rem; flex-wrap:wrap; gap:1rem;">
    <div>
        <p class="section-label">Delivery Locations</p>
        <h1 class="section-title">My Addresses</h1>
    </div>
    <a href="<?= $this->Url->build('/profile/addresses/add') ?>" class="btn btn-primary">
        <i class="fas fa-plus"></i> Add New Address
    </a>
</div>

<?= $this->Flash->render() ?>

<?php if (empty($addresses) || count($addresses) == 0): ?>
<div style="text-align:center; padding:4rem 2rem; background:#fff; border-radius:20px; border:1px solid var(--border-light);">
    <i class="fas fa-map-marker-alt" style="font-size:3.5rem; color:var(--text-muted); opacity:0.25; display:block; margin-bottom:1rem;"></i>
    <h3 style="font-family:'Playfair Display',serif; margin-bottom:0.5rem;">No addresses yet</h3>
    <p style="color:var(--text-muted); margin-bottom:1.5rem;">Add a delivery address to make checkout faster!</p>
    <a href="<?= $this->Url->build('/profile/addresses/add') ?>" class="btn btn-primary"><i class="fas fa-plus"></i> Add Address</a>
</div>

<?php else: ?>
<div style="display:flex; flex-direction:column; gap:1rem;">
    <?php foreach ($addresses as $address): ?>
    <div class="address-card <?= $address->is_default ? 'is-default' : '' ?>">
        <?php if ($address->is_default): ?>
        <span class="address-default-badge"><i class="fas fa-check-circle"></i> Default</span>
        <?php endif; ?>

        <div style="display:flex; align-items:flex-start; gap:1rem; padding-right:5rem;">
            <div style="width:44px; height:44px; border-radius:12px; background:<?= $address->is_default ? 'var(--secondary-gold)' : 'var(--primary-teal)' ?>; display:flex; align-items:center; justify-content:center; flex-shrink:0; margin-top:0.1rem;">
                <i class="fas fa-<?= $address->label === 'Home' ? 'house' : ($address->label === 'Work' ? 'briefcase' : 'map-marker-alt') ?>" style="color:#fff; font-size:0.9rem;"></i>
            </div>
            <div style="flex:1;">
                <div style="display:flex; align-items:center; gap:0.6rem; margin-bottom:0.3rem;">
                    <span style="font-weight:700; font-size:0.9rem;"><?= h($address->label ?? 'Home') ?></span>
                </div>
                <p style="color:var(--text-muted); font-size:0.875rem; line-height:1.6; margin-bottom:0.25rem;">
                    <?= h($address->address_line) ?>
                    <?php if ($address->unit_no): ?>, <?= h($address->unit_no) ?><?php endif; ?>
                </p>
                <p style="color:var(--text-muted); font-size:0.875rem;">
                    <?= h($address->city) ?>, <?= h($address->state) ?> <?= h($address->postal_code) ?>
                </p>
            </div>
        </div>

        <div style="display:flex; align-items:center; gap:0.5rem; margin-top:1rem; padding-top:0.875rem; border-top:1px solid var(--border-light);">
            <?php if (!$address->is_default): ?>
            <form method="post" action="<?= $this->Url->build('/profile/addresses/default/<?= $address->id ?>') ?>" style="margin:0;">
                <?= $this->Form->hidden('_csrfToken', ['id' => false]) ?>
                <button type="submit" class="btn btn-outline btn-sm">
                    <i class="fas fa-check-circle"></i> Set as Default
                </button>
            </form>
            <?php endif; ?>
            <a href="<?= $this->Url->build('/profile/addresses/edit/<?= $address->id ?>') ?>" class="btn btn-outline btn-sm">
                <i class="fas fa-pencil"></i> Edit
            </a>
            <?php if (!$address->is_default): ?>
            <form method="post" action="<?= $this->Url->build('/profile/addresses/delete/<?= $address->id ?>') ?>" style="margin:0;" onsubmit="return confirm('Remove this address?')">
                <?= $this->Form->hidden('_csrfToken', ['id' => false]) ?>
                <button type="submit" class="btn btn-sm" style="background:#FFF1F2; color:#DC2626; border:none;">
                    <i class="fas fa-trash-alt"></i> Delete
                </button>
            </form>
            <?php endif; ?>
        </div>
    </div>
    <?php endforeach; ?>
</div>
<?php endif; ?>

<div style="margin-top:1.5rem; text-align:center;">
    <a href="<?= $this->Url->build('/profile') ?>" style="color:var(--text-muted); font-size:0.875rem;">← Back to Profile</a>
</div>

</div>
</div>
