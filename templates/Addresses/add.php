<?php $this->assign('title', 'Add Address'); ?>
<div style="padding:2rem 0 4rem;">
<div class="container" style="max-width:600px;">
    <div style="margin-bottom:2rem;">
        <a href="/profile/addresses" style="color:var(--text-muted); font-size:0.875rem; display:inline-flex; align-items:center; gap:0.4rem; margin-bottom:0.75rem; transition:color 0.2s;" onmouseover="this.style.color='var(--primary-teal)'" onmouseout="this.style.color='var(--text-muted)'">
            <i class="fas fa-arrow-left"></i> Back to Addresses
        </a>
        <p class="section-label">Delivery Location</p>
        <h1 class="section-title">Add New Address</h1>
    </div>

    <?= $this->Flash->render() ?>

    <div style="background:#fff; border-radius:20px; padding:2rem; border:1px solid var(--border-light); box-shadow:var(--shadow-sm);">
        <?= $this->Form->create($address, ['url' => ['controller' => 'Addresses', 'action' => 'add']]) ?>

        <!-- Label -->
        <div class="form-group">
            <label class="form-label">Address Label</label>
            <div style="display:flex; gap:0.75rem;">
                <?php foreach (['Home', 'Work', 'Other'] as $label): ?>
                <label style="flex:1; display:flex; align-items:center; justify-content:center; gap:0.5rem; padding:0.6rem; border:2px solid var(--border-light); border-radius:10px; cursor:pointer; font-size:0.875rem; font-weight:500; transition:var(--transition);" id="lbl-<?= $label ?>">
                    <input type="radio" name="label" value="<?= $label ?>" style="display:none;" onchange="selectLabel('<?= $label ?>')" <?= $label === 'Home' ? 'checked' : '' ?>>
                    <i class="fas fa-<?= $label === 'Home' ? 'house' : ($label === 'Work' ? 'briefcase' : 'ellipsis') ?>"></i> <?= $label ?>
                </label>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="form-group">
            <label class="form-label">Street Address <span style="color:#DC2626;">*</span></label>
            <?= $this->Form->control('address_line', ['label' => false, 'class' => 'form-control', 'placeholder' => 'e.g. Lot 14191, Parit 7, Kg. Sungai Leman']) ?>
        </div>

        <div class="form-group">
            <label class="form-label">Unit / Apartment No. <span style="color:var(--text-muted); font-weight:400;">(optional)</span></label>
            <?= $this->Form->control('unit_no', ['label' => false, 'class' => 'form-control', 'placeholder' => 'e.g. Unit B-12 (optional)']) ?>
        </div>

        <div style="display:grid; grid-template-columns:1fr 1fr; gap:1rem;">
            <div class="form-group">
                <label class="form-label">City <span style="color:#DC2626;">*</span></label>
                <?= $this->Form->control('city', ['label' => false, 'class' => 'form-control', 'placeholder' => 'Sekinchan']) ?>
            </div>
            <div class="form-group">
                <label class="form-label">State <span style="color:#DC2626;">*</span></label>
                <?= $this->Form->control('state', ['label' => false, 'class' => 'form-control', 'type' => 'select', 'options' => [
                    'Johor'=>'Johor','Kedah'=>'Kedah','Kelantan'=>'Kelantan','Melaka'=>'Melaka',
                    'Negeri Sembilan'=>'Negeri Sembilan','Pahang'=>'Pahang','Perak'=>'Perak',
                    'Perlis'=>'Perlis','Pulau Pinang'=>'Pulau Pinang','Sabah'=>'Sabah',
                    'Sarawak'=>'Sarawak','Selangor'=>'Selangor','Terengganu'=>'Terengganu',
                    'Kuala Lumpur'=>'Kuala Lumpur','Labuan'=>'Labuan','Putrajaya'=>'Putrajaya',
                ], 'default' => 'Selangor']) ?>
            </div>
        </div>

        <div class="form-group">
            <label class="form-label">Postal Code <span style="color:#DC2626;">*</span></label>
            <?= $this->Form->control('postal_code', ['label' => false, 'class' => 'form-control', 'placeholder' => '45400', 'maxlength' => '5']) ?>
        </div>

        <div class="form-group" style="display:flex; align-items:center; gap:0.75rem; padding:0.875rem; background:var(--bg-light); border-radius:10px; margin-bottom:1.5rem;">
            <input type="checkbox" name="is_default" id="isDefault" value="1" style="width:18px; height:18px; accent-color:var(--secondary-gold); cursor:pointer;">
            <label for="isDefault" style="cursor:pointer; font-size:0.875rem; font-weight:500; margin:0;">
                <i class="fas fa-star" style="color:var(--secondary-gold); margin-right:0.3rem;"></i>
                Set as my default delivery address
            </label>
        </div>

        <div style="display:grid; grid-template-columns:1fr 1fr; gap:0.875rem;">
            <a href="/profile/addresses" class="btn btn-outline"><i class="fas fa-times"></i> Cancel</a>
            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Save Address</button>
        </div>
        <?= $this->Form->end() ?>
    </div>
</div>
</div>

<script>
function selectLabel(label) {
    ['Home','Work','Other'].forEach(l => {
        const el = document.getElementById('lbl-' + l);
        if (el) {
            el.style.borderColor = l === label ? 'var(--primary-teal)' : 'var(--border-light)';
            el.style.background  = l === label ? 'var(--primary-teal-xlight)' : '';
            el.style.color       = l === label ? 'var(--primary-teal)' : '';
        }
    });
}
selectLabel('Home');
</script>
