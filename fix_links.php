<?php
$dir = new RecursiveDirectoryIterator(__DIR__ . '/templates');
$ite = new RecursiveIteratorIterator($dir);
foreach($ite as $file) {
    if ($file->getExtension() === 'php') {
        $content = file_get_contents($file->getPathname());
        // Fix href
        $content = preg_replace('/href="\/([^"]*)"/', 'href="<?= $this->Url->build(\'/$1\') ?>"', $content);
        // Fix action
        $content = preg_replace('/action="\/([^"]*)"/', 'action="<?= $this->Url->build(\'/$1\') ?>"', $content);
        // Fix fetch
        $content = preg_replace('/fetch\(\'\/([^\']*)\'/', 'fetch(\'<?= $this->Url->build(\'/$1\') ?>\'', $content);
        // Fix src
        $content = preg_replace('/src="\/([^"]*)"/', 'src="<?= $this->Url->build(\'/$1\') ?>"', $content);
        
        file_put_contents($file->getPathname(), $content);
    }
}
echo "Links updated successfully.";
