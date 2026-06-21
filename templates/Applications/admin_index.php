<?php
/**
 * Admin Applications Management
 */
?>

<div class="mb-8">
    <h1 class="text-2xl lg:text-3xl font-bold text-gray-900">Applications Management</h1>
    <p class="text-gray-500 mt-1">Review and manage PMH membership applications</p>
</div>

<!-- Stats Cards -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 lg:gap-6 mb-8">
    <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-gradient-to-br from-pmh-purple to-pmh-purple-dark rounded-xl flex items-center justify-center">
                <i class="fas fa-file-alt text-white"></i>
            </div>
            <span class="text-xs font-medium text-gray-400 bg-gray-50 px-2 py-1 rounded-lg">Total</span>
        </div>
        <p class="text-sm font-medium text-gray-500">Total Applications</p>
        <p class="text-3xl font-bold text-gray-900"><?= $totalApplications ?></p>
    </div>
    
    <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-gradient-to-br from-yellow-400 to-yellow-500 rounded-xl flex items-center justify-center">
                <i class="fas fa-clock text-white"></i>
            </div>
            <span class="text-xs font-medium text-yellow-600 bg-yellow-50 px-2 py-1 rounded-lg">Pending</span>
        </div>
        <p class="text-sm font-medium text-gray-500">Pending Review</p>
        <p class="text-3xl font-bold text-gray-900"><?= $totalPending ?></p>
    </div>
    
    <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-gradient-to-br from-green-400 to-green-500 rounded-xl flex items-center justify-center">
                <i class="fas fa-check-circle text-white"></i>
            </div>
            <span class="text-xs font-medium text-green-600 bg-green-50 px-2 py-1 rounded-lg">Accepted</span>
        </div>
        <p class="text-sm font-medium text-gray-500">Total Accepted</p>
        <p class="text-3xl font-bold text-gray-900"><?= $totalAccepted ?></p>
    </div>
    
    <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-gradient-to-br from-red-400 to-red-500 rounded-xl flex items-center justify-center">
                <i class="fas fa-times-circle text-white"></i>
            </div>
            <span class="text-xs font-medium text-red-600 bg-red-50 px-2 py-1 rounded-lg">Rejected</span>
        </div>
        <p class="text-sm font-medium text-gray-500">Total Rejected</p>
        <p class="text-3xl font-bold text-gray-900"><?= $totalRejected ?></p>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
    <!-- Search & Filter -->
    <div class="lg:col-span-2 bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
        <h3 class="font-bold text-gray-900 mb-4"><i class="fas fa-search text-pmh-purple mr-2"></i>Search & Filter</h3>
        <form method="get" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Search by Name</label>
                    <input type="text" name="search" value="<?= h($search ?? '') ?>" placeholder="Enter name (case-insensitive)" 
                        class="w-full px-4 py-2 border border-gray-200 rounded-xl focus:ring-2 focus:ring-pmh-purple focus:border-pmh-purple outline-none">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Search by Matric No (Exact)</label>
                    <input type="text" name="search_matric" value="<?= h($searchMatric ?? '') ?>" placeholder="Enter exact matric number" 
                        class="w-full px-4 py-2 border border-gray-200 rounded-xl focus:ring-2 focus:ring-pmh-purple focus:border-pmh-purple outline-none">
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Filter by Gender</label>
                    <select name="gender" class="w-full px-4 py-2 border border-gray-200 rounded-xl focus:ring-2 focus:ring-pmh-purple focus:border-pmh-purple outline-none bg-white">
                        <option value="">All Genders</option>
                        <option value="Male" <?= ($filterGender ?? '') === 'Male' ? 'selected' : '' ?>>Male</option>
                        <option value="Female" <?= ($filterGender ?? '') === 'Female' ? 'selected' : '' ?>>Female</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Sort By</label>
                    <select name="sort" class="w-full px-4 py-2 border border-gray-200 rounded-xl focus:ring-2 focus:ring-pmh-purple focus:border-pmh-purple outline-none bg-white">
                        <option value="">Latest First</option>
                        <option value="cgpa" <?= ($sortBy ?? '') === 'cgpa' ? 'selected' : '' ?>>CGPA (Highest to Lowest)</option>
                        <option value="semester" <?= ($sortBy ?? '') === 'semester' ? 'selected' : '' ?>>Semester (1 to 4)</option>
                    </select>
                </div>
            </div>
            <div class="flex gap-2">
                <button type="submit" class="px-6 py-2 bg-pmh-purple text-white rounded-xl font-medium hover:bg-pmh-purple-dark transition-colors">
                    <i class="fas fa-search mr-2"></i>Apply Filters
                </button>
                <a href="<?= $this->Url->build(['action' => 'adminIndex']) ?>" class="px-6 py-2 bg-gray-100 text-gray-700 rounded-xl font-medium hover:bg-gray-200 transition-colors">
                    <i class="fas fa-undo mr-2"></i>Reset
                </a>
            </div>
        </form>
    </div>

    <!-- Interview Slots Management -->
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
        <h3 class="font-bold text-gray-900 mb-4"><i class="fas fa-calendar-plus text-pmh-yellow mr-2"></i>Interview Slots</h3>
        
        <!-- Add New Slot Form -->
        <?= $this->Form->create(null, ['url' => ['action' => 'addSlot'], 'class' => 'mb-4']) ?>
            <div class="space-y-3">
                <div>
                    <label class="block text-xs font-medium text-gray-500 mb-1">Date (Mon-Wed only)</label>
                    <input type="date" name="interview_date" required class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-pmh-purple outline-none">
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-500 mb-1">Time Slot</label>
                    <select name="slot_time" required class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-pmh-purple outline-none bg-white">
                        <option value="8pm-9pm">8:00 PM - 9:00 PM</option>
                        <option value="9pm-10pm">9:00 PM - 10:00 PM</option>
                    </select>
                </div>
                <button type="submit" class="w-full px-4 py-2 bg-pmh-yellow text-pmh-purple rounded-lg font-semibold text-sm hover:bg-yellow-400 transition-colors">
                    <i class="fas fa-plus mr-1"></i> Add Slot
                </button>
            </div>
        <?= $this->Form->end() ?>

        <!-- Existing Slots -->
        <div class="border-t border-gray-100 pt-4 max-h-48 overflow-y-auto">
            <p class="text-xs font-medium text-gray-500 mb-2">Available Slots</p>
            <?php if ($interviewSlots->isEmpty()): ?>
                <p class="text-sm text-gray-400">No slots created yet.</p>
            <?php else: ?>
                <div class="space-y-2">
                    <?php foreach ($interviewSlots as $slot): ?>
                    <div class="flex items-center justify-between p-2 bg-gray-50 rounded-lg text-sm">
                        <div>
                            <p class="font-medium text-gray-800"><?= $slot->interview_date->format('D, d M') ?></p>
                            <p class="text-xs text-gray-500"><?= h($slot->slot_time) ?></p>
                        </div>
                        <div class="flex items-center gap-2">
                            <?php if ($slot->is_booked): ?>
                                <span class="px-2 py-1 bg-red-100 text-red-600 text-xs rounded-full">Booked</span>
                            <?php else: ?>
                                <span class="px-2 py-1 bg-green-100 text-green-600 text-xs rounded-full">Open</span>
                                <?= $this->Form->postLink(
                                    '<i class="fas fa-trash"></i>',
                                    ['action' => 'deleteSlot', $slot->id],
                                    ['confirm' => 'Delete this slot?', 'class' => 'text-red-500 hover:text-red-700', 'escape' => false]
                                ) ?>
                            <?php endif; ?>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Mobile Applications View -->
<div class="md:hidden space-y-4 mb-8">
    <?php if ($applications->isEmpty()): ?>
        <div class="bg-white rounded-2xl p-8 text-center border border-gray-100">
            <div class="w-12 h-12 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-3">
                <i class="fas fa-inbox text-gray-400"></i>
            </div>
            <p class="text-sm text-gray-500">No applications found.</p>
        </div>
    <?php else: ?>
        <?php foreach ($applications as $app): ?>
        <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm">
            <div class="flex justify-between items-start mb-4">
                <div>
                    <h4 class="font-bold text-gray-900"><?= h($app->user->full_name) ?></h4>
                    <p class="text-xs text-gray-500 mt-1"><?= h($app->user->matric_no) ?> • <?= h($app->gender) ?></p>
                </div>
                <?php if ($app->status === 'pending'): ?>
                    <span class="px-2.5 py-1 bg-yellow-100 text-yellow-700 rounded-lg text-xs font-bold">Pending</span>
                <?php elseif ($app->status === 'accepted'): ?>
                    <span class="px-2.5 py-1 bg-green-100 text-green-700 rounded-lg text-xs font-bold">Accepted</span>
                <?php else: ?>
                    <span class="px-2.5 py-1 bg-red-100 text-red-700 rounded-lg text-xs font-bold">Rejected</span>
                <?php endif; ?>
            </div>

            <div class="grid grid-cols-2 gap-3 mb-4">
                <div class="bg-gray-50 p-3 rounded-xl">
                    <p class="text-xs text-gray-400 uppercase font-bold mb-1">CGPA</p>
                    <p class="font-bold text-pmh-purple"><?= number_format((float)$app->cgpa, 2) ?></p>
                </div>
                <div class="bg-gray-50 p-3 rounded-xl">
                    <p class="text-xs text-gray-400 uppercase font-bold mb-1">Semester</p>
                    <p class="font-medium text-gray-900"><?= h($app->semester) ?></p>
                </div>
            </div>

            <div class="flex items-center gap-2 pt-4 border-t border-gray-50">
                <a href="<?= $this->Url->build(['action' => 'view', $app->id]) ?>" class="flex-1 py-2 bg-blue-50 text-blue-600 rounded-xl flex items-center justify-center text-sm font-medium hover:bg-blue-100 transition-colors">
                    <i class="fas fa-eye mr-2"></i> View
                </a>
                
                <?php if ($app->status === 'pending'): ?>
                    <?= $this->Form->postLink(
                        '<i class="fas fa-check"></i>',
                        ['action' => 'acceptApplication', $app->id],
                        [
                            'confirm' => 'Are you sure you want to ACCEPT this application?',
                            'class' => 'w-10 h-10 bg-green-100 text-green-600 rounded-xl flex items-center justify-center hover:bg-green-200 transition-colors',
                            'escape' => false,
                            'title' => 'Accept Application'
                        ]
                    ) ?>
                    
                    <button type="button" onclick="openRejectModal(<?= $app->id ?>)" class="w-10 h-10 bg-red-100 text-red-600 rounded-xl flex items-center justify-center hover:bg-red-200 transition-colors" title="Reject Application">
                        <i class="fas fa-times"></i>
                    </button>
                <?php endif; ?>
                
                <?php if ($app->status !== 'pending'): ?>
                    <a href="<?= $this->Url->build(['action' => 'viewLetter', $app->id]) ?>" target="_blank" class="w-10 h-10 bg-red-50 text-red-600 rounded-xl flex items-center justify-center hover:bg-red-100 transition-colors" title="View PDF Letter">
                        <i class="fas fa-file-pdf"></i>
                    </a>
                <?php endif; ?>
            </div>
        </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<!-- Applications Table -->
<div class="hidden md:block bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
    <div class="p-6 border-b border-gray-100">
        <h3 class="font-bold text-gray-900"><i class="fas fa-list text-pmh-purple mr-2"></i>All Applications</h3>
    </div>
    
    <?php if ($applications->isEmpty()): ?>
    <div class="p-12 text-center">
        <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
            <i class="fas fa-inbox text-gray-400 text-2xl"></i>
        </div>
        <p class="text-gray-500">No applications found.</p>
    </div>
    <?php else: ?>
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50 border-b border-gray-100">
                <tr>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Name</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Matric No</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Gender</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">CGPA</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Semester</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Status</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                <?php foreach ($applications as $app): ?>
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-6 py-4 font-medium text-gray-900"><?= h($app->user->full_name) ?></td>
                    <td class="px-6 py-4 text-gray-600"><?= h($app->user->matric_no) ?></td>
                    <td class="px-6 py-4 text-gray-600"><?= h($app->gender) ?></td>
                    <td class="px-6 py-4 font-semibold text-pmh-purple"><?= number_format((float)$app->cgpa, 2) ?></td>
                    <td class="px-6 py-4 text-gray-600"><?= h($app->semester) ?></td>
                    <td class="px-6 py-4">
                        <?php if ($app->status === 'pending'): ?>
                            <span class="px-3 py-1 bg-yellow-100 text-yellow-700 rounded-full text-xs font-semibold">Pending</span>
                        <?php elseif ($app->status === 'accepted'): ?>
                            <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-semibold">Accepted</span>
                        <?php else: ?>
                            <span class="px-3 py-1 bg-red-100 text-red-700 rounded-full text-xs font-semibold">Rejected</span>
                        <?php endif; ?>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-2">
                            <!-- View -->
                            <a href="<?= $this->Url->build(['action' => 'view', $app->id]) ?>" class="w-8 h-8 bg-blue-100 text-blue-600 rounded-lg flex items-center justify-center hover:bg-blue-200 transition-colors" title="View Details">
                                <i class="fas fa-eye"></i>
                            </a>
                            
                            <?php if ($app->status === 'pending'): ?>
                            <!-- Accept Button -->
                            <?= $this->Form->postLink(
                                '<i class="fas fa-check"></i>',
                                ['action' => 'acceptApplication', $app->id],
                                [
                                    'confirm' => 'Are you sure you want to ACCEPT this application?',
                                    'class' => 'w-8 h-8 bg-green-100 text-green-600 rounded-lg flex items-center justify-center hover:bg-green-200 transition-colors',
                                    'escape' => false,
                                    'title' => 'Accept Application'
                                ]
                            ) ?>
                            
                            <!-- Reject Button (opens modal) -->
                            <button type="button" onclick="openRejectModal(<?= $app->id ?>)" class="w-8 h-8 bg-red-100 text-red-600 rounded-lg flex items-center justify-center hover:bg-red-200 transition-colors" title="Reject Application">
                                <i class="fas fa-times"></i>
                            </button>
                            <?php endif; ?>
                            
                            <!-- PDF for processed -->
                            <?php if ($app->status !== 'pending'): ?>
                            <a href="<?= $this->Url->build(['action' => 'viewLetter', $app->id]) ?>" target="_blank" class="w-8 h-8 bg-red-50 text-red-600 rounded-lg flex items-center justify-center hover:bg-red-100 transition-colors" title="View PDF Letter">
                                <i class="fas fa-file-pdf"></i>
                            </a>
                            <?php endif; ?>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php endif; ?>
</div>

<!-- Reject Modal -->
<div id="rejectModal" class="fixed inset-0 bg-black/50 z-50 hidden items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-md w-full p-6 shadow-2xl">
        <div class="text-center mb-4">
            <div class="w-14 h-14 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-3">
                <i class="fas fa-times-circle text-red-600 text-2xl"></i>
            </div>
            <h3 class="text-lg font-bold text-gray-900">Reject Application</h3>
            <p class="text-sm text-gray-500">Please select a reason for rejection</p>
        </div>
        
        <?= $this->Form->create(null, ['url' => ['action' => 'rejectApplication', ''], 'id' => 'rejectForm']) ?>
            <input type="hidden" name="app_id" id="rejectAppId" value="">
            
            <div class="mb-4">
                <select name="rejection_reason" required class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-red-500 outline-none bg-white">
                    <option value="">Select reason...</option>
                    <?php foreach ($rejectionReasons as $key => $reason): ?>
                    <option value="<?= h($reason) ?>"><?= h($reason) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            
            <div class="flex gap-3">
                <button type="submit" class="flex-1 bg-red-600 text-white font-semibold py-3 rounded-xl hover:bg-red-700 transition-all">
                    Confirm Reject
                </button>
                <button type="button" onclick="closeRejectModal()" class="flex-1 bg-gray-100 text-gray-700 font-semibold py-3 rounded-xl hover:bg-gray-200 transition-all">
                    Cancel
                </button>
            </div>
        <?= $this->Form->end() ?>
    </div>
</div>

<script>
function openRejectModal(appId) {
    document.getElementById('rejectAppId').value = appId;
    document.getElementById('rejectForm').action = '<?= $this->Url->build(['action' => 'rejectApplication']) ?>/' + appId;
    document.getElementById('rejectModal').classList.remove('hidden');
    document.getElementById('rejectModal').classList.add('flex');
}

function closeRejectModal() {
    document.getElementById('rejectModal').classList.add('hidden');
    document.getElementById('rejectModal').classList.remove('flex');
}
</script>
