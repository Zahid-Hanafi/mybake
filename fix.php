<?php
$dir = new RecursiveDirectoryIterator('c:/laragon/www/mybake/src/Model/Entity');
$ite = new RecursiveIteratorIterator($dir);
foreach($ite as $file) {
    if ($file->getExtension() === 'php') {
        $content = file_get_contents($file->getPathname());
        $content = str_replace('protected array $_accessible', 'protected $_accessible', $content);
        $content = str_replace('protected array $_hidden', 'protected $_hidden', $content);
        file_put_contents($file->getPathname(), $content);
    }
}
echo "Entities fixed.\n";
