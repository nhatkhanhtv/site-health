<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ServerCheck extends Model
{
    public $fillable = [
        'server_id',
        'ram',
        'disk',
        'cpu'
    ];

    public function serverInfo() : BelongsTo {
        return $this->belongsTo(ServerInfo::class, 'server_id', 'id');
    }
}
