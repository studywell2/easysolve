<?php

use App\Console\Commands\ExpireSubscriptions;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Expire subscriptions & trials daily shortly after midnight
Schedule::command(ExpireSubscriptions::class)->dailyAt('00:01')
    ->description('Expire subscriptions and trials past their end date')
    ->withoutOverlapping()
    ->onOneServer();
