<?php $this->assign('title', 'Add Offline Sale'); ?>

<div style="max-width:800px;">
<div style="margin-bottom:1.5rem;">
    <a href="/admin/sales" style="color:var(--text-muted); font-size:0.875rem; display:inline-flex; align-items:center; gap:0.4rem; margin-bottom:0.75rem;">
        <i class="fas fa-arrow-left"></i> Back to Sales
    </a>
    <h1 style="font-size:1.25rem; font-weight:700;">Record Offline Sale</h1>
    <p style="color:var(--text-muted); font-size:0.875rem;">Record daily in-store sales. Only today and future dates are allowed.</p>
</div>

<?= $this->Flash->render() ?>

<div style="background:#fff; border-radius:20px; border:1px solid var(--border-light); padding:2rem; box-shadow:var(--shadow-sm);">
    <?= $this->Form->create($sale, ['url' => ['controller' => 'Sales', 'action' => 'add'], 'id' => 'saleForm']) ?>

    <!-- Sale Date -->
    <div class="form-group">
        <label class="form-label">Sale Date <span style="color:#DC2626;">*</span></label>
        <input type="date" name="sale_date" class="form-control" required
               value="<?= date('Y-m-d') ?>"
               min="<?= date('Y-m-d') ?>">
        <p class="form-hint"><i class="fas fa-info-circle"></i> Only today and future dates are allowed.</p>
    </div>

    <!-- Product Items -->
    <div style="margin-bottom:1.5rem;">
        <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:0.75rem;">
            <label class="form-label" style="margin:0;">Products Sold <span style="color:#DC2626;">*</span></label>
            <button type="button" onclick="addProductRow()" class="btn btn-outline btn-sm">
                <i class="fas fa-plus"></i> Add Product
            </button>
        </div>

        <div id="productRows">
            <!-- Row 1 -->
            <div class="product-row" style="display:grid; grid-template-columns:1fr 100px 100px auto; gap:0.75rem; align-items:center; margin-bottom:0.75rem; background:var(--bg-light); padding:0.875rem; border-radius:12px; border:1px solid var(--border-light);">
                <div>
                    <select name="items[0][product_id]" class="form-control product-select" required onchange="updatePrice(this, 0)">
                        <option value="">— Select Product —</option>
                        <?php foreach ($products as $p): ?>
                        <option value="<?= $p->id ?>" data-price="<?= $p->price ?>">
                            <?= h($p->name) ?> (RM <?= number_format($p->price, 2) ?>)
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div>
                    <input type="number" name="items[0][quantity]" class="form-control qty-input" min="1" value="1" placeholder="Qty" oninput="recalcTotal()">
                </div>
                <div>
                    <input type="text" class="form-control price-display" readonly placeholder="RM 0.00" style="background:var(--bg-light);">
                </div>
                <button type="button" onclick="removeRow(this)" style="background:#FFF1F2; color:#DC2626; border:none; width:36px; height:36px; border-radius:10px; cursor:pointer; display:flex; align-items:center; justify-content:center; font-size:0.875rem;">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
        </div>

        <!-- Total Preview -->
        <div style="background:linear-gradient(135deg,var(--primary-teal-dark),var(--primary-teal)); border-radius:12px; padding:1rem 1.25rem; display:flex; align-items:center; justify-content:space-between; color:#fff;">
            <span style="font-weight:600;">Total Amount</span>
            <span style="font-family:'Playfair Display',serif; font-size:1.4rem; font-weight:700;" id="grandTotal">RM 0.00</span>
        </div>
    </div>

    <!-- Notes -->
    <div class="form-group">
        <label class="form-label">Notes <span style="color:var(--text-muted); font-weight:400;">(optional)</span></label>
        <textarea name="notes" rows="3" class="form-control" placeholder="Any additional notes for this sale..."></textarea>
    </div>

    <div style="display:grid; grid-template-columns:1fr 1fr; gap:1rem;">
        <a href="/admin/sales" class="btn btn-outline"><i class="fas fa-times"></i> Cancel</a>
        <button type="submit" class="btn btn-gold"><i class="fas fa-save"></i> Record Sale</button>
    </div>

    <?= $this->Form->end() ?>
</div>
</div>

<script>
const products = <?= json_encode(array_map(fn($p) => ['id' => $p->id, 'name' => $p->name, 'price' => $p->price], iterator_to_array($products))) ?>;
let rowIndex = 1;

function addProductRow() {
    const container = document.getElementById('productRows');
    const row = document.createElement('div');
    row.className = 'product-row';
    row.style.cssText = 'display:grid; grid-template-columns:1fr 100px 100px auto; gap:0.75rem; align-items:center; margin-bottom:0.75rem; background:var(--bg-light); padding:0.875rem; border-radius:12px; border:1px solid var(--border-light);';
    row.innerHTML = `
        <div>
            <select name="items[${rowIndex}][product_id]" class="form-control product-select" required onchange="updatePrice(this, ${rowIndex})">
                <option value="">— Select Product —</option>
                ${products.map(p => `<option value="${p.id}" data-price="${p.price}">${p.name} (RM ${parseFloat(p.price).toFixed(2)})</option>`).join('')}
            </select>
        </div>
        <div><input type="number" name="items[${rowIndex}][quantity]" class="form-control qty-input" min="1" value="1" placeholder="Qty" oninput="recalcTotal()"></div>
        <div><input type="text" class="form-control price-display" readonly placeholder="RM 0.00" style="background:var(--bg-light);"></div>
        <button type="button" onclick="removeRow(this)" style="background:#FFF1F2; color:#DC2626; border:none; width:36px; height:36px; border-radius:10px; cursor:pointer; display:flex; align-items:center; justify-content:center;">
            <i class="fas fa-trash"></i>
        </button>`;
    container.appendChild(row);
    rowIndex++;
}

function updatePrice(selectEl, idx) {
    const opt = selectEl.options[selectEl.selectedIndex];
    const price = parseFloat(opt.dataset.price || 0);
    const row   = selectEl.closest('.product-row');
    const qty   = parseInt(row.querySelector('.qty-input').value) || 1;
    row.querySelector('.price-display').value = 'RM ' + (price * qty).toFixed(2);
    recalcTotal();
}

function removeRow(btn) {
    const rows = document.querySelectorAll('.product-row');
    if (rows.length <= 1) { showFlash('error', 'At least one product is required.'); return; }
    btn.closest('.product-row').remove();
    recalcTotal();
}

function recalcTotal() {
    let total = 0;
    document.querySelectorAll('.product-row').forEach(row => {
        const sel   = row.querySelector('.product-select');
        const opt   = sel ? sel.options[sel.selectedIndex] : null;
        const price = opt ? parseFloat(opt.dataset.price || 0) : 0;
        const qty   = parseInt(row.querySelector('.qty-input').value) || 1;
        const sub   = price * qty;
        row.querySelector('.price-display').value = price ? 'RM ' + sub.toFixed(2) : '';
        total += sub;
    });
    document.getElementById('grandTotal').textContent = 'RM ' + total.toFixed(2);
}
</script>
