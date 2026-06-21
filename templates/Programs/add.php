<?php
/**
 * Add New Program (Admin Only)
 */
?>

<!-- Page Header -->
<div class="mb-8">
    <div class="flex items-center gap-3 mb-2">
        <a href="<?= $this->Url->build(['action' => 'allprogram']) ?>" class="text-gray-400 hover:text-pmh-purple transition-colors">
            <i class="fas fa-arrow-left"></i>
        </a>
        <h1 class="text-2xl lg:text-3xl font-bold text-gray-900">Create New Program</h1>
    </div>
    <p class="text-gray-500 ml-8">Add a new program or event to the PMH calendar</p>
</div>

<div class="max-w-3xl">
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 lg:p-8">
        <?= $this->Flash->render() ?>
        
        <?= $this->Form->create($program, ['class' => 'space-y-6']) ?>
            <!-- Program Name -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    <i class="fas fa-calendar-alt text-pmh-purple mr-2"></i>Program Name <span class="text-red-500">*</span>
                </label>
                <?= $this->Form->control('name', [
                    'label' => false,
                    'required' => true,
                    'placeholder' => 'e.g., Majlis Tilawah Al-Quran PMH 2025',
                    'class' => 'w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-pmh-purple focus:border-pmh-purple transition-all outline-none'
                ]) ?>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Date -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-clock text-pmh-purple mr-2"></i>Date <span class="text-red-500">*</span>
                    </label>
                    <?= $this->Form->control('date', [
                        'label' => false,
                        'type' => 'date',
                        'required' => true,
                        'class' => 'w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-pmh-purple focus:border-pmh-purple transition-all outline-none'
                    ]) ?>
                </div>

                <!-- Venue -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-map-marker-alt text-pmh-yellow mr-2"></i>Venue <span class="text-red-500">*</span>
                    </label>
                    <?= $this->Form->control('venue', [
                        'label' => false,
                        'required' => true,
                        'placeholder' => 'e.g., Dewan Kolej Jasmine',
                        'class' => 'w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-pmh-purple focus:border-pmh-purple transition-all outline-none'
                    ]) ?>
                </div>
            </div>

            <!-- Description -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    <i class="fas fa-align-left text-pmh-purple mr-2"></i>Description
                </label>
                <?= $this->Form->control('description', [
                    'label' => false,
                    'type' => 'textarea',
                    'rows' => 4,
                    'placeholder' => 'Brief description about the program...',
                    'class' => 'w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-pmh-purple focus:border-pmh-purple transition-all outline-none resize-none'
                ]) ?>
            </div>

            <!-- Google Form URL -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    <i class="fab fa-google text-pmh-purple mr-2"></i>Google Form URL <span class="text-gray-400 font-normal">(Registration Link)</span>
                </label>
                <?= $this->Form->control('google_form_url', [
                    'label' => false,
                    'type' => 'url',
                    'placeholder' => 'https://forms.google.com/...',
                    'class' => 'w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-pmh-purple focus:border-pmh-purple transition-all outline-none'
                ]) ?>
                <p class="text-xs text-gray-400 mt-1">Students will be redirected here when they click "Join Program"</p>
            </div>

            <!-- Status -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    <i class="fas fa-info-circle text-pmh-purple mr-2"></i>Status
                </label>
                <?= $this->Form->control('status', [
                    'label' => false,
                    'type' => 'select',
                    'options' => ['upcoming' => 'Upcoming', 'complete' => 'Complete'],
                    'default' => 'upcoming',
                    'class' => 'w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-pmh-purple focus:border-pmh-purple transition-all outline-none bg-white'
                ]) ?>
            </div>

            <!-- Submit -->
            <div class="flex flex-col sm:flex-row gap-4 pt-4">
                <button type="submit" class="flex-1 bg-gradient-to-r from-pmh-purple to-pmh-purple-dark text-white font-semibold py-4 rounded-xl hover:shadow-lg hover:shadow-purple-200 transition-all flex items-center justify-center gap-2">
                    <i class="fas fa-plus"></i> Create Program
                </button>
                <a href="<?= $this->Url->build(['action' => 'allprogram']) ?>" class="flex-1 bg-gray-100 text-gray-700 font-semibold py-4 rounded-xl hover:bg-gray-200 transition-all text-center">
                    Cancel
                </a>
            </div>
        <?= $this->Form->end() ?>
    </div>
</div>