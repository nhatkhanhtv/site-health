<?php

use App\Console\Commands\SiteSSLCheck;
use App\Console\Commands\UptimeCheck;

use Illuminate\Support\Facades\Schedule;

// Artisan::command('inspire', function () {
//     $this->comment(Inspiring::quote());
// })->purpose('Display an inspiring quote');

Schedule::command(SiteSSLCheck::class)->everyTwoMinutes()->appendOutputTo(storage_path('logs/ssl-check.log'));
Schedule::command(UptimeCheck::class)->everyThirtySeconds()->appendOutputTo(storage_path('logs/uptime-check.log'));