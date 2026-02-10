<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Voucher extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'type',
        'value',
        'min_spend',
        'start_date',
        'end_date',
        'max_uses',
        'used_count',
        'is_active',
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'is_active' => 'boolean',
    ];

    public function isValid(): bool
    {
        if (!$this->is_active) {
            return false;
        }

        $now = now();
        if ($this->start_date && $this->start_date->isFuture()) {
            return false;
        }

        if ($this->end_date && $this->end_date->isPast()) {
            return false;
        }

        if ($this->max_uses && $this->used_count >= $this->max_uses) {
            return false;
        }

        return true;
    }

    public function calculateDiscount($total): float
    {
        if ($this->type === 'percentage') {
            return round(($total * $this->value) / 100, 2);
        }

        return min($this->value, $total);
    }

    public function getStatusAttribute(): string
    {
        if (!$this->is_active) {
            return 'Inactive';
        }

        $now = now();
        if ($this->start_date && $this->start_date->isFuture()) {
            return 'Scheduled';
        }

        if ($this->end_date && $this->end_date->isPast()) {
            return 'Expired';
        }

        if ($this->max_uses && $this->used_count >= $this->max_uses) {
            return 'Limit Reached';
        }

        return 'Active';
    }
}
