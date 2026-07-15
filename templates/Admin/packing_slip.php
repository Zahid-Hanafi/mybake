<?php
/**
 * Printable Packing Slip with QR Code
 * This page is printed and attached to the parcel
 */
$scanUrl = $this->Url->build('/admin/orders/scan/' . $order->qr_token, ['fullBase' => true]);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Packing Slip — Order #<?= $order->id ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Inter', sans-serif; color: #1C1C1C; padding: 1.5rem; background: #fff; }
        .slip { max-width: 600px; margin: 0 auto; border: 2px dashed #C9A84C; padding: 2rem; }

        .slip-header { display: flex; justify-content: space-between; align-items: flex-start; border-bottom: 2px solid #00674F; padding-bottom: 1.25rem; margin-bottom: 1.25rem; }
        .brand { font-family: 'Playfair Display', serif; font-size: 1.5rem; font-weight: 800; color: #00674F; }
        .brand-sub { font-size: 0.7rem; color: #6B6B6B; margin-top: 0.2rem; }

        .qr-section { text-align: center; }
        .qr-section img { width: 120px; height: 120px; border: 2px solid #E8E0D5; border-radius: 8px; padding: 4px; }
        .qr-label { font-size: 0.6rem; color: #6B6B6B; margin-top: 0.35rem; text-transform: uppercase; letter-spacing: 0.05em; }

        .order-badge {
            display: inline-block; background: #00674F; color: #fff;
            padding: 0.4rem 1rem; border-radius: 8px; font-weight: 700;
            font-size: 1.1rem; margin-bottom: 1rem;
        }

        .info-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 1.25rem; margin-bottom: 1.25rem; }
        .info-block-title { font-size: 0.7rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; color: #00674F; margin-bottom: 0.4rem; }
        .info-block p { font-size: 0.85rem; line-height: 1.6; color: #333; }

        table { width: 100%; border-collapse: collapse; margin-bottom: 1rem; font-size: 0.85rem; }
        th { text-align: left; padding: 0.6rem 0.5rem; border-bottom: 2px solid #00674F; color: #00674F; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.04em; }
        td { padding: 0.6rem 0.5rem; border-bottom: 1px solid #E8E0D5; }
        .text-right { text-align: right; }
        .total-row td { font-weight: 700; border-top: 2px solid #00674F; font-size: 0.95rem; padding-top: 0.75rem; }

        .slip-footer { text-align: center; border-top: 1px solid #E8E0D5; padding-top: 1rem; margin-top: 1rem; }
        .slip-footer p { font-size: 0.75rem; color: #6B6B6B; }

        .no-print { text-align: center; margin: 1rem auto; }
        .no-print button {
            background: linear-gradient(135deg, #003D30, #00674F); color: #fff;
            border: none; padding: 0.75rem 2rem; border-radius: 12px;
            font-size: 0.95rem; font-weight: 600; cursor: pointer;
        }
        .no-print button:hover { opacity: 0.9; }

        @media print {
            body { padding: 0; }
            .slip { border: 2px dashed #999; max-width: 100%; }
            .no-print { display: none; }
        }
    </style>
</head>
<body>

<div class="no-print">
    <button onclick="window.print()"><i>🖨️</i> Print Packing Slip</button>
</div>

<div class="slip">
    <div class="slip-header">
        <div>
            <div class="brand">MyBake</div>
            <div class="brand-sub">Authentic Homemade Taste</div>
            <div style="font-size:0.7rem; color:#6B6B6B; margin-top:0.5rem;">
                Lot14191, Parit 7, Kg. Sungai Leman<br>
                45400 Sekinchan, Selangor
            </div>
        </div>
        <div class="qr-section">
            <img src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=<?= urlencode($scanUrl) ?>" alt="QR Code">
            <div class="qr-label">Scan to Process</div>
        </div>
    </div>

    <div class="order-badge">ORDER #<?= $order->id ?></div>
    <div style="font-size:0.8rem; color:#6B6B6B; margin-bottom:1.25rem;">
        Date: <?= $order->created_at ? $order->created_at->format('d M Y, h:i A') : '—' ?>
    </div>

    <div class="info-grid">
        <div>
            <div class="info-block-title">Ship To</div>
            <p>
                <strong><?= h($order->user->first_name . ' ' . $order->user->last_name) ?></strong><br>
                <?= h($order->delivery_address) ?><br>
                Tel: <?= h($order->phone_no) ?>
            </p>
        </div>
        <div>
            <div class="info-block-title">Order Notes</div>
            <p><?= $order->notes ? h($order->notes) : '<em style="color:#9CA3AF;">No notes</em>' ?></p>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>Item</th>
                <th class="text-right">Qty</th>
                <th class="text-right">Price</th>
                <th class="text-right">Total</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($order->order_items as $item): ?>
            <tr>
                <td><?= h($item->product_name) ?></td>
                <td class="text-right"><?= $item->quantity ?></td>
                <td class="text-right">RM <?= number_format($item->unit_price, 2) ?></td>
                <td class="text-right">RM <?= number_format($item->subtotal, 2) ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr class="total-row">
                <td colspan="3" class="text-right">Grand Total</td>
                <td class="text-right">RM <?= number_format($order->total_amount, 2) ?></td>
            </tr>
        </tfoot>
    </table>

    <div class="slip-footer">
        <p>Thank you for choosing MyBake! 🍪</p>
        <p style="margin-top:0.25rem; font-size:0.65rem;">This packing slip was generated on <?= date('d M Y, h:i A') ?></p>
    </div>
</div>

</body>
</html>
