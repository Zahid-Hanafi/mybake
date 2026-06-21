<?php
/**
 * All Programs - PMH Program Announcement Platform
 * Students: View only | Admin: Full CRUD
 * Custom Calendar with Flatpickr - Clean Modern Design
 */

// Convert programs to array for JavaScript
$programDates = [];
$programsArray = $programs->toArray();
foreach ($programsArray as $program) {
    $dateKey = $program->date->format('Y-m-d');
    $programDates[$dateKey][] = [
        'id' => $program->id,
        'name' => $program->name,
        'venue' => $program->venue,
        'status' => $program->status,
        'description' => $program->description ?? '',
        'google_form_url' => $program->google_form_url ?? ''
    ];
}
?>

<!-- Flatpickr CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

<style>
    /* Clean Calendar Wrapper */
    .calendar-wrapper {
        display: flex;
        justify-content: center;
        padding: 24px;
        height: 100%;
        align-items: center;
    }
    .calendar-inner {
        width: 340px;
        background: white;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 4px 20px rgba(124, 42, 124, 0.1);
    }
    
    /* Override Flatpickr Completely */
    .flatpickr-calendar {
        width: 100% !important;
        box-shadow: none !important;
        border: none !important;
        background: transparent !important;
        font-family: 'Inter', sans-serif !important;
    }
    .flatpickr-calendar.inline {
        display: block !important;
        position: relative !important;
        top: 0 !important;
    }
    
    /* Header with Month/Year */
    .flatpickr-months {
        background: linear-gradient(135deg, #7c2a7c 0%, #5a1f5a 100%) !important;
        padding: 16px 12px !important;
        height: auto !important;
    }
    .flatpickr-months .flatpickr-month {
        height: 36px !important;
        color: white !important;
    }
    .flatpickr-current-month {
        font-size: 16px !important;
        font-weight: 600 !important;
        padding: 4px 0 0 0 !important;
    }
    .flatpickr-current-month .flatpickr-monthDropdown-months {
        background: rgba(255,255,255,0.15) !important;
        border: none !important;
        border-radius: 8px !important;
        color: white !important;
        font-weight: 600 !important;
        padding: 6px 10px !important;
        margin-right: 4px !important;
    }
    .flatpickr-current-month .flatpickr-monthDropdown-months option {
        background: #7c2a7c !important;
        color: white !important;
    }
    .flatpickr-current-month .numInputWrapper {
        width: 70px !important;
    }
    .flatpickr-current-month input.cur-year {
        color: white !important;
        font-weight: 600 !important;
        background: rgba(255,255,255,0.15) !important;
        border-radius: 8px !important;
        padding: 6px 10px !important;
        border: none !important;
    }
    .numInputWrapper span {
        border: none !important;
        opacity: 0.7 !important;
    }
    .numInputWrapper span:hover { opacity: 1 !important; }
    .numInputWrapper span.arrowUp:after { border-bottom-color: white !important; }
    .numInputWrapper span.arrowDown:after { border-top-color: white !important; }
    
    /* Navigation Arrows */
    .flatpickr-months .flatpickr-prev-month,
    .flatpickr-months .flatpickr-next-month {
        fill: white !important;
        width: 36px !important;
        height: 36px !important;
        padding: 10px !important;
        border-radius: 10px !important;
        top: 16px !important;
        transition: background 0.2s !important;
    }
    .flatpickr-months .flatpickr-prev-month:hover,
    .flatpickr-months .flatpickr-next-month:hover {
        background: rgba(255,255,255,0.15) !important;
    }
    .flatpickr-prev-month { left: 12px !important; }
    .flatpickr-next-month { right: 12px !important; }
    
    /* Weekday Labels */
    .flatpickr-weekdays {
        background: #fafafa !important;
        padding: 12px 8px !important;
        height: auto !important;
    }
    .flatpickr-weekdaycontainer {
        display: flex !important;
    }
    .flatpickr-weekday {
        flex: 1 !important;
        color: #888 !important;
        font-weight: 600 !important;
        font-size: 11px !important;
        text-transform: uppercase !important;
        letter-spacing: 0.5px !important;
    }
    
    /* Days Container */
    .flatpickr-innerContainer {
        padding: 8px !important;
    }
    .flatpickr-rContainer {
        width: 100% !important;
    }
    .flatpickr-days {
        width: 100% !important;
    }
    .dayContainer {
        width: 100% !important;
        max-width: 100% !important;
        min-width: 100% !important;
        display: flex !important;
        flex-wrap: wrap !important;
        justify-content: flex-start !important;
        padding: 4px !important;
    }
    
    /* Individual Day Cells */
    .flatpickr-day {
        width: calc(100% / 7 - 4px) !important;
        max-width: calc(100% / 7 - 4px) !important;
        height: 40px !important;
        line-height: 40px !important;
        margin: 2px !important;
        border-radius: 10px !important;
        font-size: 14px !important;
        font-weight: 500 !important;
        color: #333 !important;
        border: 2px solid transparent !important;
        flex-basis: calc(100% / 7 - 4px) !important;
    }
    .flatpickr-day:hover {
        background: #f5f0f5 !important;
        border-color: #e8d8e8 !important;
    }
    .flatpickr-day.today {
        background: #f3e8ff !important;
        border-color: #7c2a7c !important;
        color: #7c2a7c !important;
        font-weight: 700 !important;
    }
    .flatpickr-day.selected {
        background: #7c2a7c !important;
        border-color: #7c2a7c !important;
        color: white !important;
    }
    .flatpickr-day.prevMonthDay,
    .flatpickr-day.nextMonthDay {
        color: #ccc !important;
    }
    
    /* Program Highlighted Days */
    .flatpickr-day.has-program {
        background: #edd134 !important;
        border-color: #edd134 !important;
        color: #7c2a7c !important;
        font-weight: 700 !important;
    }
    .flatpickr-day.has-program:hover {
        background: #dfc42e !important;
        border-color: #dfc42e !important;
    }
    .flatpickr-day.has-program-complete {
        background: #10b981 !important;
        border-color: #10b981 !important;
        color: white !important;
        font-weight: 700 !important;
    }
    .flatpickr-day.has-program-complete:hover {
        background: #059669 !important;
    }
    
    .date-link { cursor: pointer; transition: transform 0.2s; }
    .date-link:hover { transform: scale(1.03); }
</style>

<!-- Scroll to Top Button -->
<button id="scrollTopBtn" onclick="scrollToTop()" class="fixed bottom-6 right-6 w-12 h-12 bg-pmh-purple text-white rounded-full shadow-lg hover:bg-pmh-purple-dark transition-all opacity-0 invisible z-50 flex items-center justify-center">
    <i class="fas fa-arrow-up"></i>
</button>

<!-- Page Header -->
<div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
    <div>
        <h1 class="text-2xl lg:text-3xl font-bold text-gray-900">All Programs 2025</h1>
        <p class="text-gray-500 mt-1">View all PMH programs and events for this year</p>
    </div>
    <div class="flex flex-wrap gap-3">
        <a href="#programs-table" class="inline-flex items-center gap-2 bg-white border-2 border-gray-200 text-gray-700 px-5 py-2.5 rounded-xl font-semibold hover:bg-gray-50 hover:border-gray-300 transition-all">
            <i class="fas fa-list"></i> View All Programs
        </a>
        <?php if ($isAdmin): ?>
        <a href="<?= $this->Url->build(['action' => 'add']) ?>" class="inline-flex items-center gap-2 bg-gradient-to-r from-pmh-purple to-pmh-purple-dark text-white px-5 py-2.5 rounded-xl font-semibold hover:shadow-lg hover:shadow-purple-200 transition-all">
            <i class="fas fa-plus"></i> Create New Program
        </a>
        <?php endif; ?>
    </div>
</div>

<!-- Status Legend -->
<div class="flex flex-wrap items-center justify-center gap-6 mb-4 py-3 bg-gray-50 rounded-xl">
    <span class="text-gray-500 font-medium text-sm">Calendar Status:</span>
    <span class="inline-flex items-center gap-2">
        <span class="w-5 h-5 bg-pmh-yellow rounded-lg shadow-sm"></span>
        <span class="text-gray-700 font-medium text-sm">Upcoming</span>
    </span>
    <span class="inline-flex items-center gap-2">
        <span class="w-5 h-5 bg-green-500 rounded-lg shadow-sm"></span>
        <span class="text-gray-700 font-medium text-sm">Complete</span>
    </span>
</div>

<!-- Calendar & Info Section -->
<div class="bg-gradient-to-br from-purple-50 to-white rounded-2xl border border-gray-100 mb-8 overflow-hidden">
    <div class="grid grid-cols-1 lg:grid-cols-2">
        <!-- Left: Calendar Widget -->
        <div class="calendar-wrapper border-b lg:border-b-0 lg:border-r border-gray-100">
            <div class="calendar-inner">
                <div id="calendarWidget"></div>
            </div>
        </div>

        <!-- Right: Program Info -->
        <div class="p-8 lg:p-12 flex flex-col justify-center items-center text-center bg-white/50 backdrop-blur-sm">
            <div class="w-16 h-16 bg-gradient-to-br from-pmh-purple to-purple-800 rounded-2xl flex items-center justify-center mb-6 shadow-lg shadow-purple-200">
                <i class="fas fa-graduation-cap text-3xl text-white"></i>
            </div>
            
            <h3 class="text-2xl font-bold text-gray-900 mb-4">Student Benefit Program</h3>
            
            <div class="space-y-4 max-w-md text-gray-600 leading-relaxed">
                <p>
                    All programs organized by PMH are <span class="text-pmh-purple font-bold">100% for educational purposes</span> to enhance student development and community engagement.
                </p>
                
                <div class="bg-purple-50 rounded-xl p-4 border border-purple-100 text-sm">
                    <ul class="space-y-2 text-left">
                        <li class="flex items-start gap-2">
                            <i class="fas fa-utensils text-pmh-purple mt-1"></i>
                            <span><strong>Free Food</strong> provided for all participants</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <i class="fas fa-star text-pmh-purple mt-1"></i>
                            <span><strong>E-Merit</strong> awarded for each program joined</span>
                        </li>
                    </ul>
                </div>
                
                <p class="text-xs text-gray-400 mt-4 border-t border-gray-100 pt-4">
                    <i class="fas fa-shield-alt mr-1"></i> 
                    This event was under monitoring of <strong>Unit Hal Ehwal Islam (UHEI)</strong>
                </p>
            </div>
        </div>
    </div>
    
    <!-- Selected Date Programs -->
    <div id="selectedDatePrograms" class="hidden border-t border-gray-200 p-6 bg-white">
        <h4 class="font-bold text-gray-900 mb-4 flex items-center gap-2 text-lg">
            <i class="fas fa-calendar-check text-pmh-purple"></i>
            <span id="selectedDateTitle">Programs</span>
        </h4>
        <div id="selectedDateContent" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4"></div>
    </div>
</div>

<!-- Programs Table Section -->
<div id="programs-table" class="scroll-mt-24">
    <div class="flex items-center justify-between mb-4">
        <h2 class="text-xl font-bold text-gray-900 flex items-center gap-2">
            <i class="fas fa-list text-pmh-purple"></i> Program List
        </h2>
        <?php if ($isAdmin): ?>
        <span class="text-xs text-gray-400 bg-gray-100 px-3 py-1.5 rounded-lg"><i class="fas fa-user-shield mr-1"></i> Admin Mode</span>
        <?php endif; ?>
    </div>

    <!-- Mobile Cards -->
    <div class="space-y-4 lg:hidden">
        <?php foreach ($programsArray as $program): ?>
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="p-5">
                <div class="flex items-start justify-between gap-3 mb-3">
                    <div>
                        <?= $program->status === 'complete' 
                            ? '<span class="inline-flex items-center px-2 py-1 rounded-full text-[10px] font-bold bg-green-100 text-green-700 mb-2"><i class="fas fa-check-circle mr-1"></i>Complete</span>'
                            : '<span class="inline-flex items-center px-2 py-1 rounded-full text-[10px] font-bold bg-pmh-yellow text-pmh-purple mb-2"><i class="fas fa-clock mr-1"></i>Upcoming</span>' ?>
                        <h3 class="font-bold text-gray-900"><?= h($program->name) ?></h3>
                    </div>
                    <div class="text-center bg-purple-100 rounded-xl px-3 py-2 date-link" data-date="<?= $program->date->format('Y-m-d') ?>">
                        <p class="text-lg font-bold text-pmh-purple"><?= h($program->date->format('d')) ?></p>
                        <p class="text-[10px] text-pmh-purple uppercase"><?= h($program->date->format('M')) ?></p>
                    </div>
                </div>
                <p class="text-sm text-gray-500 flex items-center gap-2 mb-2"><i class="fas fa-map-marker-alt text-pmh-yellow"></i><?= h($program->venue) ?></p>
                <?php if ($program->description): ?><p class="text-sm text-gray-600 line-clamp-2 mb-3"><?= h($program->description) ?></p><?php endif; ?>
                <div class="flex items-center gap-2 pt-3 border-t border-gray-100">
                    <?php if (!$isAdmin && $program->status === 'upcoming'): ?>
                        <?php if (!empty($program->google_form_url)): ?>
                            <a href="<?= h($program->google_form_url) ?>" target="_blank" class="flex-1 text-center text-sm font-bold text-white bg-pmh-purple px-4 py-2.5 rounded-xl hover:bg-pmh-purple-dark transition-colors"><i class="fas fa-hand-pointer mr-1"></i> Join Now</a>
                        <?php else: ?>
                            <span class="flex-1 text-center text-sm font-bold text-gray-400 bg-gray-100 px-4 py-2.5 rounded-xl cursor-not-allowed"><i class="fas fa-clock mr-1"></i> Coming Soon</span>
                        <?php endif; ?>
                    <?php endif; ?>
                    <a href="<?= $this->Url->build(['action' => 'view', $program->id]) ?>" class="text-sm font-medium text-pmh-purple hover:underline px-3 py-2">Details</a>
                    <?php if ($isAdmin): ?>
                        <a href="<?= $this->Url->build(['action' => 'edit', $program->id]) ?>" class="p-2 text-blue-500 hover:bg-blue-50 rounded-lg"><i class="fas fa-edit"></i></a>
                        <?= $this->Form->postLink('<i class="fas fa-trash"></i>', ['action' => 'delete', $program->id], ['confirm' => __('Delete "{0}"?', $program->name), 'escape' => false, 'class' => 'p-2 text-red-500 hover:bg-red-50 rounded-lg']) ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>

    <!-- Desktop Table -->
    <div class="hidden lg:block bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <table class="w-full">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-100">
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase">Date</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase">Program Name</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase">Venue</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase">Status</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                <?php foreach ($programsArray as $program): ?>
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3 date-link" data-date="<?= $program->date->format('Y-m-d') ?>">
                            <div class="w-12 h-12 bg-gradient-to-br from-purple-100 to-purple-50 rounded-xl flex flex-col items-center justify-center hover:from-pmh-purple hover:to-pmh-purple-dark group cursor-pointer transition-all">
                                <span class="text-lg font-bold text-pmh-purple group-hover:text-white"><?= h($program->date->format('d')) ?></span>
                                <span class="text-[9px] text-pmh-purple uppercase font-medium group-hover:text-pmh-yellow"><?= h($program->date->format('M')) ?></span>
                            </div>
                            <span class="text-sm text-gray-400"><?= h($program->date->format('Y')) ?></span>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <p class="font-semibold text-gray-900"><?= h($program->name) ?></p>
                        <?php if ($program->description): ?><p class="text-sm text-gray-400 line-clamp-1 mt-1"><?= h($program->description) ?></p><?php endif; ?>
                    </td>
                    <td class="px-6 py-4">
                        <p class="text-gray-600 flex items-center gap-2"><i class="fas fa-map-marker-alt text-pmh-yellow"></i><?= h($program->venue) ?></p>
                    </td>
                    <td class="px-6 py-4">
                        <?= $program->status === 'complete'
                            ? '<span class="inline-flex items-center px-3 py-1.5 rounded-xl text-xs font-bold bg-green-100 text-green-700"><i class="fas fa-check-circle mr-1"></i>Complete</span>'
                            : '<span class="inline-flex items-center px-3 py-1.5 rounded-xl text-xs font-bold bg-pmh-yellow/20 text-pmh-purple"><i class="fas fa-clock mr-1"></i>Upcoming</span>' ?>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-2">
                            <?php if (!$isAdmin && $program->status === 'upcoming'): ?>
                                <?php if (!empty($program->google_form_url)): ?>
                                    <a href="<?= h($program->google_form_url) ?>" target="_blank" class="text-sm font-bold text-white bg-pmh-purple px-4 py-2 rounded-lg hover:bg-pmh-purple-dark transition-colors"><i class="fas fa-hand-pointer mr-1"></i> Join</a>
                                <?php else: ?>
                                    <span class="text-xs font-medium text-gray-400 bg-gray-100 px-3 py-2 rounded-lg">Coming Soon</span>
                                <?php endif; ?>
                            <?php endif; ?>
                            <a href="<?= $this->Url->build(['action' => 'view', $program->id]) ?>" class="p-2 text-gray-400 hover:text-pmh-purple hover:bg-purple-50 rounded-lg transition-all" title="View"><i class="fas fa-eye"></i></a>
                            <?php if ($isAdmin): ?>
                                <a href="<?= $this->Url->build(['action' => 'edit', $program->id]) ?>" class="p-2 text-gray-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-all" title="Edit"><i class="fas fa-edit"></i></a>
                                <?= $this->Form->postLink('<i class="fas fa-trash"></i>', ['action' => 'delete', $program->id], ['confirm' => __('Delete "{0}"?', $program->name), 'escape' => false, 'class' => 'p-2 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-all', 'title' => 'Delete']) ?>
                            <?php endif; ?>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- How to Join Info Box (Visible on all views now) -->
    <?php if (!$isAdmin): ?>
    <div class="mt-6 bg-gradient-to-r from-purple-50 to-yellow-50 rounded-2xl p-5 border border-purple-100">
        <div class="flex items-start gap-4">
            <div class="w-10 h-10 bg-pmh-purple rounded-xl flex items-center justify-center flex-shrink-0"><i class="fas fa-info-circle text-white"></i></div>
            <div>
                <h4 class="font-bold text-gray-900 mb-1">How to Join?</h4>
                <p class="text-gray-600 text-sm">Click <strong>"Join Now"</strong> to register via Google Form. Programs showing <strong>"Coming Soon"</strong> will have registration available shortly.</p>
            </div>
        </div>
    </div>
    <?php endif; ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
    const programDates = <?= json_encode($programDates) ?>;
    const isAdmin = <?= $isAdmin ? 'true' : 'false' ?>;
    
    function formatLocalDate(date) {
        return `${date.getFullYear()}-${String(date.getMonth()+1).padStart(2,'0')}-${String(date.getDate()).padStart(2,'0')}`;
    }
    
    const calendar = flatpickr("#calendarWidget", {
        inline: true,
        dateFormat: "Y-m-d",
        onDayCreate: function(dObj, dStr, fp, dayElem) {
            const dateStr = formatLocalDate(dayElem.dateObj);
            const programs = programDates[dateStr];
            if (programs && programs.length > 0) {
                const hasComplete = programs.some(p => p.status === 'complete');
                const hasUpcoming = programs.some(p => p.status === 'upcoming');
                dayElem.classList.add(hasComplete && !hasUpcoming ? 'has-program-complete' : 'has-program');
                dayElem.title = programs.map(p => p.name).join(', ');
            }
        },
        onChange: function(selectedDates) {
            if (selectedDates.length > 0) showProgramsForDate(formatLocalDate(selectedDates[0]));
        }
    });

    document.querySelectorAll('.date-link').forEach(el => {
        el.addEventListener('click', function() {
            const dateStr = this.getAttribute('data-date');
            if (dateStr) {
                calendar.setDate(dateStr, true);
                showProgramsForDate(dateStr);
                document.querySelector('.calendar-wrapper').scrollIntoView({ behavior: 'smooth', block: 'center' });
            }
        });
    });

    function showProgramsForDate(dateStr) {
        const programs = programDates[dateStr];
        const container = document.getElementById('selectedDatePrograms');
        const content = document.getElementById('selectedDateContent');
        const title = document.getElementById('selectedDateTitle');
        
        if (programs && programs.length > 0) {
            const parts = dateStr.split('-');
            const date = new Date(parts[0], parts[1]-1, parts[2]);
            title.textContent = date.toLocaleDateString('en-MY', { day: 'numeric', month: 'long', year: 'numeric' });
            
            content.innerHTML = programs.map(p => {
                const statusClass = p.status === 'complete' ? 'bg-green-100 text-green-700' : 'bg-pmh-yellow text-pmh-purple';
                const showJoin = !isAdmin && p.status === 'upcoming';
                const joinBtn = p.google_form_url 
                    ? `<a href="${p.google_form_url}" target="_blank" class="text-xs font-bold bg-pmh-purple text-white px-4 py-2 rounded-lg hover:bg-pmh-purple-dark">Join</a>`
                    : `<span class="text-xs text-gray-400">Coming Soon</span>`;
                
                return `<div class="bg-gray-50 rounded-xl p-4 border border-gray-200">
                    <div class="flex items-start justify-between gap-2 mb-2">
                        <h5 class="font-bold text-gray-900 text-sm">${p.name}</h5>
                        <span class="text-[10px] font-bold px-2 py-1 rounded-lg ${statusClass}">${p.status}</span>
                    </div>
                    <p class="text-xs text-gray-500 mb-2"><i class="fas fa-map-marker-alt text-pmh-yellow mr-1"></i>${p.venue}</p>
                    ${p.description ? `<p class="text-xs text-gray-600 mb-3 line-clamp-2">${p.description}</p>` : ''}
                    <div class="flex gap-2">
                        ${showJoin ? joinBtn : ''}
                        <a href="/mypmh/programs/view/${p.id}" class="text-xs font-bold bg-white border border-gray-200 text-gray-700 px-3 py-2 rounded-lg hover:bg-gray-50">Details</a>
                    </div>
                </div>`;
            }).join('');
            container.classList.remove('hidden');
        } else {
            container.classList.add('hidden');
        }
    }

    const scrollTopBtn = document.getElementById('scrollTopBtn');
    window.addEventListener('scroll', () => {
        scrollTopBtn.classList.toggle('opacity-0', window.pageYOffset <= 300);
        scrollTopBtn.classList.toggle('invisible', window.pageYOffset <= 300);
    });
    function scrollToTop() { window.scrollTo({ top: 0, behavior: 'smooth' }); }
</script>