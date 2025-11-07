<?php

$base = __DIR__ . '/..';
$src = $base . '/legacy/admin';
$dst = $base . '/public/legacy/admin';

function rrmdir($dir) {
    if (!is_dir($dir)) return;
    $it = new RecursiveDirectoryIterator($dir, RecursiveDirectoryIterator::SKIP_DOTS);
    $files = new RecursiveIteratorIterator($it, RecursiveIteratorIterator::CHILD_FIRST);
    foreach($files as $file) {
        if ($file->isDir()) rmdir($file->getRealPath()); else unlink($file->getRealPath());
    }
    rmdir($dir);
}

function rrcopy($src, $dst) {
    $dir = opendir($src);
    @mkdir($dst, 0777, true);
    while(false !== ($file = readdir($dir))) {
        if (($file != '.') && ($file != '..')) {
            if (is_dir($src . '/' . $file)) {
                rrcopy($src . '/' . $file, $dst . '/' . $file);
            } else {
                copy($src . '/' . $file, $dst . '/' . $file);
            }
        }
    }
    closedir($dir);
}

if (!is_dir($src)) {
    echo "Source admin folder not found: $src\n";
    exit(1);
}

if (is_dir($dst)) {
    echo "Destination exists, removing: $dst\n";
    rrmdir($dst);
}

echo "Copying $src -> $dst\n";
rrcopy($src, $dst);
echo "COPY_DONE\n";
