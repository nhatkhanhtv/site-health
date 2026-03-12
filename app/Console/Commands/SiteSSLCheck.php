<?php

namespace App\Console\Commands;

use App\Models\Site;
use App\Services\SSLCheckService;
use Illuminate\Console\Command;

class SiteSSLCheck extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'site:ssl-check';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check the SSL certificate of a site in site list';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $siteList = Site::select(['id','site_name'])->orderBy('id','desc')->get();
        $sslCheckService = new SSLCheckService();

        foreach($siteList as $site) {
            $checkResult = $sslCheckService->check($site->site_name);
            $site->ssl_expire_date = $checkResult['expiry'];
            $site->ssl_is_valid = $checkResult['id_valid'];
            $site->ssl_issuer = $checkResult['issuer'];
            $site->error = $checkResult['error'];
            $site->ssl_last_checked_at = now();
            $site->save();
            
        }
        

    }
}
