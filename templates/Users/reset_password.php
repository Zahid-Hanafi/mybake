<?php $this->disableAutoLayout(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Reset Password | MyPMH</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'pmh-purple': '#7c2a7c',
                        'pmh-purple-dark': '#5a1f5a',
                        'pmh-yellow': '#edd134'
                    },
                    fontFamily: { 'sans': ['Inter', 'sans-serif'] }
                }
            }
        }
    </script>
    <style>
        :root { --primary-purple: #7c2a7c; --secondary-yellow: #edd134; }
        @keyframes float { 0%, 100% { transform: translateY(0px); } 50% { transform: translateY(-20px); } }
        @keyframes pulse-glow { 0%, 100% { box-shadow: 0 0 20px rgba(237, 209, 52, 0.3); } 50% { box-shadow: 0 0 40px rgba(237, 209, 52, 0.6); } }
        .float-animation { animation: float 6s ease-in-out infinite; }
        .pulse-glow { animation: pulse-glow 3s ease-in-out infinite; }
    </style>
</head>
<body class="font-sans min-h-screen bg-gradient-to-br from-gray-900 via-pmh-purple-dark to-gray-900">
    
    <!-- Decorative Background -->
    <div class="fixed inset-0 overflow-hidden pointer-events-none">
        <div class="absolute top-20 left-10 w-72 h-72 bg-pmh-purple rounded-full opacity-20 blur-3xl float-animation"></div>
        <div class="absolute bottom-20 right-10 w-96 h-96 bg-pmh-yellow rounded-full opacity-10 blur-3xl float-animation" style="animation-delay: 2s;"></div>
        <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] bg-pmh-purple rounded-full opacity-10 blur-3xl"></div>
    </div>

    <div class="relative min-h-screen flex items-center justify-center p-4 lg:p-8">
        <div class="w-full max-w-md bg-white rounded-3xl shadow-2xl p-8 lg:p-10">
            <!-- Header -->
            <div class="text-center mb-8">
                <div class="w-16 h-16 bg-gradient-to-br from-pmh-purple to-pmh-purple-dark rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-lg">
                    <span class="text-pmh-yellow text-xl font-bold">PMH</span>
                </div>
                <h1 class="text-2xl font-bold text-gray-900">Reset Password</h1>
                <p class="text-gray-500 mt-2">Create a new password for <br> <span class="font-bold text-gray-900"><?= h($user->full_name) ?></span></p>
            </div>

            <!-- Standard Flash Message -->
            <?= $this->Flash->render() ?>

            <!-- Explicit Fallback Error Display -->
            <?php if ($user->hasErrors()): ?>
            <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <i class="fas fa-exclamation-circle text-red-500"></i>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-red-700 font-bold mb-1">Please fix the following errors:</p>
                        <ul class="list-disc list-inside text-sm text-red-600">
                            <?php foreach ($user->getErrors() as $field => $rules): ?>
                                <?php if (is_array($rules)): ?>
                                    <?php foreach ($rules as $rule): ?>
                                        <li><?= h($rule) ?></li>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <li><?= h($rules) ?></li>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            </div>
            <?php endif; ?>
            
            <?= $this->Form->create($user, ['class' => 'space-y-6']) ?>
                
                <!-- New Password -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">New Password</label>
                    <div class="relative">
                        <i class="fas fa-lock absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                         <?= $this->Form->control('password', [
                            'label' => false,
                            'type' => 'password',
                            'id' => 'password',
                            'required' => true,
                            'class' => 'w-full pl-12 pr-12 py-4 border border-gray-200 rounded-xl focus:ring-2 focus:ring-pmh-purple focus:border-pmh-purple transition-all outline-none text-lg', 
                            'placeholder' => 'Enter new password',
                            'value' => '' // Explicitly force empty value
                        ]) ?>
                        <button type="button" onclick="togglePassword('password', 'eye-icon')" class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-pmh-purple transition-colors">
                            <i class="fas fa-eye" id="eye-icon"></i>
                        </button>
                    </div>
                    <p class="text-xs text-gray-500 mt-2 pl-1">
                        <i class="fas fa-info-circle mr-1"></i> Min 8 chars, 1 uppercase, 1 number, 1 symbol.
                    </p>
                </div>

                <!-- Confirm Password -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Confirm Password</label>
                    <div class="relative">
                        <i class="fas fa-lock absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                        <?= $this->Form->control('confirm_password', [
                            'label' => false,
                            'type' => 'password',
                            'id' => 'confirm_password',
                            'required' => true,
                            'class' => 'w-full pl-12 pr-12 py-4 border border-gray-200 rounded-xl focus:ring-2 focus:ring-pmh-purple focus:border-pmh-purple transition-all outline-none text-lg', 
                            'placeholder' => 'Re-enter new password'
                        ]) ?>
                        <button type="button" onclick="togglePassword('confirm_password', 'eye-icon-confirm')" class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-pmh-purple transition-colors">
                            <i class="fas fa-eye" id="eye-icon-confirm"></i>
                        </button>
                    </div>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="w-full py-4 bg-gradient-to-r from-pmh-purple to-pmh-purple-dark text-white font-bold rounded-xl hover:shadow-lg hover:shadow-purple-300 transition-all transform hover:scale-[1.02] text-lg">
                    Reset Password
                </button>
            <?= $this->Form->end() ?>
            <!-- Back Link -->
            <div class="mt-8 text-center">
                <a href="<?= $this->Url->build(['action' => 'login']) ?>" class="group inline-flex items-center text-gray-500 hover:text-pmh-purple transition-colors font-medium">
                    <i class="fas fa-arrow-left mr-2 group-hover:-translate-x-1 transition-transform"></i>
                    Back to Login
                </a>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <div class="relative text-center py-6 text-purple-300 text-sm">
        &copy; 2026 Persatuan Mahasiswa Hadhari. All rights reserved.
    </div>

    <script>
    function togglePassword(inputId, iconId) {
        const input = document.getElementById(inputId);
        const icon = document.getElementById(iconId);
        
        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            input.type = 'password';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    }
    </script>
</body>
</html>
