<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    protected $fillable = [
        'name',
        'account_name',
        'account_number',
        'instructions',
        'is_active',
        'admin_fee'
    ];

    protected $casts = [
        'is_active' => 'boolean'
    ];
}
