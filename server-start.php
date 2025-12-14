#!/usr/bin/env php
<?php

$host = '0.0.0.0';
$port = getenv('PORT') ?: 8000;
$root = __DIR__ . '/public';

echo "Starting server on {$host}:{$port}\n";
echo "Document root: {$root}\n";

$cmd = sprintf(
    'php -S %s:%d -t %s %s/server.php',
    $host,
    $port,
    escapeshellarg($root),
    escapeshellarg($root)
);

passthru($cmd);
