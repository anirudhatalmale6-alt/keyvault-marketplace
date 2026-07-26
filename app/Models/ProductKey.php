<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductKey extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id', 'order_item_id', 'code', 'status', 'delivered_at',
    ];

    protected $casts = [
        'delivered_at' => 'datetime',
        // The key/code is encrypted at rest and transparently decrypted on read.
        'code'         => 'encrypted',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function orderItem(): BelongsTo
    {
        return $this->belongsTo(OrderItem::class);
    }

    public function scopeAvailable($query)
    {
        return $query->where('status', 'available');
    }
}
