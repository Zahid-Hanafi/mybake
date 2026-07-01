<?php
$this->assign('title', 'Receipt - Order #' . $order->id);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Receipt - Order #<?= $order->id ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;800&family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; color: #1C1C1C; margin: 0; padding: 2rem; background: #fff; line-height: 1.5; }
        .receipt-box { max-width: 700px; margin: 0 auto; border: 1px solid #E8E0D5; padding: 3rem; }
        .header { display: flex; justify-content: space-between; border-bottom: 2px solid #00674F; padding-bottom: 1.5rem; margin-bottom: 2rem; }
        .brand { font-family: 'Playfair Display', serif; font-size: 2rem; font-weight: 800; color: #00674F; margin: 0; }
        .brand span { font-size: 1rem; font-family: 'Inter', sans-serif; font-weight: 400; color: #6B6B6B; display: block; margin-top: 0.2rem; }
        .receipt-title { font-size: 1.8rem; font-family: 'Playfair Display', serif; font-weight: 600; text-transform: uppercase; color: #C9A84C; margin: 0; text-align: right; }
        .receipt-info { text-align: right; font-size: 0.85rem; color: #6B6B6B; margin-top: 0.5rem; }
        .info-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 2rem; margin-bottom: 2rem; font-size: 0.9rem; }
        .info-block strong { color: #00674F; display: block; margin-bottom: 0.3rem; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 2rem; font-size: 0.9rem; }
        th { text-align: left; padding: 0.75rem 0.5rem; border-bottom: 1px solid #E8E0D5; color: #6B6B6B; font-weight: 600; }
        td { padding: 1rem 0.5rem; border-bottom: 1px solid #f5f2ec; }
        .text-right { text-align: right; }
        .total-row { font-size: 1.2rem; font-weight: 600; color: #00674F; }
        .footer { text-align: center; border-top: 1px solid #E8E0D5; padding-top: 1.5rem; color: #6B6B6B; font-size: 0.8rem; margin-top: 3rem; }
        @media print {
            body { padding: 0; background: #fff; }
            .receipt-box { border: none; padding: 0; max-width: 100%; }
        }
    </style>
</head>
<body onload="window.print()">

<div class="receipt-box">
    <div class="header">
        <div>
            <h1 class="brand">MyBake <span>Authentic Homemade Taste</span></h1>
            <div style="font-size: 0.8rem; color: #6B6B6B; margin-top: 1rem;">
                Lot14191, Parit 7, Kg. Sungai Leman<br>
                45400 Sekinchan, Selangor<br>
                Tel: +60 12-345 6789
            </div>
        </div>
        <div>
            <h2 class="receipt-title">Order Receipt</h2>
            <div class="receipt-info">
                <div>Order #: <strong><?= $order->id ?></strong></div>
                <div>Date: <strong><?= $order->created_at->format('d M Y') ?></strong></div>
                <div>Status: <strong style="text-transform: capitalize; color: #00674F;"><?= $order->status ?></strong></div>
            </div>
        </div>
    </div>

    <div class="info-grid">
        <div class="info-block">
            <strong>Billed To:</strong>
            <?= h($order->user->first_name . ' ' . $order->user->last_name) ?><br>
            <?= h($order->phone_no) ?><br>
            <?= h($order->user->email) ?>
        </div>
        <div class="info-block">
            <strong>Delivery Address:</strong>
            <?= h($order->delivery_address) ?>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>Item Description</th>
                <th class="text-right">Price</th>
                <th class="text-right">Qty</th>
                <th class="text-right">Total</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($order->order_items as $item): ?>
            <tr>
                <td><?= h($item->product_name) ?></td>
                <td class="text-right">RM <?= number_format($item->unit_price, 2) ?></td>
                <td class="text-right"><?= $item->quantity ?></td>
                <td class="text-right">RM <?= number_format($item->subtotal, 2) ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
        <?php
        $subtotal = 0;
        foreach ($order->order_items as $item) {
            $subtotal += $item->subtotal;
        }
        $discount = (float)($order->discount ?? 0);
        $deliveryFee = (float)($order->delivery_fee ?? ($order->total_amount - $subtotal + $discount));
        ?>
        <tfoot>
            <tr>
                <td colspan="3" class="text-right" style="padding-top:1.5rem;">Subtotal</td>
                <td class="text-right" style="padding-top:1.5rem;">RM <?= number_format($subtotal, 2) ?></td>
            </tr>
            <?php if ($discount > 0): ?>
            <tr>
                <td colspan="3" class="text-right" style="color:#DC2626;">Discount (20%)</td>
                <td class="text-right" style="color:#DC2626;">- RM <?= number_format($discount, 2) ?></td>
            </tr>
            <?php endif; ?>
            <tr>
                <td colspan="3" class="text-right">Delivery</td>
                <td class="text-right"><?= $deliveryFee > 0 ? 'RM ' . number_format($deliveryFee, 2) : 'RM 0.00' ?></td>
            </tr>
            <tr class="total-row">
                <td colspan="3" class="text-right" style="padding-top:1rem; border-top:1px solid #E8E0D5;">Grand Total</td>
                <td class="text-right" style="padding-top:1rem; border-top:1px solid #E8E0D5;">RM <?= number_format($order->total_amount, 2) ?></td>
            </tr>
        </tfoot>
    </table>

    <div class="footer">
        Thank you for choosing MyBake!<br>
        If you have any questions concerning this receipt, use our contact form.
    </div>
</div>

</body>
</html>
