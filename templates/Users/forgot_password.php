<?php $this->disableAutoLayout(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Forgot Password | MyPMH</title>
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
        .glass { background: rgba(255,255,255,0.1); backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.2); }
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
                <h1 class="text-2xl font-bold text-gray-900">Forgot Password</h1>
                <p class="text-gray-500 mt-2">Enter your matric number and email to verify your identity</p>
            </div>

            <?= $this->Flash->render() ?>
            
            <?= $this->Form->create(null, ['class' => 'space-y-6']) ?>
                
                <!-- Matric No -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Matric Number</label>
                    <div class="relative">
                        <i class="fas fa-id-card absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                        <input type="text" name="matric_no" required 
                            class="w-full pl-12 pr-4 py-4 border border-gray-200 rounded-xl focus:ring-2 focus:ring-pmh-purple focus:border-pmh-purple transition-all outline-none text-lg" 
                            placeholder="Enter your matric number">
                    </div>
                </div>

                <!-- Email -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Email Address</label>
                    <div class="relative">
                        <i class="fas fa-envelope absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                        <input type="email" name="email" required 
                            class="w-full pl-12 pr-4 py-4 border border-gray-200 rounded-xl focus:ring-2 focus:ring-pmh-purple focus:border-pmh-purple transition-all outline-none text-lg" 
                            placeholder="Enter your email">
                    </div>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="w-full py-4 bg-gradient-to-r from-pmh-purple to-pmh-purple-dark text-white font-bold rounded-xl hover:shadow-lg hover:shadow-purple-300 transition-all transform hover:scale-[1.02] text-lg">
                    Verify Identity
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
</body>
</html>
