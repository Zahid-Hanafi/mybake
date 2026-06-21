<?php $this->assign('title', 'Login'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Login to MyBake — Authentic homemade Bahulu, Rempeyek, and Kerepek Ubi from Sekinchan, Selangor.">
    <title>MyBake — Login</title>
    <?= $this->Html->meta('icon') ?>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700;800&family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="<?= $this->request->getWebroot() ?>css/mybake.css">
</head>
<body>

<div class="auth-wrapper">
    <!-- Visual Side -->
    <div class="auth-visual">
        <div style="text-align:center; position:relative; z-index:1;">
            <div class="brand-icon" style="width:80px; height:80px; margin:0 auto 1.5rem; background:rgba(255,255,255,0.15); border:2px solid rgba(255,255,255,0.3);">
                <span style="font-size:1.4rem; color:var(--secondary-gold);">MB</span>
            </div>
            <h1 style="font-family:'Playfair Display',serif; font-size:2.5rem; font-weight:800; color:#fff; margin-bottom:0.5rem;">MyBake</h1>
            <p style="color:rgba(255,255,255,0.7); font-size:1rem; margin-bottom:2.5rem;">Authentic Homemade Taste Since 1990</p>

            <div style="display:flex; flex-direction:column; gap:1rem;">
                <?php
                $features = [
                    ['fas fa-cookie-bite','Bahulu, Rempeyek & Kerepek Ubi'],
                    ['fas fa-leaf','Fresh homemade daily'],
                    ['fas fa-truck','Delivery across Malaysia'],
                    ['fas fa-award','Award-winning quality'],
                ];
                foreach ($features as $f): ?>
                <div style="display:flex; align-items:center; gap:0.875rem; background:rgba(255,255,255,0.08); border:1px solid rgba(255,255,255,0.12); border-radius:12px; padding:0.875rem 1.25rem; text-align:left;">
                    <i class="<?= $f[0] ?>" style="color:var(--secondary-gold-light); font-size:1rem; width:20px;"></i>
                    <span style="color:rgba(255,255,255,0.9); font-size:0.875rem;"><?= $f[1] ?></span>
                </div>
                <?php endforeach; ?>
            </div>

            <div style="margin-top:2.5rem; padding-top:2rem; border-top:1px solid rgba(255,255,255,0.12);">
                <p style="color:rgba(255,255,255,0.5); font-size:0.75rem;">Lot14191, Parit 7, Kg. Sungai Leman, 45400 Sekinchan, Selangor</p>
            </div>
        </div>
    </div>

    <!-- Form Side -->
    <div class="auth-form-side">
        <div class="auth-form-box">
            <div style="margin-bottom:2rem;">
                <h2 style="font-family:'Playfair Display',serif; font-size:2rem; font-weight:700; color:var(--text-dark);">Welcome back!</h2>
                <p style="color:var(--text-muted); margin-top:0.5rem;">Sign in to your MyBake account.</p>
            </div>

            <!-- Flash Messages -->
            <?= $this->Flash->render() ?>

            <?= $this->Form->create(null, [
                'url' => ['controller' => 'Users', 'action' => 'login'],
                'id'  => 'loginForm',
            ]) ?>

            <!-- Role Selection -->
            <div class="form-group">
                <label class="form-label">Login as</label>
                <div style="display:flex; gap:0.75rem;">
                    <input type="radio" name="role" value="customer" id="roleCustomer" class="role-radio" checked>
                    <label for="roleCustomer" class="role-label">
                        <i class="fas fa-user" style="font-size:1.25rem; color:var(--primary-teal);"></i>
                        <span style="font-weight:600; font-size:0.875rem;">Customer</span>
                    </label>

                    <input type="radio" name="role" value="admin" id="roleAdmin" class="role-radio">
                    <label for="roleAdmin" class="role-label">
                        <i class="fas fa-user-shield" style="font-size:1.25rem; color:var(--secondary-gold-dark);"></i>
                        <span style="font-weight:600; font-size:0.875rem;">Admin</span>
                    </label>
                </div>
            </div>

            <!-- Email -->
            <div class="form-group">
                <label class="form-label" for="email">Email Address</label>
                <div style="position:relative;">
                    <i class="fas fa-envelope" style="position:absolute; left:0.875rem; top:50%; transform:translateY(-50%); color:var(--text-muted); font-size:0.875rem;"></i>
                    <?= $this->Form->control('email', [
                        'type'        => 'email',
                        'label'       => false,
                        'placeholder' => 'example@email.com',
                        'id'          => 'email',
                        'class'       => 'form-control',
                        'style'       => 'padding-left:2.5rem;',
                        'required'    => true,
                    ]) ?>
                </div>
            </div>

            <!-- Password -->
            <div class="form-group">
                <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:0.4rem;">
                    <label class="form-label" style="margin:0;" for="password">Password</label>
                </div>
                <div style="position:relative;">
                    <i class="fas fa-lock" style="position:absolute; left:0.875rem; top:50%; transform:translateY(-50%); color:var(--text-muted); font-size:0.875rem;"></i>
                    <?= $this->Form->control('password', [
                        'type'        => 'password',
                        'label'       => false,
                        'placeholder' => '••••••••',
                        'id'          => 'password',
                        'class'       => 'form-control',
                        'style'       => 'padding-left:2.5rem; padding-right:2.75rem;',
                        'required'    => true,
                    ]) ?>
                    <button type="button" onclick="togglePw('password', this)" style="position:absolute; right:0.875rem; top:50%; transform:translateY(-50%); background:none; border:none; cursor:pointer; color:var(--text-muted); padding:0;">
                        <i class="fas fa-eye"></i>
                    </button>
                </div>
            </div>

            <!-- Submit -->
            <button type="submit" class="btn btn-primary btn-full btn-lg" style="margin-bottom:1rem;" id="loginBtn">
                <i class="fas fa-right-to-bracket"></i>
                <span>Sign In</span>
            </button>

            <!-- Guest -->
            <a href="/dashboard" class="btn btn-outline btn-full" style="margin-bottom:1.5rem;">
                <i class="fas fa-eye"></i> Continue as Guest
            </a>

            <?= $this->Form->end() ?>

            <div style="text-align:center; padding-top:1rem; border-top:1px solid var(--border-light);">
                <p style="color:var(--text-muted); font-size:0.875rem;">
                    Don't have an account?
                    <a href="/register" style="color:var(--primary-teal); font-weight:600; margin-left:0.25rem;">Create an Account</a>
                </p>
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
</script>
</body>
</html>