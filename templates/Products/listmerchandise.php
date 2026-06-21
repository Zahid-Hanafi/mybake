<!-- Header -->
<div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-8">
    <div>
        <h1 class="text-2xl lg:text-3xl font-bold text-gray-900">Merchandise Store</h1>
        <p class="text-gray-500 mt-1">Shop official PMH merchandise and place your pre-orders</p>
    </div>
    <a href="#my-orders" class="inline-flex items-center gap-2 text-pmh-purple font-semibold hover:underline">
        <i class="fas fa-history"></i> View My Orders
    </a>
</div>

<!-- Filter Section -->
<div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-4 mb-8">
    <div class="flex flex-col md:flex-row items-end gap-4">
        <div class="w-full md:flex-grow">
            <label for="categoryFilter" class="block text-sm font-bold text-gray-700 mb-2">Filter by Category</label>
            <div class="relative">
                <i class="fas fa-filter absolute left-4 top-1/2 -translate-y-1/2 text-pmh-purple"></i>
                <select id="categoryFilter" onchange="filterProducts()" class="w-full pl-12 pr-10 py-3 border border-gray-200 rounded-xl appearance-none focus:ring-2 focus:ring-pmh-purple focus:border-pmh-purple transition-all outline-none bg-white cursor-pointer">
                    <option value="all">Show All Categories</option>
                    <?php 
                    $category_options = ['New Arrival', 'T-Shirt Ivory Edition', 'T-Shirt Raven Edition', 'Tote Bags', 'Badges Ivory Edition', 'Badges Raven Edition'];
                    foreach ($category_options as $opt): ?>
                        <option value="<?= h($opt) ?>"><?= h($opt) ?></option>
                    <?php endforeach; ?>
                </select>
                <i class="fas fa-chevron-down absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none"></i>
            </div>
        </div>
        <button onclick="resetFilter()" class="w-full md:w-auto px-6 py-3 bg-gray-100 text-gray-600 font-bold rounded-xl hover:bg-gray-200 transition-colors">
            <i class="fas fa-undo mr-2"></i> Reset
        </button>
    </div>
</div>

<?php 
$category_list = ['New Arrival', 'T-Shirt Ivory Edition', 'T-Shirt Raven Edition', 'Tote Bags', 'Badges Ivory Edition', 'Badges Raven Edition'];
foreach ($category_list as $current_cat): 
?>
<div class="mb-12 category-section transition-all duration-300" data-category="<?= h($current_cat) ?>">
    <div class="flex items-center gap-3 mb-6">
        <div class="w-2 h-8 bg-gradient-to-b from-pmh-purple to-pmh-purple-dark rounded-full"></div>
        <h2 class="text-xl font-bold text-gray-900"><?= $current_cat ?></h2>
    </div>
    
    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-4">
        <?php foreach ($products as $product): ?>
            <?php if (trim($product->category) === $current_cat): ?>
            <!-- Product Card -->
            <div class="group bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden hover:shadow-xl hover:border-pmh-purple/30 transition-all flex flex-col h-full">
                <div class="aspect-square bg-gradient-to-br from-gray-50 to-gray-100 flex items-center justify-center p-4 relative overflow-hidden">
                    <?= $this->Html->image('products/' . h($product->image), ['class' => 'max-h-full max-w-full object-contain group-hover:scale-110 transition-transform duration-300']) ?>
                    <?php if ($product->status === 'closed'): ?>
                        <div class="absolute inset-0 bg-black/40 flex items-center justify-center">
                            <span class="bg-red-500 text-white font-bold px-4 py-2 rounded-lg text-sm shadow-lg rotate-12">
                                Unavailable
                            </span>
                        </div>
                    <?php else: ?>
                        <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity flex items-end justify-center pb-4">
                            <button onclick="openOrderModal('<?= $product->id ?>', '<?= h(addslashes($product->name)) ?>', '<?= $product->price ?>')" 
                                class="bg-pmh-yellow text-pmh-purple font-bold px-4 py-2 rounded-lg text-sm hover:bg-white transition-colors shadow-lg">
                                Quick Order
                            </button>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="p-4 flex flex-col flex-grow">
                    <h3 class="font-semibold text-gray-900 text-sm mb-1 line-clamp-2 min-h-[40px]"><?= h($product->name) ?></h3>
                    <div class="flex items-center justify-between mt-auto pt-2">
                        <p class="text-pmh-purple font-bold text-lg">RM <?= number_format($product->price, 2) ?></p>
                        
                        <div class="flex items-center gap-2">
                            <!-- Admin Edit Status Button -->
                            <?php if (isset($isAdmin) && $isAdmin): ?>
                                <button onclick="openStatusModal('<?= $product->id ?>', '<?= h($product->status ?? 'open') ?>')" 
                                    class="w-10 h-10 bg-gray-100 rounded-xl flex items-center justify-center text-gray-600 hover:bg-gray-200 transition-all shadow-sm" title="Edit Status">
                                    <i class="fas fa-pencil-alt"></i>
                                </button>
                            <?php endif; ?>

                            <?php if (!isset($isAdmin) || !$isAdmin): ?>
                                <?php if ($product->status === 'closed'): ?>
                                    <button disabled class="w-10 h-10 bg-gray-100 rounded-xl flex items-center justify-center text-gray-400 cursor-not-allowed" title="Unavailable">
                                        <i class="fas fa-ban"></i>
                                    </button>
                                <?php else: ?>
                                    <button onclick="openOrderModal('<?= $product->id ?>', '<?= h(addslashes($product->name)) ?>', '<?= $product->price ?>')" 
                                        class="w-10 h-10 bg-purple-50 rounded-xl flex items-center justify-center text-pmh-purple hover:bg-pmh-purple hover:text-white transition-all shadow-sm">
                                        <i class="fas fa-cart-plus"></i>
                                    </button>
                                <?php endif; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php endif; ?>
        <?php endforeach; ?>
    </div>
</div>
<?php endforeach; ?>

<!-- My OrdersHeader -->
<div id="my-orders" class="pt-8 scroll-mt-24">
    <div class="flex items-center gap-3 mb-6">
        <div class="w-2 h-8 bg-gradient-to-b from-pmh-yellow to-yellow-400 rounded-full"></div>
        <h2 class="text-xl font-bold text-gray-900">My Purchase History</h2>
    </div>
    
    <!-- Mobile Cards (Enhanced with Actions) -->
    <div class="space-y-4 lg:hidden">
        <?php if ($myOrders->isEmpty()): ?>
            <div class="bg-white rounded-2xl border border-gray-100 p-10 text-center">
                <i class="fas fa-shopping-bag text-4xl text-gray-200 mb-4"></i>
                <p class="text-gray-400">No orders yet</p>
            </div>
        <?php else: ?>
            <?php foreach ($myOrders as $order): ?>
            <div class="bg-white rounded-2xl border border-gray-100 p-5 shadow-sm relative overflow-hidden">
                <!-- Status Badge Absolute Top Right -->
                <?php 
                $statusClass = 'bg-gray-100 text-gray-600';
                if ($order->status === 'pending') $statusClass = 'bg-yellow-100 text-yellow-700';
                if ($order->status === 'complete') $statusClass = 'bg-green-100 text-green-700';
                ?>
                <div class="flex justify-between items-start mb-3">
                    <h4 class="font-bold text-gray-900 pr-16 leading-tight"><?= h($order->product->name) ?></h4>
                    <span class="absolute top-5 right-5 text-[10px] font-bold px-2 py-1 rounded-lg <?= $statusClass ?>"><?= ucfirst($order->status) ?></span>
                </div>
                
                <div class="flex items-center justify-between text-sm text-gray-500 mb-4 bg-gray-50 p-3 rounded-xl">
                    <div class="flex flex-col">
                        <span class="text-xs text-gray-400 uppercase tracking-wider">Size</span>
                        <span class="font-bold text-gray-700"><?= h($order->size ?: '-') ?></span>
                    </div>
                    <div class="flex flex-col text-center">
                        <span class="text-xs text-gray-400 uppercase tracking-wider">Qty</span>
                        <span class="font-bold text-gray-700"><?= $order->quantity ?></span>
                    </div>
                    <div class="flex flex-col text-right">
                        <span class="text-xs text-gray-400 uppercase tracking-wider">Total</span>
                        <span class="font-bold text-pmh-purple">RM <?= number_format((float)$order->total_price, 2) ?></span>
                    </div>
                </div>

                <!-- Actions Grid -->
                <div class="grid grid-cols-2 gap-3">
                    <a href="<?= $this->Url->build(['controller' => 'Orders', 'action' => 'viewReceipt', $order->id]) ?>" target="_blank" 
                       class="flex items-center justify-center gap-2 py-2.5 rounded-xl bg-purple-50 text-pmh-purple font-bold text-sm hover:bg-pmh-purple hover:text-white transition-all">
                        <i class="fas fa-file-pdf"></i> Receipt
                    </a>
                    <?= $this->Form->postLink('<i class="fas fa-trash-alt mr-2"></i> Cancel', 
                        ['controller' => 'Orders', 'action' => 'delete', $order->id], 
                        ['escape' => false, 'confirm' => __('Cancel order?'), 'class' => 'flex items-center justify-center gap-2 py-2.5 rounded-xl bg-red-50 text-red-500 font-bold text-sm hover:bg-red-500 hover:text-white transition-all']) 
                    ?>
                </div>
            </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <!-- Desktop Table -->
    <div class="hidden lg:block bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <table class="w-full">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-100">
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase">Product</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase">Size</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase">Qty</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase">Total</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase">Status</th>
                    <th class="px-6 py-4 text-center text-xs font-bold text-gray-500 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                <?php if ($myOrders->isEmpty()): ?>
                    <tr><td colspan="6" class="px-6 py-12 text-center text-gray-400"><i class="fas fa-shopping-bag text-4xl mb-3 block"></i> No orders yet</td></tr>
                <?php else: ?>
                    <?php foreach ($myOrders as $order): ?>
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-5 font-semibold text-gray-900"><?= h($order->product->name) ?></td>
                        <td class="px-6 py-5 text-gray-500"><?= h($order->size ?: '-') ?></td>
                        <td class="px-6 py-5 text-gray-500"><?= $order->quantity ?></td>
                        <td class="px-6 py-5 font-bold text-gray-900">RM <?= number_format((float)$order->total_price, 2) ?></td>
                        <td class="px-6 py-5">
                            <?php 
                            $statusClass = 'bg-gray-100 text-gray-600';
                            if ($order->status === 'pending') $statusClass = 'bg-yellow-100 text-yellow-700';
                            if ($order->status === 'complete') $statusClass = 'bg-green-100 text-green-700';
                            ?>
                            <span class="inline-flex px-3 py-1.5 rounded-xl text-xs font-bold <?= $statusClass ?>"><?= ucfirst($order->status) ?></span>
                        </td>
                        <td class="px-6 py-5">
                            <div class="flex items-center justify-center gap-4">
                                <a href="<?= $this->Url->build(['controller' => 'Orders', 'action' => 'viewReceipt', $order->id]) ?>" target="_blank" class="text-pmh-purple hover:text-pmh-purple-dark" title="Receipt"><i class="fas fa-file-pdf"></i></a>
                                <?= $this->Form->postLink('<i class="fas fa-trash"></i>', ['controller' => 'Orders', 'action' => 'delete', $order->id], ['escape' => false, 'confirm' => __('Cancel order?'), 'class' => 'text-red-500 hover:text-red-700']) ?>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Order Modal -->
<div id="orderModal" class="fixed inset-0 bg-black/60 backdrop-blur-sm hidden items-center justify-center z-50 p-4">
    <div class="bg-white rounded-3xl shadow-2xl max-w-md w-full overflow-hidden transform scale-95 opacity-0 transition-all" id="modalContent">
        <div class="bg-gradient-to-r from-pmh-purple to-pmh-purple-dark p-6 text-white">
            <div class="flex justify-between items-center">
                <h3 class="text-xl font-bold" id="modalProductName">Product</h3>
                <button onclick="closeOrderModal()" class="w-8 h-8 bg-white/20 rounded-lg flex items-center justify-center hover:bg-white/30 transition-colors">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
        <?= $this->Form->create(null, ['url' => ['controller' => 'Orders', 'action' => 'add'], 'class' => 'p-6 space-y-5']) ?>
            <?= $this->Form->hidden('product_id', ['id' => 'modalProductId']) ?>
            <?= $this->Form->hidden('total_price', ['id' => 'hiddenTotalPrice']) ?>
            <input type="hidden" id="basePrice" value="0">
            
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Pickup Location</label>
                <?= $this->Form->select('shipping_address', ['Self-Pickup at Kolej Jasmine'=>'Self-Pickup at Kolej Jasmine'], ['class' => 'w-full px-4 py-3 border border-gray-200 rounded-xl bg-gray-50']) ?>
            </div>
            
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Size</label>
                    <?= $this->Form->select('size', ['XS'=>'XS','S'=>'S','M'=>'M','L'=>'L','XL'=>'XL','2XL'=>'2XL','N/A'=>'N/A'], ['class' => 'w-full px-4 py-3 border border-gray-200 rounded-xl', 'default' => 'M']) ?>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Quantity</label>
                    <?= $this->Form->number('quantity', ['id' => 'modalQuantity', 'value' => 1, 'min' => 1, 'onchange' => 'calculateTotal()', 'class' => 'w-full px-4 py-3 border border-gray-200 rounded-xl font-bold text-center']) ?>
                </div>
            </div>
            
            <div class="bg-gradient-to-r from-purple-50 to-yellow-50 p-5 rounded-xl text-center border border-purple-100">
                <p class="text-sm text-gray-500 mb-1">Total Amount</p>
                <p class="text-3xl font-bold text-pmh-purple">RM <span id="displayTotal">0.00</span></p>
            </div>
            
            <button type="submit" class="w-full bg-gradient-to-r from-pmh-purple to-pmh-purple-dark text-white font-bold py-4 rounded-xl hover:shadow-lg transition-all">
                Confirm Pre-Order
            </button>
        <?= $this->Form->end() ?>
    </div>
</div>

<!-- Scroll to Top Button -->
<button id="scrollTopBtn" onclick="scrollToTop()" class="fixed bottom-6 right-6 w-12 h-12 bg-pmh-purple text-white rounded-full shadow-lg hover:bg-pmh-purple-dark transition-all opacity-0 invisible z-40 flex items-center justify-center">
    <i class="fas fa-arrow-up"></i>
</button>

<!-- Edit Status Modal -->
<div id="statusModal" class="fixed inset-0 bg-black/60 backdrop-blur-sm hidden items-center justify-center z-50 p-4">
    <div class="bg-white rounded-3xl shadow-2xl max-w-sm w-full overflow-hidden transform scale-95 opacity-0 transition-all" id="statusModalContent">
        <div class="bg-gray-50 border-b border-gray-100 p-5">
            <h3 class="text-lg font-bold text-gray-800">Edit Product Status</h3>
        </div>
        <?= $this->Form->create(null, ['url' => ['controller' => 'Products', 'action' => 'updateStatus'], 'id' => 'statusForm', 'class' => 'p-6']) ?>
            <input type="hidden" name="id" id="statusProductId">
            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Availability Status</label>
                <select name="status" id="statusSelect" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-pmh-purple outline-none">
                    <option value="open">Open (Available)</option>
                    <option value="closed">Closed (Unavailable)</option>
                </select>
            </div>
            
            <div class="flex gap-3">
                <button type="button" onclick="closeStatusModal()" class="flex-1 px-4 py-3 bg-gray-100 text-gray-600 font-bold rounded-xl hover:bg-gray-200 transition-all">Cancel</button>
                <button type="button" onclick="openConfirmModal()" class="flex-1 px-4 py-3 bg-pmh-purple text-white font-bold rounded-xl hover:bg-pmh-purple-dark transition-all">Change Now</button>
            </div>
        <?= $this->Form->end() ?>
    </div>
</div>

<!-- Confirmation Modal -->
<div id="confirmModal" class="fixed inset-0 bg-black/60 backdrop-blur-sm hidden items-center justify-center z-[60] p-4">
    <div class="bg-white rounded-3xl shadow-2xl max-w-sm w-full p-6 text-center transform scale-95 opacity-0 transition-all" id="confirmModalContent">
        <div class="w-16 h-16 bg-yellow-100 text-yellow-600 rounded-full flex items-center justify-center mx-auto mb-4 text-2xl">
            <i class="fas fa-exclamation-triangle"></i>
        </div>
        <h3 class="text-xl font-bold text-gray-900 mb-2">Are you sure?</h3>
        <p class="text-gray-500 mb-6">You are about to change the status of this product. Users may not be able to order it if it is closed.</p>
        
        <div class="flex gap-3">
            <button onclick="closeConfirmModal()" class="flex-1 px-4 py-3 bg-gray-100 text-gray-600 font-bold rounded-xl hover:bg-gray-200 transition-all">Cancel</button>
            <button onclick="submitStatusForm()" class="flex-1 px-4 py-3 bg-pmh-purple text-white font-bold rounded-xl hover:bg-pmh-purple-dark transition-all">Yes, Change It</button>
        </div>
    </div>
</div>

<script>
// Status Modal Logic
function openStatusModal(id, currentStatus) {
    document.getElementById('statusProductId').value = id;
    document.getElementById('statusSelect').value = currentStatus;
    
    document.getElementById('statusModal').classList.remove('hidden');
    document.getElementById('statusModal').classList.add('flex');
    setTimeout(() => {
        document.getElementById('statusModalContent').classList.remove('scale-95', 'opacity-0');
        document.getElementById('statusModalContent').classList.add('scale-100', 'opacity-100');
    }, 10);
}

function closeStatusModal() {
    document.getElementById('statusModalContent').classList.add('scale-95', 'opacity-0');
    setTimeout(() => {
        document.getElementById('statusModal').classList.add('hidden');
        document.getElementById('statusModal').classList.remove('flex');
    }, 200);
}

function openConfirmModal() {
    document.getElementById('confirmModal').classList.remove('hidden');
    document.getElementById('confirmModal').classList.add('flex');
    setTimeout(() => {
        document.getElementById('confirmModalContent').classList.remove('scale-95', 'opacity-0');
        document.getElementById('confirmModalContent').classList.add('scale-100', 'opacity-100');
    }, 10);
}

function closeConfirmModal() {
    document.getElementById('confirmModalContent').classList.add('scale-95', 'opacity-0');
    setTimeout(() => {
        document.getElementById('confirmModal').classList.add('hidden');
        document.getElementById('confirmModal').classList.remove('flex');
    }, 200);
}

function submitStatusForm() {
    document.getElementById('statusForm').submit();
}

// Filter Logic
function filterProducts() {
    const selected = document.getElementById('categoryFilter').value;
    const sections = document.querySelectorAll('.category-section');
    
    sections.forEach(section => {
        if (selected === 'all' || section.getAttribute('data-category') === selected) {
            section.classList.remove('hidden');
            section.classList.add('block');
        } else {
            section.classList.add('hidden');
            section.classList.remove('block');
        }
    });
}

function resetFilter() {
    document.getElementById('categoryFilter').value = 'all';
    filterProducts();
}

// Order Modal Logic
function openOrderModal(id, name, price) {
    document.getElementById('modalProductId').value = id;
    document.getElementById('modalProductName').innerText = name;
    document.getElementById('basePrice').value = price;
    document.getElementById('orderModal').classList.remove('hidden');
    document.getElementById('orderModal').classList.add('flex');
    setTimeout(() => {
        document.getElementById('modalContent').classList.remove('scale-95', 'opacity-0');
        document.getElementById('modalContent').classList.add('scale-100', 'opacity-100');
    }, 10);
    calculateTotal();
}

function calculateTotal() {
    const price = parseFloat(document.getElementById('basePrice').value);
    const qty = parseInt(document.getElementById('modalQuantity').value) || 1;
    const total = (price * qty).toFixed(2);
    document.getElementById('displayTotal').innerText = total;
    document.getElementById('hiddenTotalPrice').value = total;
}

function closeOrderModal() { 
    document.getElementById('modalContent').classList.add('scale-95', 'opacity-0');
    setTimeout(() => {
        document.getElementById('orderModal').classList.add('hidden');
        document.getElementById('orderModal').classList.remove('flex');
    }, 200);
}

// Scroll To Top
const scrollTopBtn = document.getElementById('scrollTopBtn');
window.addEventListener('scroll', () => {
    if (window.pageYOffset > 300) {
        scrollTopBtn.classList.remove('opacity-0', 'invisible');
    } else {
        scrollTopBtn.classList.add('opacity-0', 'invisible');
    }
});
function scrollToTop() {
    window.scrollTo({ top: 0, behavior: 'smooth' });
}
</script>