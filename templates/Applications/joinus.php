<?php
/**
 * Join Us - PMH Membership Application (Student View)
 */
$identity = $this->request->getAttribute('identity');
$isAdmin = $identity && $identity->get('role') === 'admin';
?>

<?php if (!$isAdmin): ?>
<!-- Student View: Benefits Card -->
<div class="mb-8">
    <h1 class="text-2xl lg:text-3xl font-bold text-gray-900">Join PMH</h1>
    <p class="text-gray-500 mt-1">Become a member of Persatuan Mahasiswa Hadhari</p>
</div>

<!-- Benefits Info Card -->
<div class="bg-gradient-to-br from-pmh-purple to-pmh-purple-dark rounded-2xl p-8 mb-8 relative overflow-hidden">
    <div class="absolute top-0 right-0 w-64 h-64 bg-pmh-yellow opacity-10 rounded-full -translate-y-1/2 translate-x-1/2"></div>
    <div class="absolute bottom-0 left-0 w-48 h-48 bg-white opacity-5 rounded-full translate-y-1/2 -translate-x-1/2"></div>
    
    <div class="relative z-10 grid grid-cols-1 lg:grid-cols-2 gap-8">
        <div class="text-white">
            <span class="inline-flex items-center gap-2 bg-pmh-yellow text-pmh-purple text-xs font-bold px-4 py-1.5 rounded-full mb-4">
                <i class="fas fa-star"></i> JOIN THE FAMILY
            </span>
            <h2 class="text-2xl lg:text-3xl font-bold mb-4">Benefits of Joining PMH</h2>
            <ul class="space-y-3 text-purple-100">
                <li class="flex items-start gap-3">
                    <i class="fas fa-check-circle text-pmh-yellow mt-1"></i>
                    <span>Access to exclusive leadership development programs</span>
                </li>
                <li class="flex items-start gap-3">
                    <i class="fas fa-check-circle text-pmh-yellow mt-1"></i>
                    <span>Networking opportunities with industry professionals</span>
                </li>
                <li class="flex items-start gap-3">
                    <i class="fas fa-check-circle text-pmh-yellow mt-1"></i>
                    <span>Priority registration for PMH events and activities</span>
                </li>
                <li class="flex items-start gap-3">
                    <i class="fas fa-check-circle text-pmh-yellow mt-1"></i>
                    <span>Certificate of participation for portfolio enhancement</span>
                </li>
            </ul>
        </div>
        
        <div class="bg-white/10 backdrop-blur-sm rounded-xl p-6 border border-white/20">
            <h3 class="text-lg font-bold text-pmh-yellow mb-4"><i class="fas fa-info-circle mr-2"></i>Important Notes</h3>
            <div class="space-y-4 text-white text-sm">
                <div class="flex items-start gap-3">
                    <div class="w-8 h-8 bg-pmh-yellow/20 rounded-lg flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-graduation-cap text-pmh-yellow"></i>
                    </div>
                    <div>
                        <p class="font-semibold">Semester Requirement</p>
                        <p class="text-purple-200">Only <strong>Semester 1 to 4</strong> students are eligible to apply</p>
                    </div>
                </div>
                <div class="flex items-start gap-3">
                    <div class="w-8 h-8 bg-pmh-yellow/20 rounded-lg flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-university text-pmh-yellow"></i>
                    </div>
                    <div>
                        <p class="font-semibold">Open Enrollment</p>
                        <p class="text-purple-200">Open to all students of <strong>UiTM Puncak Perdana</strong></p>
                    </div>
                </div>
                <div class="flex items-start gap-3">
                    <div class="w-8 h-8 bg-pmh-yellow/20 rounded-lg flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-user-clock text-pmh-yellow"></i>
                    </div>
                    <div>
                        <p class="font-semibold">Trial Period</p>
                        <p class="text-purple-200">Accepted members will undergo a <strong>one-semester trial as Adhoc</strong></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Create Application Button -->
<div class="mb-6">
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 mb-4">
        <h2 class="text-xl font-bold text-gray-900 flex items-center gap-3">
            <i class="fas fa-file-alt text-pmh-purple"></i> My Applications
        </h2>
        
        <?php if (count($slotOptions) > 0): ?>
        <a href="<?= $this->Url->build(['action' => 'add']) ?>" class="inline-flex items-center gap-2 bg-gradient-to-r from-pmh-purple to-pmh-purple-dark text-white px-6 py-3 rounded-xl font-semibold hover:shadow-lg hover:shadow-purple-200 transition-all">
            <i class="fas fa-plus"></i> Create New Application
        </a>
        <?php else: ?>
        <button disabled class="inline-flex items-center gap-2 bg-gray-300 text-gray-500 px-6 py-3 rounded-xl font-semibold cursor-not-allowed">
            <i class="fas fa-plus"></i> Create New Application
        </button>
        <?php endif; ?>
    </div>
    
    <?php if (count($slotOptions) == 0): ?>
    <div class="bg-yellow-50 border border-yellow-200 rounded-xl px-4 py-3">
        <p class="text-yellow-800 text-sm">
            <i class="fas fa-exclamation-triangle mr-2"></i>
            No interview slots available. Please contact admin to request new slots.
            <a href="<?= $this->Url->build(['controller' => 'Pages', 'action' => 'display', 'contactus']) ?>" class="ml-2 text-pmh-purple font-semibold hover:underline">
                Contact Us <i class="fas fa-arrow-right"></i>
            </a>
        </p>
    </div>
    <?php endif; ?>
</div>

<!-- Mobile Applications View -->
<div class="md:hidden space-y-4 mb-8">
    <?php if ($myApplications->isEmpty()): ?>
        <div class="bg-white rounded-2xl p-8 text-center border border-gray-100">
            <div class="w-12 h-12 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-folder-open text-gray-400 text-2xl"></i>
            </div>
            <p class="text-gray-500">You haven't submitted any applications yet.</p>
        </div>
    <?php else: ?>
        <?php foreach ($myApplications as $app): ?>
        <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm">
            <div class="flex justify-between items-start mb-4">
                <div>
                    <h4 class="font-bold text-gray-900"><?= h($user->full_name) ?></h4>
                    <p class="text-xs text-gray-500 mt-1"><?= h($user->matric_no) ?></p>
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
                    <p class="text-xs text-gray-400 uppercase font-bold mb-1">Details</p>
                    <p class="text-sm text-gray-900">Sem <?= h($app->semester) ?> • <?= h($app->gender) ?></p>
                </div>
            </div>

            <div class="flex items-center gap-2 pt-4 border-t border-gray-50">
                <?php if ($app->status === 'pending'): ?>
                    <a href="<?= $this->Url->build(['action' => 'view', $app->id]) ?>" class="flex-1 py-2 bg-blue-50 text-blue-600 rounded-xl flex items-center justify-center text-sm font-medium hover:bg-blue-100 transition-colors">
                        <i class="fas fa-eye mr-2"></i> View
                    </a>
                    <a href="<?= $this->Url->build(['action' => 'edit', $app->id]) ?>" class="flex-1 py-2 bg-yellow-50 text-yellow-600 rounded-xl flex items-center justify-center text-sm font-medium hover:bg-yellow-100 transition-colors">
                        <i class="fas fa-edit mr-2"></i> Edit
                    </a>
                    <?= $this->Form->postLink(
                        '<i class="fas fa-trash"></i>',
                        ['action' => 'delete', $app->id],
                        [
                            'confirm' => __('Are you sure you want to withdraw this application?'),
                            'class' => 'w-10 h-10 bg-red-100 text-red-600 rounded-xl flex items-center justify-center hover:bg-red-200 transition-colors',
                            'escape' => false,
                            'title' => 'Withdraw'
                        ]
                    ) ?>
                <?php else: ?>
                    <a href="<?= $this->Url->build(['action' => 'view', $app->id]) ?>" class="flex-1 py-2 bg-blue-50 text-blue-600 rounded-xl flex items-center justify-center text-sm font-medium hover:bg-blue-100 transition-colors">
                        <i class="fas fa-eye mr-2"></i> View
                    </a>
                    <a href="<?= $this->Url->build(['action' => 'viewLetter', $app->id]) ?>" target="_blank" class="flex-1 py-2 bg-red-50 text-red-600 rounded-xl flex items-center justify-center text-sm font-medium hover:bg-red-100 transition-colors">
                        <i class="fas fa-file-pdf mr-2"></i> PDF Letter
                    </a>
                <?php endif; ?>
            </div>
        </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<!-- Applications Table -->
<div class="hidden md:block bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
    <?php if ($myApplications->isEmpty()): ?>
    <div class="p-12 text-center">
        <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
            <i class="fas fa-folder-open text-gray-400 text-2xl"></i>
        </div>
        <p class="text-gray-500">You haven't submitted any applications yet.</p>
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
                <?php foreach ($myApplications as $app): ?>
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-6 py-4 font-medium text-gray-900"><?= h($user->full_name) ?></td>
                    <td class="px-6 py-4 text-gray-600"><?= h($user->matric_no) ?></td>
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
                            <?php if ($app->status === 'pending'): ?>
                                <!-- CRUD Actions for Pending -->
                                <a href="<?= $this->Url->build(['action' => 'view', $app->id]) ?>" class="w-8 h-8 bg-blue-100 text-blue-600 rounded-lg flex items-center justify-center hover:bg-blue-200 transition-colors" title="View">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="<?= $this->Url->build(['action' => 'edit', $app->id]) ?>" class="w-8 h-8 bg-yellow-100 text-yellow-600 rounded-lg flex items-center justify-center hover:bg-yellow-200 transition-colors" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <?= $this->Form->postLink(
                                    '<i class="fas fa-trash"></i>',
                                    ['action' => 'delete', $app->id],
                                    [
                                        'confirm' => __('Are you sure you want to withdraw this application?'),
                                        'class' => 'w-8 h-8 bg-red-100 text-red-600 rounded-lg flex items-center justify-center hover:bg-red-200 transition-colors',
                                        'escape' => false,
                                        'title' => 'Withdraw'
                                    ]
                                ) ?>
                            <?php else: ?>
                                <!-- PDF Letter for Processed Applications -->
                                <a href="<?= $this->Url->build(['action' => 'view', $app->id]) ?>" class="w-8 h-8 bg-blue-100 text-blue-600 rounded-lg flex items-center justify-center hover:bg-blue-200 transition-colors" title="View Details">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="<?= $this->Url->build(['action' => 'viewLetter', $app->id]) ?>" target="_blank" class="inline-flex items-center gap-2 bg-red-50 text-red-600 px-3 py-2 rounded-lg text-sm font-semibold hover:bg-red-100 transition-colors" title="Download PDF Letter">
                                    <i class="fas fa-file-pdf"></i> PDF Letter
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

<?php else: ?>
<!-- Admin redirect notice -->
<div class="text-center py-12">
    <p class="text-gray-500 mb-4">Admin users should use the Applications Management page.</p>
    <a href="<?= $this->Url->build(['action' => 'adminIndex']) ?>" class="inline-flex items-center gap-2 bg-pmh-purple text-white px-6 py-3 rounded-xl font-semibold">
        <i class="fas fa-cog"></i> Go to Applications Management
    </a>
</div>
<?php endif; ?>