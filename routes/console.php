<?php

use App\Console\Commands\SiteSSLCheck;
use App\Console\Commands\UptimeCheck;

use Illuminate\Support\Facades\Schedule;

// Artisan::command('inspire', function () {
//     $this->comment(Inspiring::quote());
// })->purpose('Display an inspiring quote');

Schedule::command(SiteSSLCheck::class)->dailyAt('1:00')->appendOutputTo(storage_path('logs/ssl-check.log'));
Schedule::command(UptimeCheck::class)->everyMinute();
// ->appendOutputTo(storage_path('logs/uptime-check.log'));
Schedule::command("queue:work --stop-when-empty")
    ->everyMinute()
    ->withoutOverlapping(5) //khong chay 2 job cung luc, it nhat 5 phut sau neu co job dang chay thi moi chay tiep 1 cai nua
    ->runInBackground() //toi gio la chay, nhung se check overlap o tren
    ->appendOutputTo(storage_path('logs/notification.log'));