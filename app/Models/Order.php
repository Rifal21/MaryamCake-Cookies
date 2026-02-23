<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'order_number',
        'customer_name',
        'customer_email',
        'customer_phone',
        'is_preorder',
        'delivery_date',
        'address',
        'total_price',
        'status',
        'notes',
        'tracking_number',
        'courier_name',
        'latitude',
        'longitude',
        'voucher_id',
        'voucher_code',
        'discount_amount',
        'payment_method_name',
        'payment_status',
        'admin_fee',
        'shipping_fee'
    ];

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function voucher()
    {
        return $this->belongsTo(Voucher::class);
    }
}
