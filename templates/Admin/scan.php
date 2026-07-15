<?php
/**
 * QR Scan Page — Mobile-friendly standalone page for staff to process orders
 * Accessed by scanning the QR code on packing slip
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>MyBake — Process Order #<?= $order->id ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Inter', sans-serif; background: #F5F0EB; min-height: 100vh; color: #1C1C1C; }

        .scan-header {
            background: linear-gradient(135deg, #003D30, #00674F);
            color: #fff; padding: 1.25rem 1.5rem;
            display: flex; align-items: center; justify-content: space-between;
            position: sticky; top: 0; z-index: 10;
        }
        .scan-header-brand { font-family: 'Playfair Display', serif; font-weight: 800; font-size: 1.1rem; }
        .scan-header-sub { font-size: 0.7rem; opacity: 0.7; margin-top: 0.15rem; }

        .scan-body { padding: 1.25rem; max-width: 500px; margin: 0 auto; }

        .order-card {
            background: #fff; border-radius: 16px; overflow: hidden;
            box-shadow: 0 2px 12px rgba(0,0,0,0.08); margin-bottom: 1rem;
        }
        .order-card-header {
            padding: 1rem 1.25rem; border-bottom: 1px solid #E8E0D5;
            display: flex; justify-content: space-between; align-items: center;
        }
        .order-card-body { padding: 1.25rem; }

        .order-id { font-family: 'Playfair Display', serif; font-weight: 700; font-size: 1.25rem; }
        .status-pill {
            display: inline-flex; align-items: center; gap: 0.3rem;
            padding: 0.3rem 0.75rem; border-radius: 20px;
            font-size: 0.75rem; font-weight: 700; text-transform: uppercase;
        }
        .status-preparing { background: #FEF3C7; color: #B45309; }
        .status-shipping { background: #DBEAFE; color: #1D4ED8; }
        .status-complete { background: #DCFCE7; color: #15803D; }
        .status-cancelled { background: #F3F4F6; color: #6B7280; }

        .info-row { display: flex; gap: 0.5rem; margin-bottom: 0.75rem; font-size: 0.875rem; }
        .info-row i { color: #00674F; width: 18px; margin-top: 0.15rem; flex-shrink: 0; }
        .info-label { font-size: 0.7rem; color: #6B6B6B; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.35rem; font-weight: 600; }

        .item-list { list-style: none; }
        .item-row {
            display: flex; justify-content: space-between; align-items: center;
            padding: 0.75rem 0; border-bottom: 1px solid #F5F0EB;
        }
        .item-row:last-child { border-bottom: none; }
        .item-name { font-weight: 600; font-size: 0.875rem; }
        .item-qty { font-size: 0.8rem; color: #6B6B6B; }
        .item-price { font-weight: 700; color: #00674F; font-size: 0.875rem; }

        .action-section {
            background: #fff; border-radius: 16px; padding: 1.5rem;
            box-shadow: 0 2px 12px rgba(0,0,0,0.08); margin-bottom: 1rem;
        }
        .action-title {
            font-family: 'Playfair Display', serif; font-weight: 700;
            font-size: 1.1rem; margin-bottom: 1rem;
            display: flex; align-items: center; gap: 0.5rem;
        }

        .form-group { margin-bottom: 1rem; }
        .form-label { display: block; font-size: 0.8rem; font-weight: 600; margin-bottom: 0.35rem; color: #1C1C1C; }
        .form-control {
            width: 100%; padding: 0.75rem 1rem; border: 1.5px solid #E8E0D5;
            border-radius: 12px; font-size: 0.9rem; font-family: 'Inter', sans-serif;
            outline: none; transition: border-color 0.2s;
        }
        .form-control:focus { border-color: #00674F; box-shadow: 0 0 0 3px rgba(0,103,79,0.12); }
        .form-select { appearance: auto; cursor: pointer; }

        .btn-ship {
            width: 100%; padding: 0.875rem; border: none; border-radius: 12px;
            font-size: 1rem; font-weight: 700; cursor: pointer;
            display: flex; align-items: center; justify-content: center; gap: 0.5rem;
            transition: all 0.2s;
        }
        .btn-ship-primary {
            background: linear-gradient(135deg, #003D30, #00674F);
            color: #fff;
        }
        .btn-ship-primary:hover { transform: translateY(-1px); box-shadow: 0 4px 12px rgba(0,103,79,0.3); }
        .btn-ship-primary:disabled { opacity: 0.5; cursor: not-allowed; transform: none; }

        .btn-ship-success {
            background: linear-gradient(135deg, #15803D, #22C55E); color: #fff;
        }

        .completed-banner {
            text-align: center; padding: 2rem;
            background: linear-gradient(135deg, #DCFCE7, #F0FDF4);
            border-radius: 16px; margin-bottom: 1rem;
        }
        .completed-banner i { font-size: 2.5rem; color: #15803D; margin-bottom: 0.75rem; }

        .timeline { position: relative; padding-left: 1.5rem; }
        .timeline::before {
            content: ''; position: absolute; left: 6px; top: 8px; bottom: 8px;
            width: 2px; background: #E8E0D5;
        }
        .timeline-item { position: relative; padding-bottom: 1rem; padding-left: 1rem; }
        .timeline-item::before {
            content: ''; position: absolute; left: -1.5rem; top: 4px;
            width: 14px; height: 14px; border-radius: 50%;
            background: #E8E0D5; border: 2px solid #fff;
        }
        .timeline-item.done::before { background: #00674F; }
        .timeline-status { font-weight: 700; font-size: 0.85rem; text-transform: capitalize; }
        .timeline-note { font-size: 0.78rem; color: #6B6B6B; margin-top: 0.15rem; }
        .timeline-time { font-size: 0.7rem; color: #9CA3AF; margin-top: 0.1rem; }
    </style>
</head>
<body>

<div class="scan-header">
    <div>
        <div class="scan-header-brand"><i class="fas fa-boxes-stacked"></i> MyBake Packing Portal</div>
        <div class="scan-header-sub">Order Processing System</div>
    </div>
    <a href="<?= $this->Url->build('/admin/orders') ?>" style="color:rgba(255,255,255,0.8); font-size:0.85rem; text-decoration:none;">
        <i class="fas fa-arrow-left"></i> Back
    </a>
</div>

<div class="scan-body">

    <!-- Order Info Card -->
    <div class="order-card">
        <div class="order-card-header">
            <div class="order-id">Order #<?= $order->id ?></div>
            <span class="status-pill status-<?= $order->status ?>" id="statusPill">
                <?= ucfirst($order->status) ?>
            </span>
        </div>
        <div class="order-card-body">
            <div class="info-row">
                <i class="fas fa-user"></i>
                <div>
                    <div style="font-weight:600;"><?= h($order->user->first_name . ' ' . $order->user->last_name) ?></div>
                    <div style="font-size:0.78rem; color:#6B6B6B;"><?= h($order->user->email) ?></div>
                </div>
            </div>
            <div class="info-row">
                <i class="fas fa-map-marker-alt"></i>
                <div><?= h($order->delivery_address) ?></div>
            </div>
            <div class="info-row">
                <i class="fas fa-phone"></i>
                <div><?= h($order->phone_no) ?></div>
            </div>
            <div class="info-row">
                <i class="fas fa-calendar"></i>
                <div><?= $order->created_at ? $order->created_at->format('d M Y, h:i A') : '—' ?></div>
            </div>
        </div>
    </div>

    <!-- Items Card -->
    <div class="order-card">
        <div class="order-card-body">
            <div class="info-label"><i class="fas fa-box-open"></i> Items to Pack (<?= count($order->order_items) ?>)</div>
            <ul class="item-list">
                <?php foreach ($order->order_items as $item): ?>
                <li class="item-row">
                    <div>
                        <div class="item-name"><?= h($item->product_name) ?></div>
                        <div class="item-qty">× <?= $item->quantity ?></div>
                    </div>
                    <div class="item-price">RM <?= number_format($item->subtotal, 2) ?></div>
                </li>
                <?php endforeach; ?>
            </ul>
            <div style="margin-top:0.75rem; padding-top:0.75rem; border-top:2px solid #E8E0D5; display:flex; justify-content:space-between;">
                <span style="font-weight:700;">Total</span>
                <span style="font-weight:800; color:#00674F; font-size:1.1rem;">RM <?= number_format($order->total_amount, 2) ?></span>
            </div>
        </div>
    </div>

    <?php if ($order->notes): ?>
    <div class="order-card">
        <div class="order-card-body">
            <div class="info-label"><i class="fas fa-sticky-note"></i> Customer Notes</div>
            <p style="font-size:0.875rem; color:#6B6B6B; margin-top:0.25rem;"><?= h($order->notes) ?></p>
        </div>
    </div>
    <?php endif; ?>

    <!-- Action Section -->
    <?php if ($order->status === 'preparing'): ?>
    <div class="action-section">
        <div class="action-title"><i class="fas fa-truck" style="color:#00674F;"></i> Ship This Order</div>
        <p style="font-size:0.8rem; color:#6B6B6B; margin-bottom:1rem;">Enter the tracking number from Pos Laju and confirm shipping.</p>

        <form id="shipForm">
            <div class="form-group">
                <label class="form-label">Courier</label>
                <select class="form-control form-select" id="courierName">
                    <option value="Pos Laju" selected>Pos Laju</option>
                </select>
            </div>
            <div class="form-group">
                <label class="form-label">Tracking Number *</label>
                <input type="text" class="form-control" id="trackingNumber" value="EN" minlength="13" maxlength="13" required autofocus>
                <div style="font-size:0.75rem; color:#6B6B6B; margin-top:0.35rem;">Must be exactly 13 characters (e.g. EN123456789MY)</div>
            </div>
            <button type="submit" class="btn-ship btn-ship-primary" id="shipBtn">
                <i class="fas fa-truck-fast"></i> Confirm Shipping
            </button>
        </form>
    </div>

    <?php elseif ($order->status === 'shipping'): ?>
    <div class="completed-banner" style="background:linear-gradient(135deg, #DBEAFE, #EFF6FF);">
        <i class="fas fa-truck" style="color:#1D4ED8;"></i>
        <h3 style="color:#1D4ED8; margin-bottom:0.5rem;">Order is Shipping</h3>
        <p style="font-size:0.85rem; color:#6B6B6B;">
            Courier: <strong><?= h($order->courier_name) ?></strong><br>
            Tracking: <strong><?= h($order->tracking_number) ?></strong>
        </p>
        <a href="https://www.tracking.my/poslaju/<?= h($order->tracking_number) ?>" target="_blank"
           style="display:inline-flex; align-items:center; gap:0.4rem; margin-top:0.75rem; color:#1D4ED8; font-size:0.85rem; font-weight:600;">
            <i class="fas fa-external-link-alt"></i> Track on Pos Laju
        </a>
    </div>

    <?php elseif ($order->status === 'complete'): ?>
    <div class="completed-banner">
        <i class="fas fa-circle-check"></i>
        <h3 style="color:#15803D; margin-bottom:0.25rem;">Order Completed</h3>
        <p style="font-size:0.85rem; color:#6B6B6B;">This order has been delivered successfully.</p>
    </div>

    <?php elseif ($order->status === 'cancelled'): ?>
    <div class="completed-banner" style="background:linear-gradient(135deg, #F3F4F6, #fff);">
        <i class="fas fa-ban" style="color:#6B7280;"></i>
        <h3 style="color:#6B7280; margin-bottom:0.25rem;">Order Cancelled</h3>
        <p style="font-size:0.85rem; color:#6B6B6B;">This order was cancelled.</p>
    </div>
    <?php endif; ?>

    <!-- Status Timeline -->
    <?php if (!empty($order->order_status_logs)): ?>
    <div class="order-card">
        <div class="order-card-body">
            <div class="info-label" style="margin-bottom:1rem;"><i class="fas fa-timeline"></i> Status History</div>
            <div class="timeline">
                <?php foreach ($order->order_status_logs as $log): ?>
                <div class="timeline-item done">
                    <div class="timeline-status"><?= ucfirst($log->status) ?></div>
                    <div class="timeline-note"><?= h($log->note) ?></div>
                    <div class="timeline-time"><?= $log->created_at ? $log->created_at->format('d M Y, h:i A') : '' ?></div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    <?php endif; ?>

</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
<script>
document.getElementById('shipForm')?.addEventListener('submit', function(e) {
    e.preventDefault();
    const tracking = document.getElementById('trackingNumber').value.trim();
    const courier  = document.getElementById('courierName').value;
    const btn      = document.getElementById('shipBtn');

    if (!tracking || tracking.length !== 13) {
        Swal.fire('Error', 'Please enter a valid 13-character tracking number.', 'error');
        return;
    }

    btn.disabled = true;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Processing...';

    fetch('<?= $this->Url->build('/admin/orders/ship/' . $order->id) ?>', {
        method: 'POST',
        headers: { 
            'Content-Type': 'application/json', 
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-Token': '<?= $this->request->getAttribute('csrfToken') ?>'
        },
        body: JSON.stringify({ tracking_number: tracking, courier_name: courier })
    })
    .then(r => r.json())
    .then(data => {
        if (data.success) {
            Swal.fire({
                icon: 'success',
                title: 'Shipped! 🚚',
                text: data.message,
                confirmButtonColor: '#00674F',
            }).then(() => location.reload());
        } else {
            btn.disabled = false;
            btn.innerHTML = '<i class="fas fa-truck-fast"></i> Confirm Shipping';
            Swal.fire('Error', data.error || 'Failed to ship order.', 'error');
        }
    })
    .catch(() => {
        btn.disabled = false;
        btn.innerHTML = '<i class="fas fa-truck-fast"></i> Confirm Shipping';
        Swal.fire('Error', 'Something went wrong.', 'error');
    });
});
</script>

</body>
</html>
