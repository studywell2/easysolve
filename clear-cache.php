<?php
/**
 * Cache Clear Script — Upload to your hosting root, visit in browser, then DELETE.
 * Usage: https://yourdomain.com.ng/clear-cache.php
 */

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$messages = [];

// Clear config cache
try {
    Illuminate\Support\Facades\Artisan::call('config:clear');
    $messages[] = '✅ Config cache cleared';
} catch (\Exception $e) {
    $messages[] = '⚠️ Config clear: ' . $e->getMessage();
}

// Clear view cache
try {
    Illuminate\Support\Facades\Artisan::call('view:clear');
    $messages[] = '✅ View cache cleared';
} catch (\Exception $e) {
    $messages[] = '⚠️ View clear: ' . $e->getMessage();
}

// Clear route cache
try {
    Illuminate\Support\Facades\Artisan::call('route:clear');
    $messages[] = '✅ Route cache cleared';
} catch (\Exception $e) {
    $messages[] = '⚠️ Route clear: ' . $e->getMessage();
}

// Clear application cache
try {
    Illuminate\Support\Facades\Artisan::call('cache:clear');
    $messages[] = '✅ Application cache cleared';
} catch (\Exception $e) {
    $messages[] = '⚠️ Cache clear: ' . $e->getMessage();
}

// Clear compiled classes
try {
    Illuminate\Support\Facades\Artisan::call('clear-compiled');
    $messages[] = '✅ Compiled classes cleared';
} catch (\Exception $e) {
    $messages[] = '⚠️ Clear-compiled: ' . $e->getMessage();
}

echo '<h2>Cache Clear Results</h2><pre>';
foreach ($messages as $msg) {
    echo $msg . "\n";
}
echo "\n⚠️ <strong>DELETE this file now for security!</strong>";
echo '</pre>';
