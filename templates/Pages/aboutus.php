<!-- Header -->
<div class="mb-8">
    <h1 class="text-2xl lg:text-3xl font-bold text-gray-900">About Us</h1>
    <p class="text-gray-500 mt-1">Learn more about Persatuan Mahasiswa Hadhari</p>
</div>

<!-- Hero -->
<div class="bg-gradient-to-r from-pmh-purple via-pmh-purple-dark to-pmh-purple rounded-2xl p-8 lg:p-12 mb-8 relative overflow-hidden">
    <div class="absolute top-0 right-0 w-96 h-96 bg-pmh-yellow opacity-10 rounded-full -translate-y-1/2 translate-x-1/2"></div>
    <div class="absolute bottom-0 left-0 w-64 h-64 bg-white opacity-5 rounded-full translate-y-1/2 -translate-x-1/2"></div>
    <div class="absolute right-10 bottom-10 opacity-10 hidden lg:block">
        <i class="fas fa-users text-[200px] text-white"></i>
    </div>
    
    <div class="relative z-10 max-w-2xl">
        <span class="inline-flex items-center gap-2 bg-pmh-yellow text-pmh-purple text-xs font-bold px-4 py-1.5 rounded-full mb-4">
            <i class="fas fa-star"></i> SINCE 2020
        </span>
        <h2 class="text-3xl lg:text-4xl font-bold text-white mb-4">Persatuan Mahasiswa Hadhari</h2>
        <p class="text-purple-200 text-lg leading-relaxed">
            Nurturing Excellence, Heritage, and Integrity among UiTM Students at Puncak Perdana Campus.
        </p>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
    <!-- Our Story -->
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 lg:p-8">
        <div class="flex items-center gap-3 mb-4">
            <div class="w-12 h-12 bg-gradient-to-br from-pmh-purple to-pmh-purple-dark rounded-xl flex items-center justify-center shadow-lg shadow-purple-200">
                <i class="fas fa-book-open text-white"></i>
            </div>
            <h3 class="text-xl font-bold text-gray-900">Our Story</h3>
        </div>
        <p class="text-gray-600 leading-relaxed mb-4">
            Persatuan Mahasiswa Hadhari (PMH) was established at UiTM Puncak Perdana to bridge the gap between academic excellence and spiritual heritage.
        </p>
        <p class="text-gray-600 leading-relaxed mb-6">
            We focus on organizing programs that empower students with leadership skills while maintaining the core values of Hadhari philosophy - promoting knowledge, wisdom, and integrity.
        </p>
        <div class="bg-gradient-to-r from-purple-50 to-yellow-50 p-4 rounded-xl border border-purple-100">
            <p class="text-sm font-semibold text-gray-700 mb-2">📥 Download Profile</p>
            <a href="<?= $this->Url->build('/img/uitm.pdf') ?>" target="_blank" class="inline-flex items-center gap-2 text-pmh-purple font-semibold hover:underline">
                <i class="fas fa-file-pdf"></i> PMH Official Profile 2025.pdf
            </a>
        </div>
    </div>

    <!-- Testimonials -->
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 lg:p-8">
        <div class="flex items-center gap-3 mb-6">
            <div class="w-12 h-12 bg-gradient-to-br from-pmh-yellow to-yellow-400 rounded-xl flex items-center justify-center shadow-lg shadow-yellow-200">
                <i class="fas fa-quote-left text-pmh-purple"></i>
            </div>
            <h3 class="text-xl font-bold text-gray-900">What Students Say</h3>
        </div>
        
        <div class="space-y-4">
            <div class="bg-gray-50 p-5 rounded-xl border border-gray-100">
                <p class="text-gray-600 italic mb-3">"Joining PMH was the best decision of my university life. The community is supportive and the programs are very impactful!"</p>
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-pmh-purple rounded-full flex items-center justify-center text-white font-bold">A</div>
                    <div>
                        <p class="font-semibold text-gray-900">Ahmad Zaki</p>
                        <p class="text-sm text-gray-400">Semester 4</p>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 p-5 rounded-xl border border-gray-100">
                <p class="text-gray-600 italic mb-3">"I love the merchandise! The quality is amazing and it feels great to represent the association."</p>
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-pmh-yellow rounded-full flex items-center justify-center text-pmh-purple font-bold">S</div>
                    <div>
                        <p class="font-semibold text-gray-900">Siti Sarah</p>
                        <p class="text-sm text-gray-400">Semester 2</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- CTA -->
<div class="bg-gradient-to-r from-pmh-yellow via-yellow-400 to-pmh-yellow rounded-2xl p-8 lg:p-10 text-center relative overflow-hidden">
    <div class="absolute inset-0 opacity-10">
        <div class="absolute top-0 left-0 w-32 h-32 bg-pmh-purple rounded-full -translate-x-1/2 -translate-y-1/2"></div>
        <div class="absolute bottom-0 right-0 w-48 h-48 bg-pmh-purple rounded-full translate-x-1/2 translate-y-1/2"></div>
    </div>
    <div class="relative z-10">
        <h3 class="text-2xl lg:text-3xl font-bold text-pmh-purple mb-3">Ready to Join Our Family?</h3>
        <p class="text-pmh-purple/70 mb-6 max-w-md mx-auto">Be part of the change and develop your potential with us.</p>
        <a href="<?= $this->Url->build(['controller' => 'Applications', 'action' => 'joinus']) ?>" class="inline-flex items-center gap-2 bg-pmh-purple text-white px-8 py-4 rounded-xl font-bold hover:bg-pmh-purple-dark transition-all shadow-lg hover:shadow-xl">
            <i class="fas fa-user-plus"></i> Join PMH Now
        </a>
    </div>
</div>