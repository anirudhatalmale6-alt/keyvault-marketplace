<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    use HasFactory;

    protected $fillable = [
        'code', 'name', 'symbol', 'exchange_rate',
        'is_default', 'is_active', 'position',
    ];

    protected $casts = [
        'exchange_rate' => 'decimal:8',
        'is_default'    => 'boolean',
        'is_active'     => 'boolean',
        'position'      => 'integer',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /** Convert an amount from the base currency into this currency. */
    public function convert(float $baseAmount): float
    {
        return round($baseAmount * (float) $this->exchange_rate, 2);
    }
}
