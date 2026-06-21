<?php
/**
 * Add New Application Form
 */
?>

<div class="mb-8">
    <div class="flex items-center gap-3 mb-2">
        <a href="<?= $this->Url->build(['action' => 'joinus']) ?>" class="text-gray-400 hover:text-pmh-purple transition-colors">
            <i class="fas fa-arrow-left"></i>
        </a>
        <h1 class="text-2xl lg:text-3xl font-bold text-gray-900">New Application</h1>
    </div>
    <p class="text-gray-500 ml-8">Fill in the form to apply for PMH membership</p>
</div>

<div class="max-w-4xl">
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 lg:p-8">
        <?= $this->Flash->render() ?>
        
        <?= $this->Form->create($application, ['class' => 'space-y-6', 'id' => 'applicationForm']) ?>
        
        <!-- Auto-filled User Info (Read-only) -->
        <div class="bg-gray-50 rounded-xl p-6 border border-gray-200">
            <h3 class="text-sm font-semibold text-gray-500 uppercase mb-4">
                <i class="fas fa-user text-pmh-purple mr-2"></i>Your Information (Auto-captured from Profile)
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-gray-500 mb-1">Full Name</label>
                    <input type="text" value="<?= h($user->full_name) ?>" disabled class="w-full px-4 py-3 border border-gray-200 rounded-xl bg-white text-gray-700">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-500 mb-1">Matric Number</label>
                    <input type="text" value="<?= h($user->matric_no) ?>" disabled class="w-full px-4 py-3 border border-gray-200 rounded-xl bg-white text-gray-700">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-500 mb-1">Email</label>
                    <input type="text" value="<?= h($user->email) ?>" disabled class="w-full px-4 py-3 border border-gray-200 rounded-xl bg-white text-gray-700">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-500 mb-1">Phone Number</label>
                    <input type="text" value="<?= h($user->phone_no) ?>" disabled class="w-full px-4 py-3 border border-gray-200 rounded-xl bg-white text-gray-700">
                </div>
            </div>
            <p class="text-xs text-gray-400 mt-3">
                <i class="fas fa-info-circle mr-1"></i>
                To update your information, please go to <a href="<?= $this->Url->build(['controller' => 'Users', 'action' => 'profile']) ?>" class="text-pmh-purple hover:underline">My Profile</a>
            </p>
        </div>

        <!-- Application Fields -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    <i class="fas fa-chart-line text-pmh-purple mr-2"></i>Current CGPA <span class="text-red-500">*</span>
                </label>
                <?= $this->Form->control('cgpa', [
                    'label' => false,
                    'type' => 'number',
                    'step' => '0.01',
                    'min' => '0',
                    'max' => '4',
                    'required' => true,
                    'placeholder' => 'e.g. 3.50',
                    'class' => 'w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-pmh-purple focus:border-pmh-purple transition-all outline-none'
                ]) ?>
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    <i class="fas fa-graduation-cap text-pmh-purple mr-2"></i>Current Semester <span class="text-red-500">*</span>
                </label>
                <?= $this->Form->control('semester', [
                    'label' => false,
                    'type' => 'select',
                    'options' => [1 => 'Semester 1', 2 => 'Semester 2', 3 => 'Semester 3', 4 => 'Semester 4'],
                    'empty' => 'Select Semester',
                    'required' => true,
                    'class' => 'w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-pmh-purple focus:border-pmh-purple transition-all outline-none bg-white'
                ]) ?>
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    <i class="fas fa-venus-mars text-pmh-purple mr-2"></i>Gender <span class="text-red-500">*</span>
                </label>
                <?= $this->Form->control('gender', [
                    'label' => false,
                    'type' => 'select',
                    'options' => ['Male' => 'Male', 'Female' => 'Female'],
                    'empty' => 'Select Gender',
                    'required' => true,
                    'class' => 'w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-pmh-purple focus:border-pmh-purple transition-all outline-none bg-white'
                ]) ?>
            </div>
        </div>

        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2">
                <i class="fas fa-home text-pmh-purple mr-2"></i>Home Address <span class="text-red-500">*</span>
            </label>
            <?= $this->Form->control('home_address', [
                'label' => false,
                'type' => 'textarea',
                'rows' => 3,
                'required' => true,
                'placeholder' => 'Enter your full home address',
                'class' => 'w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-pmh-purple focus:border-pmh-purple transition-all outline-none resize-none'
            ]) ?>
        </div>

        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2">
                <i class="fas fa-trophy text-pmh-yellow mr-2"></i>Achievements <span class="text-red-500">*</span>
            </label>
            <?= $this->Form->control('achievement', [
                'label' => false,
                'type' => 'textarea',
                'rows' => 3,
                'required' => true,
                'placeholder' => 'List your achievements (e.g., Dean\'s List, competitions won, certifications)',
                'class' => 'w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-pmh-purple focus:border-pmh-purple transition-all outline-none resize-none'
            ]) ?>
        </div>

        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2">
                <i class="fas fa-briefcase text-pmh-purple mr-2"></i>Relative Experience (Optional)
            </label>
            <?= $this->Form->control('relative_experience', [
                'label' => false,
                'type' => 'textarea',
                'rows' => 3,
                'placeholder' => 'Previous involvement in clubs, organizations, or leadership roles',
                'class' => 'w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-pmh-purple focus:border-pmh-purple transition-all outline-none resize-none'
            ]) ?>
        </div>

        <!-- Interview Slot Selection -->
        <div class="bg-purple-50 rounded-xl p-6 border border-purple-100">
            <label class="block text-sm font-semibold text-gray-700 mb-2">
                <i class="fas fa-calendar-check text-pmh-purple mr-2"></i>Select Interview Session <span class="text-red-500">*</span>
            </label>
            <p class="text-sm text-gray-500 mb-4">Choose an available date and time slot for your interview (Monday - Wednesday only)</p>
            <?= $this->Form->control('interview_slot_id', [
                'label' => false,
                'type' => 'select',
                'options' => $slotOptions,
                'empty' => 'Select Interview Slot',
                'required' => true,
                'class' => 'w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-pmh-purple focus:border-pmh-purple transition-all outline-none bg-white'
            ]) ?>
        </div>

        <!-- Submit -->
        <div class="flex flex-col sm:flex-row gap-4 pt-4">
            <button type="button" onclick="showConfirmation()" class="flex-1 bg-gradient-to-r from-pmh-purple to-pmh-purple-dark text-white font-semibold py-4 rounded-xl hover:shadow-lg hover:shadow-purple-200 transition-all flex items-center justify-center gap-2">
                <i class="fas fa-paper-plane"></i> Submit Application
            </button>
            <a href="<?= $this->Url->build(['action' => 'joinus']) ?>" class="flex-1 bg-gray-100 text-gray-700 font-semibold py-4 rounded-xl hover:bg-gray-200 transition-all text-center">
                Cancel
            </a>
        </div>
        
        <?= $this->Form->end() ?>
    </div>
</div>

<!-- Confirmation Modal -->
<div id="confirmModal" class="fixed inset-0 bg-black/50 z-50 hidden items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-lg w-full p-8 shadow-2xl">
        <div class="text-center mb-6">
            <div class="w-16 h-16 bg-yellow-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-exclamation-triangle text-yellow-600 text-2xl"></i>
            </div>
            <h3 class="text-xl font-bold text-gray-900 mb-2">Confirm Submission</h3>
        </div>
        <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-4 mb-6">
            <p class="text-sm text-yellow-800 leading-relaxed">
                <strong>Declaration:</strong> All the information I have provided in this application is <strong>100% true and accurate</strong>. 
                I understand that if PMH discovers any manipulation or false information, my application will be <strong>immediately rejected</strong>.
            </p>
        </div>
        <div class="flex gap-4">
            <button onclick="submitForm()" class="flex-1 bg-pmh-purple text-white font-semibold py-3 rounded-xl hover:bg-pmh-purple-dark transition-all">
                <i class="fas fa-check mr-2"></i>I Confirm
            </button>
            <button onclick="hideConfirmation()" class="flex-1 bg-gray-100 text-gray-700 font-semibold py-3 rounded-xl hover:bg-gray-200 transition-all">
                Cancel
            </button>
        </div>
    </div>
</div>

<script>
function showConfirmation() {
    const form = document.getElementById('applicationForm');
    if (form.checkValidity()) {
        document.getElementById('confirmModal').classList.remove('hidden');
        document.getElementById('confirmModal').classList.add('flex');
    } else {
        form.reportValidity();
    }
}

function hideConfirmation() {
    document.getElementById('confirmModal').classList.add('hidden');
    document.getElementById('confirmModal').classList.remove('flex');
}

function submitForm() {
    document.getElementById('applicationForm').submit();
}
</script>
