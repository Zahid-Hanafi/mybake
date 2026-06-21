<?php $this->assign('title', 'Create Account'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Create your MyBake account and start ordering authentic homemade snacks.">
    <title>MyBake — Create Account</title>
    <?= $this->Html->meta('icon') ?>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700;800&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
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
            <p style="color:rgba(255,255,255,0.7); margin-bottom:2rem;">Join thousands of happy customers!</p>

            <div style="background:rgba(255,255,255,0.08); border:1px solid rgba(255,255,255,0.12); border-radius:16px; padding:1.5rem; text-align:left; margin-bottom:1.5rem;">
                <p style="color:var(--secondary-gold-light); font-weight:600; margin-bottom:0.75rem; font-size:0.875rem;">
                    <i class="fas fa-shield-halved" style="margin-right:0.4rem;"></i> Password Requirements
                </p>
                <ul style="list-style:none; color:rgba(255,255,255,0.7); font-size:0.8rem; line-height:2;">
                    <li><i class="fas fa-check" style="color:var(--secondary-gold-light); width:16px;"></i> Minimum 8 characters</li>
                    <li><i class="fas fa-check" style="color:var(--secondary-gold-light); width:16px;"></i> At least 1 uppercase letter (A-Z)</li>
                    <li><i class="fas fa-check" style="color:var(--secondary-gold-light); width:16px;"></i> At least 1 number (0-9)</li>
                    <li><i class="fas fa-check" style="color:var(--secondary-gold-light); width:16px;"></i> At least 1 symbol (!@#$%...)</li>
                </ul>
                <p style="color:rgba(255,255,255,0.5); font-size:0.75rem; margin-top:0.5rem;">Example: <code style="color:var(--secondary-gold-light); background:rgba(0,0,0,0.2); padding:0.1rem 0.4rem; border-radius:4px;">Password@123</code></p>
            </div>

            <div style="background:rgba(255,255,255,0.08); border:1px solid rgba(255,255,255,0.12); border-radius:16px; padding:1.25rem; text-align:left;">
                <p style="color:rgba(255,255,255,0.8); font-size:0.8rem; line-height:1.7;">
                    <i class="fas fa-info-circle" style="color:var(--secondary-gold-light); margin-right:0.4rem;"></i>
                    After registering, login with your <strong style="color:#fff;">email</strong> and password. Your role will be <strong style="color:#fff;">Customer</strong> by default.
                </p>
            </div>
        </div>
    </div>

    <!-- Form Side -->
    <div class="auth-form-side" style="overflow-y:auto;">
        <div class="auth-form-box" style="padding: 2rem 0;">
            <div style="margin-bottom:1.75rem;">
                <h2 style="font-family:'Playfair Display',serif; font-size:1.875rem; font-weight:700; color:var(--text-dark);">Create Account</h2>
                <p style="color:var(--text-muted); margin-top:0.4rem; font-size:0.875rem;">Fill in your details to get started.</p>
            </div>

            <?= $this->Flash->render() ?>

            <?= $this->Form->create($user, [
                'url' => ['controller' => 'Users', 'action' => 'register'],
                'id'  => 'registerForm',
            ]) ?>

            <!-- Name Row -->
            <div style="display:grid; grid-template-columns:1fr 1fr; gap:0.875rem;">
                <div class="form-group">
                    <label class="form-label" for="first_name">First Name <span style="color:#DC2626;">*</span></label>
                    <div style="position:relative;">
                        <i class="fas fa-user" style="position:absolute; left:0.875rem; top:50%; transform:translateY(-50%); color:var(--text-muted); font-size:0.8rem;"></i>
                        <?= $this->Form->control('first_name', [
                            'label'       => false,
                            'placeholder' => 'Ahmad',
                            'id'          => 'first_name',
                            'class'       => 'form-control' . (!empty($user->getError('first_name')) ? ' error' : ''),
                            'style'       => 'padding-left:2.5rem;',
                            'required'    => true,
                        ]) ?>
                    </div>
                    <?php if ($user->getError('first_name')): ?>
                    <p class="form-error"><?= h(implode(', ', (array)$user->getError('first_name'))) ?></p>
                    <?php endif; ?>
                </div>
                <div class="form-group">
                    <label class="form-label" for="last_name">Last Name <span style="color:#DC2626;">*</span></label>
                    <div style="position:relative;">
                        <i class="fas fa-user" style="position:absolute; left:0.875rem; top:50%; transform:translateY(-50%); color:var(--text-muted); font-size:0.8rem;"></i>
                        <?= $this->Form->control('last_name', [
                            'label'       => false,
                            'placeholder' => 'Zahid',
                            'id'          => 'last_name',
                            'class'       => 'form-control' . (!empty($user->getError('last_name')) ? ' error' : ''),
                            'style'       => 'padding-left:2.5rem;',
                            'required'    => true,
                        ]) ?>
                    </div>
                    <?php if ($user->getError('last_name')): ?>
                    <p class="form-error"><?= h(implode(', ', (array)$user->getError('last_name'))) ?></p>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Email -->
            <div class="form-group">
                <label class="form-label" for="email">Email Address <span style="color:#DC2626;">*</span></label>
                <div style="position:relative;">
                    <i class="fas fa-envelope" style="position:absolute; left:0.875rem; top:50%; transform:translateY(-50%); color:var(--text-muted); font-size:0.8rem;"></i>
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
                <?php if ($user->getError('email')): ?>
                <p class="form-error"><?= h(implode(', ', (array)$user->getError('email'))) ?></p>
                <?php endif; ?>
            </div>

            <!-- Phone -->
            <div class="form-group">
                <label class="form-label" for="phone_no">Phone Number <span style="color:#DC2626;">*</span></label>
                <div style="position:relative;">
                    <i class="fas fa-phone" style="position:absolute; left:0.875rem; top:50%; transform:translateY(-50%); color:var(--text-muted); font-size:0.8rem;"></i>
                    <?= $this->Form->control('phone_no', [
                        'label'       => false,
                        'placeholder' => '011-2345 6789',
                        'id'          => 'phone_no',
                        'class'       => 'form-control',
                        'style'       => 'padding-left:2.5rem;',
                        'required'    => true,
                    ]) ?>
                </div>
            </div>

            <!-- Password -->
            <div class="form-group">
                <label class="form-label" for="reg_password">Password <span style="color:#DC2626;">*</span></label>
                <div style="position:relative;">
                    <i class="fas fa-lock" style="position:absolute; left:0.875rem; top:50%; transform:translateY(-50%); color:var(--text-muted); font-size:0.8rem;"></i>
                    <?= $this->Form->control('password', [
                        'type'        => 'password',
                        'label'       => false,
                        'placeholder' => '••••••••',
                        'id'          => 'reg_password',
                        'class'       => 'form-control',
                        'style'       => 'padding-left:2.5rem; padding-right:2.75rem;',
                        'required'    => true,
                    ]) ?>
                    <button type="button" onclick="togglePw('reg_password', this)" style="position:absolute; right:0.875rem; top:50%; transform:translateY(-50%); background:none; border:none; cursor:pointer; color:var(--text-muted);">
                        <i class="fas fa-eye"></i>
                    </button>
                </div>
                <!-- Live password strength -->
                <div style="margin-top:0.5rem;">
                    <ul class="pw-rules">
                        <li class="pw-rule" id="rule-len"><i></i> Minimum 8 characters</li>
                        <li class="pw-rule" id="rule-upper"><i></i> At least 1 uppercase letter</li>
                        <li class="pw-rule" id="rule-num"><i></i> At least 1 number</li>
                        <li class="pw-rule" id="rule-sym"><i></i> At least 1 symbol</li>
                    </ul>
                </div>
                <?php if ($user->getError('password')): ?>
                <p class="form-error"><?= h(implode(' | ', (array)$user->getError('password'))) ?></p>
                <?php endif; ?>
            </div>

            <!-- Confirm Password -->
            <div class="form-group">
                <label class="form-label" for="confirm_password">Confirm Password <span style="color:#DC2626;">*</span></label>
                <div style="position:relative;">
                    <i class="fas fa-lock" style="position:absolute; left:0.875rem; top:50%; transform:translateY(-50%); color:var(--text-muted); font-size:0.8rem;"></i>
                    <input type="password" name="confirm_password" id="confirm_password" required
                        placeholder="••••••••" class="form-control"
                        style="padding-left:2.5rem; padding-right:2.75rem;">
                    <button type="button" onclick="togglePw('confirm_password', this)" style="position:absolute; right:0.875rem; top:50%; transform:translateY(-50%); background:none; border:none; cursor:pointer; color:var(--text-muted);">
                        <i class="fas fa-eye"></i>
                    </button>
                </div>
                <p class="form-error" id="pwMatchError" style="display:none;">Passwords do not match.</p>
            </div>

            <!-- Submit -->
            <button type="submit" class="btn btn-primary btn-full btn-lg" id="registerBtn" style="margin-bottom:1.25rem;">
                <i class="fas fa-user-plus"></i> Create Account
            </button>

            <?= $this->Form->end() ?>

            <div style="text-align:center; padding-top:1rem; border-top:1px solid var(--border-light);">
                <p style="color:var(--text-muted); font-size:0.875rem;">
                    Already have an account?
                    <a href="/login" style="color:var(--primary-teal); font-weight:600; margin-left:0.25rem;">Sign In</a>
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

// Live password rule checker
const pwInput = document.getElementById('reg_password');
if (pwInput) {
    pwInput.addEventListener('input', function() {
        const v = this.value;
        check('rule-len',   v.length >= 8);
        check('rule-upper', /[A-Z]/.test(v));
        check('rule-num',   /[0-9]/.test(v));
        check('rule-sym',   /[!@#$%^&*()_+\-=\[\]{}|;:,.<>?]/.test(v));
    });
}
function check(id, met) {
    document.getElementById(id).classList.toggle('met', met);
}

// Confirm password match
const confirmPw = document.getElementById('confirm_password');
const pwError   = document.getElementById('pwMatchError');
if (confirmPw) {
    confirmPw.addEventListener('input', function() {
        const match = this.value === document.getElementById('reg_password').value;
        pwError.style.display = (!match && this.value) ? 'block' : 'none';
    });
}

// Prevent submit if passwords don't match
document.getElementById('registerForm').addEventListener('submit', function(e) {
    const pw  = document.getElementById('reg_password').value;
    const cpw = document.getElementById('confirm_password').value;
    if (pw !== cpw) {
        e.preventDefault();
        pwError.style.display = 'block';
        confirmPw.focus();
    }
});
</script>
</body>
</html>