<?php

/**
 * PRODUCTION index.php — for cPanel shared hosting
 *
 * This file goes into:   public_html/index.php
 * Your Laravel app goes: easysolve/  (sibling of public_html, i.e. /home/USERNAME/easysolve/)
 *
 * This keeps your .env, storage/, and app code OUTSIDE the web root for security.
 */

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Path to the Laravel project (one level above public_html)
$appPath = dirname(__DIR__) . '/easysolve';

// Maintenance mode
if (file_exists($maintenance = $appPath . '/storage/framework/maintenance.php')) {
    require $maintenance;
}

// Composer autoloader
require $appPath . '/vendor/autoload.php';

// Bootstrap Laravel
/** @var Application $app */
$app = require_once $appPath . '/bootstrap/app.php';

$app->handleRequest(Request::capture());
