<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteVisit extends Model
{
    protected $fillable = ['session_id', 'ip_address', 'user_agent', 'last_activity_at'];

    protected $casts = [
        'last_activity_at' => 'datetime',
    ];
}
