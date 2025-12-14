<?php
/**
 * Simple diagnostic script to check Laravel configuration
 * Access this at: https://your-domain.com/check-config.php
 */

// Bootstrap Laravel
require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

header('Content-Type: application/json');

$checks = [
    'app_key_set' => !empty(config('app.key')),
    'app_key_value' => config('app.key') ? substr(config('app.key'), 0, 20) . '...' : 'NOT SET',
    'app_env' => config('app.env'),
    'app_debug' => config('app.debug'),
    'app_url' => config('app.url'),
    'db_connection' => config('database.default'),
    'db_host' => config('database.connections.mysql.host'),
    'db_database' => config('database.connections.mysql.database'),
    'session_driver' => config('session.driver'),
    'cache_driver' => config('cache.default'),
    'storage_path' => storage_path(),
    'storage_writable' => is_writable(storage_path()),
    'logs_writable' => is_writable(storage_path('logs')),
    'sessions_path_exists' => file_exists(storage_path('framework/sessions')),
    'sessions_writable' => is_writable(storage_path('framework/sessions')),
    'php_version' => PHP_VERSION,
    'laravel_version' => app()->version(),
];

// Try to connect to database
try {
    DB::connection()->getPdo();
    $checks['db_connected'] = true;
    $checks['db_error'] = null;
} catch (\Exception $e) {
    $checks['db_connected'] = false;
    $checks['db_error'] = $e->getMessage();
}

// Check if we can create/read sessions
try {
    session()->put('test_key', 'test_value');
    session()->save();
    $checks['session_working'] = session()->get('test_key') === 'test_value';
    session()->forget('test_key');
} catch (\Exception $e) {
    $checks['session_working'] = false;
    $checks['session_error'] = $e->getMessage();
}

echo json_encode($checks, JSON_PRETTY_PRINT);
