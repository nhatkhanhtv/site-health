<?php

namespace App\Models;

use App\UptimeStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SiteUptime extends Model
{
    public $timestamps = false;
    

    protected $casts = [
        'status' => UptimeStatus::class,
    ];

    public function siteInfo() :BelongsTo {
        return $this->belongsTo(Site::class, 'site_id');
    }

    // public static function booted() : void {
    //     self::created(function($siteUptime) {
    //         if($siteUptime->status == UptimeStatus::FAIL) {
                
    //            Notification::route('slack',config('services.slack.notifications.channel'))
    //                 ->notify(new AlertSiteDownNotification($siteUptime));
    //         }
    //     });
    // }

}
