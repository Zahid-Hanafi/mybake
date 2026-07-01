<?php $this->assign('title', 'Stock Management'); ?>

<div style="margin-bottom:1.5rem; display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:1rem;">
    <div>
        <h1 style="font-size:1.25rem; font-weight:700;">Stock & Products</h1>
        <p style="color:var(--text-muted); font-size:0.875rem;">Manage product availability and stock levels.</p>
    </div>
</div>

<?= $this->Flash->render() ?>

<div style="background:#fff; border-radius:20px; border:1px solid var(--border-light); overflow:hidden; box-shadow:var(--shadow-sm);">
    <div style="padding:1.25rem 1.5rem; border-bottom:1px solid var(--border-light); font-weight:700; display:flex; align-items:center; gap:0.6rem;">
        <i class="fas fa-boxes-stacked" style="color:#7C3AED;"></i> Product Inventory
    </div>
    
    <div class="table-wrapper" style="border-radius:0; border:none;">
        <table>
            <thead>
                <tr>
                    <th>Image</th>
                    <th>Product Name</th>
                    <th>Category</th>
                    <th>Price</th>
                    <th>Stock</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($products as $product): ?>
                <?php
                $stockLevel = $product->stock_quantity > 50 ? 'high' : ($product->stock_quantity > 10 ? 'medium' : ($product->stock_quantity > 0 ? 'low' : 'out'));
                $stockClass = ['high'=>'stock-high','medium'=>'stock-medium','low'=>'stock-low','out'=>'stock-out'][$stockLevel];
                ?>
                <tr id="row-<?= $product->id ?>">
                    <td>
                        <img src="<?= $this->Url->build('/img/products/<?= h($product->image ?? 'default.jpg') ?>') ?>" 
                             onerror="this.src='https://placehold.co/40x40/E8F7F7/1A7A7A?text=MB'"
                             style="width:40px; height:40px; border-radius:8px; object-fit:cover;">
                    </td>
                    <td style="font-weight:600; font-size:0.875rem;">
                        <?= h($product->name) ?>
                        <?php if ($product->is_new_arrival): ?><span class="product-badge new" style="font-size:0.6rem; padding:0.1rem 0.3rem;">New</span><?php endif; ?>
                        <?php if ($product->is_best_seller): ?><span class="product-badge" style="font-size:0.6rem; padding:0.1rem 0.3rem;">Best</span><?php endif; ?>
                    </td>
                    <td style="color:var(--text-muted); font-size:0.85rem;"><?= h($product->product_line->name ?? '—') ?></td>
                    <td style="font-weight:600;">RM <?= number_format($product->price, 2) ?></td>
                    <td>
                        <span class="product-stock <?= $stockClass ?>" id="stock-<?= $product->id ?>"><?= $product->stock_quantity ?> pcs</span>
                    </td>
                    <td>
                        <span class="status-badge status-<?= $product->status ?>" id="statusBadge-<?= $product->id ?>">
                            <?= ucfirst($product->status) ?>
                        </span>
                    </td>
                    <td>
                        <div style="display:flex; gap:0.5rem; align-items:center;">
                            <button onclick="openRestockModal(<?= $product->id ?>, '<?= h(addslashes($product->name)) ?>')" 
                                    class="btn btn-outline btn-sm" title="Restock">
                                <i class="fas fa-plus"></i> Restock
                            </button>
                            <button onclick="toggleProductStatus(<?= $product->id ?>, this)" 
                                    class="btn btn-sm <?= $product->status === 'open' ? 'btn-danger' : '' ?>" 
                                    style="<?= $product->status !== 'open' ? 'background:var(--primary-teal); color:#fff;' : '' ?>"
                                    title="<?= $product->status === 'open' ? 'Close' : 'Open' ?> product">
                                <i class="fas fa-<?= $product->status === 'open' ? 'lock' : 'lock-open' ?>"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Restock Modal -->
<div class="modal-overlay" id="restockModal">
    <div class="modal" style="max-width:380px;">
        <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:1.25rem;">
            <h3 style="font-family:'Playfair Display',serif; font-size:1.2rem;">Restock Product</h3>
            <button onclick="document.getElementById('restockModal').classList.remove('open')" style="background:none; border:none; cursor:pointer; color:var(--text-muted);">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <p style="color:var(--text-muted); font-size:0.875rem; margin-bottom:1.25rem;" id="restockProductName">—</p>
        <div class="form-group">
            <label class="form-label">Add Quantity</label>
            <input type="number" id="restockQty" min="1" value="10" class="form-control" placeholder="Enter quantity to add">
        </div>
        <button onclick="confirmRestock()" class="btn btn-primary btn-full">
            <i class="fas fa-plus"></i> Add Stock
        </button>
    </div>
</div>

<script>
let _restockId = null;
function openRestockModal(id, name) {
    _restockId = id;
    document.getElementById('restockProductName').textContent = 'Product: ' + name;
    document.getElementById('restockQty').value = 10;
    document.getElementById('restockModal').classList.add('open');
}
function confirmRestock() {
    const qty = parseInt(document.getElementById('restockQty').value);
    if (!qty || qty < 1) return;
    const form = new FormData();
    form.append('quantity', qty);
    fetch('<?= $this->Url->build('/admin/stock/restock/') ?>' + _restockId, { method: 'POST', body: form })
        .then(r => r.json())
        .then(d => {
            if (d.success) {
                const el = document.getElementById('stock-' + _restockId);
                if (el) el.textContent = d.stock + ' pcs';
                document.getElementById('restockModal').classList.remove('open');
                showFlash('success', 'Stock updated to ' + d.stock + ' pcs');
                
                // Update class based on stock
                el.className = 'product-stock ' + (d.stock > 50 ? 'stock-high' : (d.stock > 10 ? 'stock-medium' : (d.stock > 0 ? 'stock-low' : 'stock-out')));
            }
        });
}
function toggleProductStatus(id, btn) {
    fetch('<?= $this->Url->build('/admin/stock/toggle/') ?>' + id, { method: 'POST' })
        .then(r => r.json())
        .then(d => {
            if (d.success) {
                const badge = document.getElementById('statusBadge-' + id);
                if (d.status === 'open') {
                    badge.className = 'status-badge status-open'; badge.textContent = 'Open';
                    btn.innerHTML = '<i class="fas fa-lock"></i>';
                    btn.className = 'btn btn-sm btn-danger';
                } else {
                    badge.className = 'status-badge status-closed'; badge.textContent = 'Closed';
                    btn.innerHTML = '<i class="fas fa-lock-open"></i>';
                    btn.style.cssText = 'background:var(--primary-teal); color:#fff;';
                }
                showFlash('success', 'Status updated successfully.');
            }
        });
}
document.getElementById('restockModal').addEventListener('click', function(e) {
    if (e.target === this) this.classList.remove('open');
});
</script>
