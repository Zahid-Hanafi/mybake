<?php
$dir = new RecursiveDirectoryIterator('c:/laragon/www/mybake/src/Controller');
$ite = new RecursiveIteratorIterator($dir);
foreach($ite as $file) {
    if ($file->getExtension() === 'php') {
        $content = file_get_contents($file->getPathname());
        $newContent = str_replace('->orderBy(', '->order(', $content);
        if ($newContent !== $content) {
            file_put_contents($file->getPathname(), $newContent);
        }
    }
}
echo "Replaced orderBy with order in controllers.\n";
