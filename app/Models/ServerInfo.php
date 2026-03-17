<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ServerInfo extends Model
{
    public $fillable = [
        'name',
        'ip',
        'description'
    ];

    public function serverCheck() : HasMany {
        return $this->hasMany(ServerCheck::class, 'server_id', 'id');
    }
}
