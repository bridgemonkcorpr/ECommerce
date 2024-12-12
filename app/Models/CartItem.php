<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    use HasFactory;

    protected $fillable = ['product_id', 'variant_id', 'quantity'];

    protected $casts = [
        'quantity' => 'integer',
    ];

    protected $with = ['discount'];

    public function cart(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Cart::class);
    }

    public function product(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function variant(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Variant::class);
    }

    public function discount(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(CartDiscount::class);
    }

    public function getNameAttribute()
    {
        return $this->product->name;
    }

    public function getPriceAttribute()
    {
        return $this->variant->price;
    }

    public function getSubtotalAttribute(): float
    {
        return $this->variant->price * $this->quantity;
    }

    public function getDiscountedAmountAttribute()
    {
        return $this->discount ? ($this->discount->type === 'fixed' ? $this->discount->amount : $this->subtotal * $this->discount->amount / 100) : 0;
    }

    public function getDiscountedPriceAttribute()
    {
        return $this->subtotal - $this->discountedAmount;
    }
}
