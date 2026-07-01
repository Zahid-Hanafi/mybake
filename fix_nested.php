<?php
$dir = new RecursiveDirectoryIterator('c:/laragon/www/mybake/templates');
$ite = new RecursiveIteratorIterator($dir);
foreach($ite as $file) {
    if ($file->getExtension() === 'php') {
        $content = file_get_contents($file->getPathname());
        $orig = $content;

        // Fix product images
        $content = preg_replace("/<\?= \\\$this->Url->build\('\/img\/products\/<\?= h\(\\\$product->image \?\? 'default.jpg'\) \?>'\) \?>/", "<?= \$this->Url->build('/img/products/' . h(\$product->image ?? 'default.jpg')) ?>", $content);
        $content = preg_replace("/<\?= \\\$this->Url->build\('\/img\/products\/<\?= htmlspecialchars\(\\\$product->image \?\? 'default.jpg'\) \?>'\) \?>/", "<?= \$this->Url->build('/img/products/' . htmlspecialchars(\$product->image ?? 'default.jpg')) ?>", $content);
        $content = preg_replace("/<\?= \\\$this->Url->build\('\/img\/products\/<\?= h\(\\\$item->product->image \?\? 'default.jpg'\) \?>'\) \?>/", "<?= \$this->Url->build('/img/products/' . h(\$item->product->image ?? 'default.jpg')) ?>", $content);

        // Fix orders links
        $content = preg_replace("/<\?= \\\$this->Url->build\('\/my-orders\/edit\/<\?= \\\$order->id \?>'\) \?>/", "<?= \$this->Url->build('/my-orders/edit/' . \$order->id) ?>", $content);
        $content = preg_replace("/<\?= \\\$this->Url->build\('\/my-orders\/view\/<\?= \\\$order->id \?>'\) \?>/", "<?= \$this->Url->build('/my-orders/view/' . \$order->id) ?>", $content);
        $content = preg_replace("/<\?= \\\$this->Url->build\('\/my-orders\/cancel\/<\?= \\\$order->id \?>'\) \?>/", "<?= \$this->Url->build('/my-orders/cancel/' . \$order->id) ?>", $content);

        // Fix address links
        $content = preg_replace("/<\?= \\\$this->Url->build\('\/profile\/addresses\/default\/<\?= \\\$address->id \?>'\) \?>/", "<?= \$this->Url->build('/profile/addresses/default/' . \$address->id) ?>", $content);
        $content = preg_replace("/<\?= \\\$this->Url->build\('\/profile\/addresses\/edit\/<\?= \\\$address->id \?>'\) \?>/", "<?= \$this->Url->build('/profile/addresses/edit/' . \$address->id) ?>", $content);
        $content = preg_replace("/<\?= \\\$this->Url->build\('\/profile\/addresses\/delete\/<\?= \\\$address->id \?>'\) \?>/", "<?= \$this->Url->build('/profile/addresses/delete/' . \$address->id) ?>", $content);

        // Fix sales report link
        $content = str_replace("<?= \$this->Url->build('/admin/sales/report?type=<?= h(\$type) ?>&date=<?= h(\$date) ?>&format=pdf') ?>", "<?= \$this->Url->build('/admin/sales/report?type=' . h(\$type) . '&date=' . h(\$date) . '&format=pdf') ?>", $content);

        // Fix admin orders status link
        $content = str_replace("<?= \$this->Url->build('/admin/orders<?= \$val ? \'?status=\' . \$val : \'\' ?>') ?>", "<?= \$this->Url->build('/admin/orders' . (\$val ? '?status=' . \$val : '')) ?>", $content);

        if ($content !== $orig) {
            file_put_contents($file->getPathname(), $content);
        }
    }
}
echo "Nested PHP tags fixed.\n";
