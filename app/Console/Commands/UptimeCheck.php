<?php

namespace App\Console\Commands;

use App\Models\Site;
use App\Models\SiteUptime;
use App\Notifications\AlertSiteDownNotification;
use App\Services\UptimeCheckService;
use App\UptimeStatus;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Notification;

class UptimeCheck extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'site:uptime-check';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check uptime of all sites in list';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $siteList = Site::where(
            [
                ['next_checked_at','<=',now()]
            ]
        )->orWhere(
            [
                ['next_checked_at', '=', null]
            ]
        )->get();
        $uptimeService = new UptimeCheckService();
        $downsites = [];
        foreach($siteList as $site) {
            
            $checkUptimeResult = $uptimeService->checkDomain($site->site_name);
            $siteUptime = new SiteUptime();
            $siteUptime->site_id = $site->id;
            $siteUptime->status = $checkUptimeResult['status'];
            $siteUptime->http_status = $checkUptimeResult['http_status'];
            $siteUptime->error = $checkUptimeResult['error'];
            $siteUptime->response_time_ms = $checkUptimeResult['response_time_ms'];
            $siteUptime->checked_at = now();
            if($siteUptime->save()) {                
                $site->next_checked_at = now()->addMinutes($site->time_interval);
                $site->save();
            }
            if($siteUptime->status == UptimeStatus::FAIL) {
                $downsites[] = $siteUptime;
            }
            
        }

        if(!empty($downsites)) {
            Notification::route('slack',config('services.slack.notifications.channel'))
            ->notify(new AlertSiteDownNotification($downsites));
        }
        
        // $response = Http::head('https://example.com');

        // $status = $response->status();
    }
}
