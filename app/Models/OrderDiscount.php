<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDiscount extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_item_id',
        'code',
        'type',
        'amount',
    ];

    public function orderItem(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(OrderItem::class);
    }

    protected function discountedAmount(): Attribute
    {
        return Attribute::make(
            get: fn($value) => $this->type === 'fixed' ? $this->amount : $this->amount * ($this->orderItem->subtotal / 100),
        );
    }
}
