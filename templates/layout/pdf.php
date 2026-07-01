<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title><?= $this->fetch('title') ?></title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700;800&family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <!-- CSS -->
    <link rel="stylesheet" href="<?= $this->request->getAttribute('webroot') ?>css/mybake.css">
    
    <style>
        body { font-family: 'Inter', sans-serif; color: #1C1C1C; margin: 0; padding: 2rem; background: #fff; line-height: 1.5; }
        @media print {
            body { padding: 0; background: #fff; }
            .btn, form, a, button { display: none !important; }
            * { -webkit-print-color-adjust: exact !important; print-color-adjust: exact !important; }
        }
    </style>
</head>
<body onload="window.print()">
    <?= $this->fetch('content') ?>
</body>
</html>
