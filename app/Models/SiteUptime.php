<?php

namespace App\Models;

use App\UptimeStatus;
use Illuminate\Database\Eloquent\Model;

class SiteUptime extends Model
{
    public $timestamps = false;

    protected $casts = [
        'status' => UptimeStatus::class,
    ];
}
