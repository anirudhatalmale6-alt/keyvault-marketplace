<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'category_id', 'supplier_id', 'name', 'slug', 'sku',
        'short_description', 'description', 'image', 'type', 'fulfillment',
        'base_price', 'cost_price', 'stock', 'status', 'is_featured',
        'supplier_product_id', 'meta',
    ];

    protected $casts = [
        'base_price'  => 'decimal:2',
        'cost_price'  => 'decimal:2',
        'stock'       => 'integer',
        'is_featured' => 'boolean',
        'meta'        => 'array',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class);
    }

    public function keys(): HasMany
    {
        return $this->hasMany(ProductKey::class);
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    /**
     * Available stock: uploaded keys for manual products, virtually
     * unlimited for API-fulfilled products (bought on demand).
     */
    public function availableStock(): int
    {
        if ($this->fulfillment === 'api') {
            return PHP_INT_MAX;
        }

        return $this->keys()->where('status', 'available')->count();
    }

    public function isInStock(): bool
    {
        return $this->availableStock() > 0;
    }

    /** Profit margin for this product in the base currency. */
    public function margin(): float
    {
        return (float) $this->base_price - (float) $this->cost_price;
    }
}
