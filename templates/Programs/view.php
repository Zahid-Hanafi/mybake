<?php
/**
 * View Program Details
 */
?>

<!-- Page Header -->
<div class="mb-8">
    <div class="flex items-center gap-3 mb-2">
        <a href="<?= $this->Url->build(['action' => 'allprogram']) ?>" class="text-gray-400 hover:text-pmh-purple transition-colors">
            <i class="fas fa-arrow-left"></i>
        </a>
        <div class="flex-grow">
            <h1 class="text-2xl lg:text-3xl font-bold text-gray-900"><?= h($program->name) ?></h1>
        </div>
        <?php if ($isAdmin): ?>
        <a href="<?= $this->Url->build(['action' => 'edit', $program->id]) ?>" class="inline-flex items-center gap-2 bg-blue-500 text-white px-4 py-2 rounded-xl font-semibold hover:bg-blue-600 transition-colors">
            <i class="fas fa-edit"></i> Edit
        </a>
        <?php endif; ?>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Main Content -->
    <div class="lg:col-span-2 space-y-6">
        <!-- Program Info Card -->
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
            <!-- Status Banner -->
            <?php if ($program->status === 'complete'): ?>
                <div class="bg-green-500 text-white px-6 py-3 flex items-center gap-2">
                    <i class="fas fa-check-circle"></i>
                    <span class="font-semibold">Program Completed</span>
                </div>
            <?php else: ?>
                <div class="bg-gradient-to-r from-pmh-purple to-pmh-purple-dark text-white px-6 py-3 flex items-center gap-2">
                    <i class="fas fa-clock"></i>
                    <span class="font-semibold">Upcoming Program</span>
                </div>
            <?php endif; ?>
            
            <div class="p-6 lg:p-8">
                <!-- Details Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-calendar-alt text-pmh-purple text-xl"></i>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Date</p>
                            <p class="font-bold text-gray-900 text-lg"><?= h($program->date->format('d F Y')) ?></p>
                            <p class="text-sm text-gray-500"><?= h($program->date->format('l')) ?></p>
                        </div>
                    </div>

                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 bg-yellow-100 rounded-xl flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-map-marker-alt text-pmh-yellow text-xl"></i>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Venue</p>
                            <p class="font-bold text-gray-900 text-lg"><?= h($program->venue) ?></p>
                        </div>
                    </div>
                </div>

                <!-- Description -->
                <?php if ($program->description): ?>
                <div class="border-t border-gray-100 pt-6">
                    <h3 class="font-semibold text-gray-900 mb-3">
                        <i class="fas fa-align-left text-pmh-purple mr-2"></i>Description
                    </h3>
                    <p class="text-gray-600 leading-relaxed whitespace-pre-wrap"><?= h($program->description) ?></p>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Sidebar -->
    <div class="lg:col-span-1 space-y-6">
        <!-- Join Card (for upcoming programs) -->
        <?php if ($program->status === 'upcoming'): ?>
        <div class="bg-gradient-to-br from-pmh-purple to-pmh-purple-dark rounded-2xl p-6 text-white relative overflow-hidden">
            <div class="absolute top-0 right-0 w-24 h-24 bg-pmh-yellow opacity-10 rounded-full -translate-y-1/2 translate-x-1/2"></div>
            <div class="relative z-10">
                <h3 class="text-lg font-bold mb-2">Want to Join?</h3>
                <p class="text-purple-200 text-sm mb-4">Register now to participate in this program.</p>
                <a href="<?= h($program->google_form_url ?? '#') ?>" target="_blank" class="block w-full bg-pmh-yellow text-pmh-purple font-bold py-3 rounded-xl text-center hover:bg-white transition-colors">
                    <i class="fas fa-hand-pointer mr-2"></i> Register Now
                </a>
            </div>
        </div>
        <?php endif; ?>

        <!-- Quick Info -->
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
            <h3 class="font-semibold text-gray-900 mb-4">Quick Info</h3>
            <div class="space-y-3 text-sm">
                <div class="flex items-center justify-between">
                    <span class="text-gray-500">Status</span>
                    <?php if ($program->status === 'complete'): ?>
                        <span class="px-2 py-1 bg-green-100 text-green-700 rounded-lg font-medium">Complete</span>
                    <?php else: ?>
                        <span class="px-2 py-1 bg-pmh-yellow/20 text-pmh-purple rounded-lg font-medium">Upcoming</span>
                    <?php endif; ?>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-gray-500">Created</span>
                    <span class="text-gray-900"><?= h($program->created_at->format('d M Y')) ?></span>
                </div>
                <?php if ($program->modified_at): ?>
                <div class="flex items-center justify-between">
                    <span class="text-gray-500">Last Updated</span>
                    <span class="text-gray-900"><?= h($program->modified_at->format('d M Y')) ?></span>
                </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Back Button -->
        <a href="<?= $this->Url->build(['action' => 'allprogram']) ?>" class="block w-full bg-gray-100 text-gray-700 font-semibold py-3 rounded-xl text-center hover:bg-gray-200 transition-colors">
            <i class="fas fa-arrow-left mr-2"></i> Back to All Programs
        </a>
    </div>
</div>
