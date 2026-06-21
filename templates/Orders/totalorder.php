<!-- Header -->
<div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-8">
    <div>
        <h1 class="text-2xl lg:text-3xl font-bold text-gray-900">Order Management</h1>
        <p class="text-gray-500 mt-1">View and manage all merchandise orders</p>
    </div>
</div>

<!-- Summary Cards -->
<div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-8">
    <div class="bg-gradient-to-br from-pmh-purple to-pmh-purple-dark rounded-2xl p-6 text-white relative overflow-hidden">
        <div class="absolute top-0 right-0 w-20 h-20 bg-white/10 rounded-full -translate-y-1/2 translate-x-1/2"></div>
        <p class="text-purple-200 text-sm">Total Orders</p>
        <p class="text-4xl font-bold mt-2"><?= count($orders) ?></p>
    </div>
    <div class="bg-white rounded-2xl p-6 border border-gray-100">
        <p class="text-gray-500 text-sm">Pending</p>
        <p class="text-4xl font-bold text-yellow-600 mt-2"><?= count(array_filter($orders->toArray(), fn($o) => $o->status === 'pending')) ?></p>
    </div>
    <div class="bg-white rounded-2xl p-6 border border-gray-100">
        <p class="text-gray-500 text-sm">Completed</p>
        <p class="text-4xl font-bold text-green-600 mt-2"><?= count(array_filter($orders->toArray(), fn($o) => $o->status === 'complete')) ?></p>
    </div>
</div>

<!-- Mobile Orders View -->
<div class="md:hidden space-y-4 mb-8">
    <?php foreach ($orders as $order): ?>
    <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm">
        <div class="flex justify-between items-start mb-4">
            <div>
                <p class="font-bold text-pmh-purple">#PMH-<?= $order->id ?></p>
                <p class="text-xs text-gray-400"><?= $order->created_at->format('d M Y') ?></p>
            </div>
            <?php 
            $statusClass = 'bg-gray-100 text-gray-600';
            if ($order->status === 'pending') $statusClass = 'bg-yellow-100 text-yellow-700';
            if ($order->status === 'waiting for pickup') $statusClass = 'bg-blue-100 text-blue-700';
            if ($order->status === 'complete') $statusClass = 'bg-green-100 text-green-700';
            ?>
            <span class="inline-flex px-3 py-1.5 rounded-xl text-xs font-bold <?= $statusClass ?>">
                <?= ucfirst($order->status) ?>
            </span>
        </div>
        
        <div class="space-y-3 mb-4">
            <div>
                <p class="text-xs text-gray-400 uppercase font-bold mb-1">Product</p>
                <p class="font-semibold text-gray-900"><?= h($order->product->name) ?></p>
                <p class="text-sm text-gray-400">Size: <?= h($order->size ?: 'N/A') ?> | Qty: <?= $order->quantity ?></p>
            </div>
            <div>
                <p class="text-xs text-gray-400 uppercase font-bold mb-1">Customer</p>
                <p class="font-medium text-gray-900"><?= h($order->user->full_name ?? 'N/A') ?></p>
                <p class="text-sm text-gray-400"><?= h($order->shipping_address) ?></p>
            </div>
        </div>
        
        <div class="pt-4 border-t border-gray-50">
            <p class="text-xs text-gray-400 uppercase font-bold mb-2">Update Status</p>
            <?= $this->Form->create(null, ['url' => ['action' => 'updateStatus', $order->id], 'class' => 'flex gap-3']) ?>
                <select name="status" class="flex-1 text-sm border border-gray-200 rounded-xl px-3 py-2 focus:ring-2 focus:ring-pmh-purple outline-none bg-white">
                    <option value="pending" <?= $order->status == 'pending' ? 'selected' : '' ?>>Pending</option>
                    <option value="waiting for pickup" <?= $order->status == 'waiting for pickup' ? 'selected' : '' ?>>Waiting for Pickup</option>
                    <option value="complete" <?= $order->status == 'complete' ? 'selected' : '' ?>>Complete</option>
                </select>
                <button type="submit" class="bg-gradient-to-r from-pmh-purple to-pmh-purple-dark text-white px-4 py-2 rounded-xl hover:shadow-lg transition-all font-medium text-sm">
                    <i class="fas fa-save"></i>
                </button>
            <?= $this->Form->end() ?>
        </div>
    </div>
    <?php endforeach; ?>
</div>

<!-- Orders Table -->
<div class="hidden md:block bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-100">
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase">Order</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase">Product</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase">Customer</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase">Status</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase">Update</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                <?php foreach ($orders as $order): ?>
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-6 py-5">
                        <p class="font-bold text-pmh-purple">#PMH-<?= $order->id ?></p>
                        <p class="text-sm text-gray-400"><?= $order->created_at->format('d M Y') ?></p>
                    </td>
                    <td class="px-6 py-5">
                        <p class="font-semibold text-gray-900"><?= h($order->product->name) ?></p>
                        <p class="text-sm text-gray-400">Size: <?= h($order->size ?: 'N/A') ?> | Qty: <?= $order->quantity ?></p>
                    </td>
                    <td class="px-6 py-5">
                        <p class="font-medium text-gray-900"><?= h($order->user->full_name ?? 'N/A') ?></p>
                        <p class="text-sm text-gray-400"><?= h($order->shipping_address) ?></p>
                    </td>
                    <td class="px-6 py-5">
                        <?php 
                        $statusClass = 'bg-gray-100 text-gray-600';
                        if ($order->status === 'pending') $statusClass = 'bg-yellow-100 text-yellow-700';
                        if ($order->status === 'waiting for pickup') $statusClass = 'bg-blue-100 text-blue-700';
                        if ($order->status === 'complete') $statusClass = 'bg-green-100 text-green-700';
                        ?>
                        <span class="inline-flex px-3 py-1.5 rounded-xl text-xs font-bold <?= $statusClass ?>">
                            <?= ucfirst($order->status) ?>
                        </span>
                    </td>
                    <td class="px-6 py-5">
                        <?= $this->Form->create(null, ['url' => ['action' => 'updateStatus', $order->id], 'class' => 'flex items-center gap-2']) ?>
                            <select name="status" class="text-sm border border-gray-200 rounded-xl px-3 py-2 focus:ring-2 focus:ring-pmh-purple outline-none bg-white">
                                <option value="pending" <?= $order->status == 'pending' ? 'selected' : '' ?>>Pending</option>
                                <option value="waiting for pickup" <?= $order->status == 'waiting for pickup' ? 'selected' : '' ?>>Waiting for Pickup</option>
                                <option value="complete" <?= $order->status == 'complete' ? 'selected' : '' ?>>Complete</option>
                            </select>
                            <button type="submit" class="bg-gradient-to-r from-pmh-purple to-pmh-purple-dark text-white p-2.5 rounded-xl hover:shadow-lg transition-all">
                                <i class="fas fa-save"></i>
                            </button>
                        <?= $this->Form->end() ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>