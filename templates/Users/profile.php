<?php $this->assign('title', 'My Profile'); ?>

<div style="padding:2rem 0 4rem;">
<div class="container" style="max-width:900px;">

<div class="section-header" style="margin-bottom:2rem;">
    <p class="section-label">Account Settings</p>
    <h1 class="section-title">My Profile</h1>
</div>

<?= $this->Flash->render() ?>

<div style="display:grid; grid-template-columns:280px 1fr; gap:2rem; align-items:start;">

    <!-- Sidebar Card -->
    <div style="background:#fff; border-radius:20px; padding:2rem; border:1px solid var(--border-light); box-shadow:var(--shadow-sm); text-align:center; position:sticky; top:90px;">
        <div class="profile-avatar" style="margin:0 auto 1rem;"><?= strtoupper(substr($user->first_name, 0, 1)) ?></div>
        <div style="font-family:'Playfair Display',serif; font-size:1.25rem; font-weight:700; margin-bottom:0.25rem;">
            <?= h($user->first_name . ' ' . $user->last_name) ?>
        </div>
        <div style="color:var(--text-muted); font-size:0.85rem; margin-bottom:1.25rem;"><?= h($user->email) ?></div>
        <span class="status-badge" style="background:var(--primary-teal-xlight); color:var(--primary-teal);">
            <i class="fas fa-circle" style="font-size:0.45rem;"></i> <?= ucfirst($user->role) ?>
        </span>

        <div style="border-top:1px solid var(--border-light); margin-top:1.5rem; padding-top:1.25rem; display:flex; flex-direction:column; gap:0.5rem;">
            <a href="<?= $this->Url->build('/profile') ?>" class="nav-item active"><i class="fas fa-user-circle"></i> My Profile</a>
            <a href="<?= $this->Url->build('/profile/addresses') ?>" class="nav-item"><i class="fas fa-map-marker-alt"></i> My Addresses</a>
            <a href="<?= $this->Url->build('/my-orders') ?>" class="nav-item"><i class="fas fa-bag-shopping"></i> My Orders</a>
            <a href="<?= $this->Url->build('/logout') ?>" class="logout-btn" onclick="confirmLogout(event, '/logout')"><i class="fas fa-right-from-bracket"></i> Logout</a>
        </div>
    </div>

    <!-- Edit Form -->
    <div>
        <!-- Personal Info -->
        <div style="background:#fff; border-radius:20px; padding:2rem; border:1px solid var(--border-light); box-shadow:var(--shadow-sm); margin-bottom:1.5rem;">
            <h2 style="font-size:1.1rem; font-weight:700; margin-bottom:1.5rem; display:flex; align-items:center; gap:0.6rem;">
                <i class="fas fa-user" style="color:var(--primary-teal);"></i> Personal Information
            </h2>

            <?= $this->Form->create($user, ['url' => ['controller' => 'Users', 'action' => 'profile'], 'id' => 'profileForm']) ?>

            <div style="display:grid; grid-template-columns:1fr 1fr; gap:1rem; margin-bottom:1rem;">
                <div class="form-group" style="margin-bottom:0;">
                    <label class="form-label">First Name</label>
                    <?= $this->Form->control('first_name', ['label' => false, 'class' => 'form-control', 'value' => h($user->first_name)]) ?>
                    <?php if ($user->getError('first_name')): ?><p class="form-error"><?= h(implode(', ', (array)$user->getError('first_name'))) ?></p><?php endif; ?>
                </div>
                <div class="form-group" style="margin-bottom:0;">
                    <label class="form-label">Last Name</label>
                    <?= $this->Form->control('last_name', ['label' => false, 'class' => 'form-control', 'value' => h($user->last_name)]) ?>
                    <?php if ($user->getError('last_name')): ?><p class="form-error"><?= h(implode(', ', (array)$user->getError('last_name'))) ?></p><?php endif; ?>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Email Address</label>
                <div style="position:relative;">
                    <i class="fas fa-envelope" style="position:absolute; left:0.875rem; top:50%; transform:translateY(-50%); color:var(--text-muted); font-size:0.8rem;"></i>
                    <input type="email" value="<?= h($user->email) ?>" disabled class="form-control" style="padding-left:2.5rem; background:var(--bg-light); cursor:not-allowed;">
                </div>
                <p class="form-hint"><i class="fas fa-lock" style="font-size:0.7rem;"></i> Email cannot be changed after registration.</p>
            </div>

            <div class="form-group">
                <label class="form-label">Phone Number</label>
                <div style="position:relative;">
                    <i class="fas fa-phone" style="position:absolute; left:0.875rem; top:50%; transform:translateY(-50%); color:var(--text-muted); font-size:0.8rem;"></i>
                    <?= $this->Form->control('phone_no', ['label' => false, 'class' => 'form-control', 'style' => 'padding-left:2.5rem;', 'value' => h($user->phone_no)]) ?>
                </div>
            </div>

            <button type="submit" name="submit_section" value="profile" class="btn btn-primary">
                <i class="fas fa-save"></i> Save Changes
            </button>
            <?= $this->Form->end() ?>
        </div>

        <!-- Change Password -->
        <div style="background:#fff; border-radius:20px; padding:2rem; border:1px solid var(--border-light); box-shadow:var(--shadow-sm);">
            <h2 style="font-size:1.1rem; font-weight:700; margin-bottom:1.5rem; display:flex; align-items:center; gap:0.6rem;">
                <i class="fas fa-lock" style="color:var(--secondary-gold-dark);"></i> Change Password
            </h2>
            <p style="color:var(--text-muted); font-size:0.875rem; margin-bottom:1.5rem;">Leave blank if you don't want to change your password. Must meet security requirements.</p>

            <?= $this->Form->create($user, ['url' => ['controller' => 'Users', 'action' => 'profile'], 'id' => 'passwordForm']) ?>

            <div class="form-group">
                <label class="form-label">New Password</label>
                <div style="position:relative;">
                    <i class="fas fa-lock" style="position:absolute; left:0.875rem; top:50%; transform:translateY(-50%); color:var(--text-muted); font-size:0.8rem;"></i>
                    <input type="password" name="password" id="newPw" placeholder="Leave blank to keep current" class="form-control" style="padding-left:2.5rem; padding-right:2.75rem;" autocomplete="new-password">
                    <button type="button" onclick="togglePw('newPw', this)" style="position:absolute; right:0.875rem; top:50%; transform:translateY(-50%); background:none; border:none; cursor:pointer; color:var(--text-muted);"><i class="fas fa-eye"></i></button>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Confirm New Password</label>
                <div style="position:relative;">
                    <i class="fas fa-lock" style="position:absolute; left:0.875rem; top:50%; transform:translateY(-50%); color:var(--text-muted); font-size:0.8rem;"></i>
                    <input type="password" name="confirm_password" id="confirmPw" placeholder="Repeat new password" class="form-control" style="padding-left:2.5rem; padding-right:2.75rem;" autocomplete="new-password">
                    <button type="button" onclick="togglePw('confirmPw', this)" style="position:absolute; right:0.875rem; top:50%; transform:translateY(-50%); background:none; border:none; cursor:pointer; color:var(--text-muted);"><i class="fas fa-eye"></i></button>
                </div>
                <p class="form-error" id="pwMatchErr" style="display:none;">Passwords do not match.</p>
            </div>

            <ul class="pw-rules" style="margin-bottom:1.25rem;">
                <li class="pw-rule" id="r-len"><i></i> Minimum 8 characters</li>
                <li class="pw-rule" id="r-upper"><i></i> At least 1 uppercase letter</li>
                <li class="pw-rule" id="r-num"><i></i> At least 1 number</li>
                <li class="pw-rule" id="r-sym"><i></i> At least 1 symbol</li>
            </ul>

            <button type="submit" class="btn btn-gold">
                <i class="fas fa-key"></i> Update Password
            </button>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
</div>
</div>

<script>
function togglePw(id, btn) {
    const inp = document.getElementById(id);
    const isText = inp.type === 'text';
    inp.type = isText ? 'password' : 'text';
    btn.querySelector('i').className = isText ? 'fas fa-eye' : 'fas fa-eye-slash';
}
document.getElementById('newPw').addEventListener('input', function() {
    const v = this.value;
    ['r-len','r-upper','r-num','r-sym'].forEach(id => document.getElementById(id).classList.remove('met'));
    if (v.length >= 8) document.getElementById('r-len').classList.add('met');
    if (/[A-Z]/.test(v)) document.getElementById('r-upper').classList.add('met');
    if (/[0-9]/.test(v)) document.getElementById('r-num').classList.add('met');
    if (/[!@#$%^&*()_+\-=\[\]{}|;:,.<>?]/.test(v)) document.getElementById('r-sym').classList.add('met');
});
document.getElementById('passwordForm').addEventListener('submit', function(e) {
    const pw = document.getElementById('newPw').value;
    const cpw = document.getElementById('confirmPw').value;
    if (pw && pw !== cpw) {
        e.preventDefault();
        document.getElementById('pwMatchErr').style.display = 'block';
    }
});
</script>

<style>
@media(max-width:768px){ [style*="grid-template-columns:280px 1fr"]{grid-template-columns:1fr!important;} [style*="grid-template-columns:1fr 1fr"]{grid-template-columns:1fr!important;} }
</style>
