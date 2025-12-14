<?php
/**
 * Complete Diagnostic Script
 * Access: https://your-domain.com/diagnose.php
 */

header('Content-Type: text/html; charset=utf-8');
?>
<!DOCTYPE html>
<html>
<head>
    <title>Laravel Diagnostic</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; background: #f5f5f5; }
        .section { background: white; padding: 20px; margin: 10px 0; border-radius: 5px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        .pass { color: green; font-weight: bold; }
        .fail { color: red; font-weight: bold; }
        .warn { color: orange; font-weight: bold; }
        h2 { border-bottom: 2px solid #333; padding-bottom: 10px; }
        pre { background: #f0f0f0; padding: 10px; border-radius: 3px; overflow-x: auto; }
        table { width: 100%; border-collapse: collapse; }
        td { padding: 8px; border-bottom: 1px solid #ddd; }
        td:first-child { font-weight: bold; width: 300px; }
    </style>
</head>
<body>
    <h1>🔍 Laravel Application Diagnostic Report</h1>
    
    <?php
    // Try to bootstrap Laravel
    $laravelBooted = false;
    try {
        require __DIR__.'/../vendor/autoload.php';
        $app = require_once __DIR__.'/../bootstrap/app.php';
        $kernel = $app->make('Illuminate\Contracts\Console\Kernel');
        $kernel->bootstrap();
        $laravelBooted = true;
        echo '<div class="section"><span class="pass">✓ Laravel Application Booted Successfully</span></div>';
    } catch (Exception $e) {
        echo '<div class="section"><span class="fail">✗ Failed to boot Laravel</span><br>';
        echo '<pre>' . htmlspecialchars($e->getMessage()) . '</pre></div>';
    }
    ?>

    <div class="section">
        <h2>📋 Environment Information</h2>
        <table>
            <tr><td>PHP Version</td><td><?= PHP_VERSION ?></td></tr>
            <tr><td>Server Software</td><td><?= $_SERVER['SERVER_SOFTWARE'] ?? 'Unknown' ?></td></tr>
            <tr><td>Document Root</td><td><?= $_SERVER['DOCUMENT_ROOT'] ?? 'Unknown' ?></td></tr>
            <tr><td>Current Script</td><td><?= __FILE__ ?></td></tr>
            <tr><td>Laravel Root</td><td><?= dirname(__DIR__) ?></td></tr>
        </table>
    </div>

    <?php if ($laravelBooted): ?>
    
    <div class="section">
        <h2>🔑 Application Configuration</h2>
        <table>
            <?php
            $configs = [
                'APP_NAME' => config('app.name'),
                'APP_ENV' => config('app.env'),
                'APP_DEBUG' => config('app.debug') ? 'true' : 'false',
                'APP_URL' => config('app.url'),
                'APP_KEY Set' => !empty(config('app.key')) ? 'YES' : 'NO',
                'APP_KEY Length' => strlen(config('app.key')),
                'APP_KEY Preview' => !empty(config('app.key')) ? substr(config('app.key'), 0, 20) . '...' : 'NOT SET',
            ];
            
            foreach ($configs as $key => $value) {
                $status = '';
                if ($key === 'APP_KEY Set') {
                    $status = $value === 'YES' ? '<span class="pass">✓</span>' : '<span class="fail">✗</span>';
                }
                echo "<tr><td>$key</td><td>$status $value</td></tr>";
            }
            ?>
        </table>
    </div>

    <div class="section">
        <h2>💾 Database Configuration</h2>
        <table>
            <?php
            $dbConfigs = [
                'Connection' => config('database.default'),
                'Host' => config('database.connections.mysql.host'),
                'Port' => config('database.connections.mysql.port'),
                'Database' => config('database.connections.mysql.database'),
                'Username' => config('database.connections.mysql.username'),
                'Password' => !empty(config('database.connections.mysql.password')) ? 'SET' : 'NOT SET',
            ];
            
            foreach ($dbConfigs as $key => $value) {
                echo "<tr><td>$key</td><td>$value</td></tr>";
            }
            ?>
        </table>
        
        <?php
        // Test database connection
        try {
            DB::connection()->getPdo();
            $dbVersion = DB::select('SELECT VERSION() as version')[0]->version;
            echo '<p><span class="pass">✓ Database Connection: SUCCESS</span></p>';
            echo '<p>MySQL Version: ' . $dbVersion . '</p>';
        } catch (Exception $e) {
            echo '<p><span class="fail">✗ Database Connection: FAILED</span></p>';
            echo '<pre>' . htmlspecialchars($e->getMessage()) . '</pre>';
        }
        ?>
    </div>

    <div class="section">
        <h2>🍪 Session Configuration</h2>
        <table>
            <?php
            $sessionConfigs = [
                'Driver' => config('session.driver'),
                'Lifetime' => config('session.lifetime') . ' minutes',
                'Encrypt' => config('session.encrypt') ? 'Yes' : 'No',
                'Path' => config('session.path'),
                'Domain' => config('session.domain') ?: 'null',
            ];
            
            foreach ($sessionConfigs as $key => $value) {
                echo "<tr><td>$key</td><td>$value</td></tr>";
            }
            ?>
        </table>
        
        <?php
        // Test session
        try {
            session()->put('test_diagnostic', 'working');
            session()->save();
            $testValue = session()->get('test_diagnostic');
            if ($testValue === 'working') {
                echo '<p><span class="pass">✓ Session Write/Read: SUCCESS</span></p>';
            } else {
                echo '<p><span class="fail">✗ Session Write/Read: FAILED</span></p>';
            }
            session()->forget('test_diagnostic');
        } catch (Exception $e) {
            echo '<p><span class="fail">✗ Session Test: FAILED</span></p>';
            echo '<pre>' . htmlspecialchars($e->getMessage()) . '</pre>';
        }
        ?>
    </div>

    <div class="section">
        <h2>📁 Storage & Permissions</h2>
        <table>
            <?php
            $paths = [
                'Storage Path' => storage_path(),
                'Logs Path' => storage_path('logs'),
                'Sessions Path' => storage_path('framework/sessions'),
                'Cache Path' => storage_path('framework/cache'),
                'Views Path' => storage_path('framework/views'),
            ];
            
            foreach ($paths as $label => $path) {
                $exists = file_exists($path) ? '✓ Exists' : '✗ Missing';
                $writable = is_writable($path) ? '✓ Writable' : '✗ Not Writable';
                $status = (file_exists($path) && is_writable($path)) ? 'pass' : 'fail';
                echo "<tr><td>$label</td><td><span class='$status'>$exists | $writable</span><br><small>$path</small></td></tr>";
            }
            ?>
        </table>
    </div>

    <div class="section">
        <h2>🔐 Encryption Test</h2>
        <?php
        try {
            $testString = 'test_encryption_' . time();
            $encrypted = encrypt($testString);
            $decrypted = decrypt($encrypted);
            
            if ($decrypted === $testString) {
                echo '<p><span class="pass">✓ Encryption/Decryption: WORKING</span></p>';
            } else {
                echo '<p><span class="fail">✗ Encryption/Decryption: MISMATCH</span></p>';
            }
        } catch (Exception $e) {
            echo '<p><span class="fail">✗ Encryption Test: FAILED</span></p>';
            echo '<pre>' . htmlspecialchars($e->getMessage()) . '</pre>';
        }
        ?>
    </div>

    <div class="section">
        <h2>🔍 Cookie Encryption Test</h2>
        <?php
        try {
            $encrypter = app('encrypter');
            $testCookie = 'test_cookie_value';
            $encrypted = $encrypter->encrypt($testCookie, false);
            $decrypted = $encrypter->decrypt($encrypted, false);
            
            if ($decrypted === $testCookie) {
                echo '<p><span class="pass">✓ Cookie Encryption: WORKING</span></p>';
            } else {
                echo '<p><span class="fail">✗ Cookie Encryption: MISMATCH</span></p>';
            }
        } catch (Exception $e) {
            echo '<p><span class="fail">✗ Cookie Encryption Test: FAILED</span></p>';
            echo '<pre>' . htmlspecialchars($e->getMessage()) . '</pre>';
            echo '<p><strong>This is likely the cause of your 500 error!</strong></p>';
        }
        ?>
    </div>

    <div class="section">
        <h2>🎯 Login Route Test</h2>
        <?php
        try {
            $route = app('router')->getRoutes()->getByName('login') 
                ?? app('router')->getRoutes()->match(
                    \Illuminate\Http\Request::create('/login', 'POST')
                );
            
            if ($route) {
                echo '<p><span class="pass">✓ Login Route: REGISTERED</span></p>';
                echo '<p>URI: ' . $route->uri() . '</p>';
                echo '<p>Methods: ' . implode(', ', $route->methods()) . '</p>';
                echo '<p>Action: ' . $route->getActionName() . '</p>';
            } else {
                echo '<p><span class="fail">✗ Login Route: NOT FOUND</span></p>';
            }
        } catch (Exception $e) {
            echo '<p><span class="warn">⚠ Could not check login route</span></p>';
            echo '<pre>' . htmlspecialchars($e->getMessage()) . '</pre>';
        }
        ?>
    </div>

    <div class="section">
        <h2>📊 PHP Extensions</h2>
        <?php
        $required = ['pdo', 'pdo_mysql', 'mbstring', 'openssl', 'json', 'bcmath', 'ctype', 'fileinfo'];
        echo '<table>';
        foreach ($required as $ext) {
            $loaded = extension_loaded($ext);
            $status = $loaded ? '<span class="pass">✓ Loaded</span>' : '<span class="fail">✗ Missing</span>';
            echo "<tr><td>$ext</td><td>$status</td></tr>";
        }
        echo '</table>';
        ?>
    </div>

    <?php endif; ?>

    <div class="section">
        <h2>✅ Diagnosis Summary</h2>
        <?php
        $issues = [];
        
        if ($laravelBooted) {
            if (empty(config('app.key'))) {
                $issues[] = '<span class="fail">✗ APP_KEY is not set - THIS IS THE MAIN ISSUE!</span>';
            }
            
            try {
                DB::connection()->getPdo();
            } catch (Exception $e) {
                $issues[] = '<span class="fail">✗ Database connection failed</span>';
            }
            
            if (!is_writable(storage_path('framework/sessions'))) {
                $issues[] = '<span class="fail">✗ Sessions directory not writable</span>';
            }
        } else {
            $issues[] = '<span class="fail">✗ Laravel failed to boot</span>';
        }
        
        if (empty($issues)) {
            echo '<p><span class="pass">🎉 All checks passed! Your application should work correctly.</span></p>';
        } else {
            echo '<p><strong>Issues Found:</strong></p><ul>';
            foreach ($issues as $issue) {
                echo '<li>' . $issue . '</li>';
            }
            echo '</ul>';
            echo '<p><strong>Action Required:</strong> Fix the issues above by setting environment variables in Render dashboard.</p>';
        }
        ?>
    </div>

    <div class="section">
        <p><small>Generated: <?= date('Y-m-d H:i:s') ?> | Server Time: <?= date_default_timezone_get() ?></small></p>
    </div>
</body>
</html>
