<?php

namespace App\Models;

use App\UptimeStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Site extends Model
{
    public $fillable = [
        'site_name',
        'time_interval'
    ];

    

    public function uptimes() : HasMany {
        return $this->hasMany(SiteUptime::class, 'site_id', 'id');
    }

    public function lastestUptime() {
        return $this->hasOne(SiteUptime::class, 'site_id', 'id')->latestOfMany('checked_at');
    }
}
