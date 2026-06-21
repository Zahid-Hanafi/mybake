<?php
/**
 * View Application Details
 */
?>

<div class="mb-8">
    <div class="flex items-center gap-3 mb-2">
        <?php if ($isAdmin): ?>
        <a href="<?= $this->Url->build(['action' => 'adminIndex']) ?>" class="text-gray-400 hover:text-pmh-purple transition-colors">
            <i class="fas fa-arrow-left"></i>
        </a>
        <?php else: ?>
        <a href="<?= $this->Url->build(['action' => 'joinus']) ?>" class="text-gray-400 hover:text-pmh-purple transition-colors">
            <i class="fas fa-arrow-left"></i>
        </a>
        <?php endif; ?>
        <h1 class="text-2xl lg:text-3xl font-bold text-gray-900">Application Details</h1>
    </div>
</div>

<div class="max-w-4xl">
    <!-- Status Banner -->
    <?php if ($application->status === 'pending'): ?>
    <div class="bg-yellow-50 border border-yellow-200 rounded-xl px-6 py-4 mb-6 flex items-center gap-3">
        <i class="fas fa-clock text-yellow-600 text-xl"></i>
        <div>
            <p class="font-semibold text-yellow-800">Application Pending</p>
            <p class="text-sm text-yellow-700">Your application is being reviewed by the PMH team.</p>
        </div>
    </div>
    <?php elseif ($application->status === 'accepted'): ?>
    <div class="bg-green-50 border border-green-200 rounded-xl px-6 py-4 mb-6 flex items-center gap-3">
        <i class="fas fa-check-circle text-green-600 text-xl"></i>
        <div>
            <p class="font-semibold text-green-800">Application Accepted</p>
            <p class="text-sm text-green-700">Congratulations! Welcome to the PMH family.</p>
        </div>
    </div>
    <?php else: ?>
    <div class="bg-red-50 border border-red-200 rounded-xl px-6 py-4 mb-6">
        <div class="flex items-center gap-3 mb-2">
            <i class="fas fa-times-circle text-red-600 text-xl"></i>
            <p class="font-semibold text-red-800">Application Rejected</p>
        </div>
        <p class="text-sm text-red-700"><strong>Reason:</strong> <?= h($application->rejection_reason) ?></p>
    </div>
    <?php endif; ?>

    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <!-- Personal Information -->
        <div class="p-6 border-b border-gray-100">
            <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                <i class="fas fa-user text-pmh-purple"></i> Personal Information
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <p class="text-xs text-gray-500 uppercase font-semibold mb-1">Full Name</p>
                    <p class="text-gray-900 font-medium"><?= h($application->user->full_name) ?></p>
                </div>
                <div>
                    <p class="text-xs text-gray-500 uppercase font-semibold mb-1">Matric Number</p>
                    <p class="text-gray-900 font-medium"><?= h($application->user->matric_no) ?></p>
                </div>
                <div>
                    <p class="text-xs text-gray-500 uppercase font-semibold mb-1">Email</p>
                    <p class="text-gray-900 font-medium"><?= h($application->user->email) ?></p>
                </div>
                <div>
                    <p class="text-xs text-gray-500 uppercase font-semibold mb-1">Phone Number</p>
                    <p class="text-gray-900 font-medium"><?= h($application->user->phone_no) ?></p>
                </div>
                <div>
                    <p class="text-xs text-gray-500 uppercase font-semibold mb-1">Gender</p>
                    <p class="text-gray-900 font-medium"><?= h($application->gender) ?></p>
                </div>
                <div>
                    <p class="text-xs text-gray-500 uppercase font-semibold mb-1">Semester</p>
                    <p class="text-gray-900 font-medium">Semester <?= h($application->semester) ?></p>
                </div>
            </div>
        </div>

        <!-- Academic Information -->
        <div class="p-6 border-b border-gray-100">
            <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                <i class="fas fa-graduation-cap text-pmh-yellow"></i> Academic Information
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <p class="text-xs text-gray-500 uppercase font-semibold mb-1">CGPA</p>
                    <p class="text-2xl font-bold text-pmh-purple"><?= number_format((float)$application->cgpa, 2) ?></p>
                </div>
                <div>
                    <p class="text-xs text-gray-500 uppercase font-semibold mb-1">Home Address</p>
                    <p class="text-gray-900"><?= nl2br(h($application->home_address)) ?></p>
                </div>
            </div>
        </div>

        <!-- Achievements & Experience -->
        <div class="p-6 border-b border-gray-100">
            <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                <i class="fas fa-trophy text-pmh-yellow"></i> Achievements & Experience
            </h3>
            <div class="space-y-4">
                <div>
                    <p class="text-xs text-gray-500 uppercase font-semibold mb-1">Achievements</p>
                    <p class="text-gray-900 whitespace-pre-wrap"><?= h($application->achievement) ?></p>
                </div>
                <?php if ($application->relative_experience): ?>
                <div>
                    <p class="text-xs text-gray-500 uppercase font-semibold mb-1">Relative Experience</p>
                    <p class="text-gray-900 whitespace-pre-wrap"><?= h($application->relative_experience) ?></p>
                </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Interview Schedule -->
        <div class="p-6 bg-purple-50">
            <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                <i class="fas fa-calendar-check text-pmh-purple"></i> Interview Schedule
            </h3>
            <?php if ($application->interview_slot): ?>
            <div class="bg-white rounded-xl p-4 border border-purple-100">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-pmh-purple rounded-xl flex items-center justify-center">
                        <i class="fas fa-calendar text-white"></i>
                    </div>
                    <div>
                        <p class="font-bold text-gray-900"><?= $application->interview_slot->interview_date->format('l, d F Y') ?></p>
                        <p class="text-pmh-purple font-semibold"><?= h($application->interview_slot->slot_time) ?></p>
                    </div>
                </div>
            </div>
            <?php else: ?>
            <p class="text-gray-500">No interview slot assigned.</p>
            <?php endif; ?>
        </div>

        <!-- Application Meta -->
        <div class="p-6 bg-gray-50 border-t border-gray-100">
            <div class="flex flex-wrap gap-6 text-sm text-gray-500">
                <span><i class="fas fa-calendar-plus mr-1"></i> Applied: <?= $application->created_at->format('d M Y, H:i') ?></span>
                <?php if ($application->modified_at): ?>
                <span><i class="fas fa-edit mr-1"></i> Last Updated: <?= $application->modified_at->format('d M Y, H:i') ?></span>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Actions -->
    <div class="mt-6 flex flex-col sm:flex-row gap-4">
        <?php if ($application->status !== 'pending'): ?>
        <a href="<?= $this->Url->build(['action' => 'viewLetter', $application->id]) ?>" target="_blank" class="flex-1 inline-flex items-center justify-center gap-2 bg-red-50 text-red-600 border border-red-200 px-6 py-3 rounded-xl font-semibold hover:bg-red-100 transition-all">
            <i class="fas fa-file-pdf"></i> Download PDF Letter
        </a>
        <?php endif; ?>
        <?php if ($isAdmin): ?>
        <a href="<?= $this->Url->build(['action' => 'adminIndex']) ?>" class="flex-1 bg-gray-100 text-gray-700 font-semibold py-3 rounded-xl hover:bg-gray-200 transition-all text-center">
            <i class="fas fa-arrow-left mr-2"></i>Back to Applications
        </a>
        <?php else: ?>
        <a href="<?= $this->Url->build(['action' => 'joinus']) ?>" class="flex-1 bg-gray-100 text-gray-700 font-semibold py-3 rounded-xl hover:bg-gray-200 transition-all text-center">
            <i class="fas fa-arrow-left mr-2"></i>Back to My Applications
        </a>
        <?php endif; ?>
    </div>
</div>
