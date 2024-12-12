<?php

namespace App\Models;

use App\Enums\OrderStatus;
use App\Enums\PaymentStatus;
use App\Enums\ShippingStatus;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'customer_email',
        'order_status',
        'payment_method_id',
        'payment_status',
        'shipping_status',
        'shipping_rate',
        'shipping_price',
        'tax_breakdown',
        'meta',
        'notes',
    ];

    protected $casts = [
        'order_status' => OrderStatus::class,
        'payment_status' => PaymentStatus::class,
        'shipping_price' => 'float',
        'shipping_status' => ShippingStatus::class,
        'tax_breakdown' => 'json',
        'meta' => 'json',
    ];

    protected $attributes = [
        'shipping_price' => 0,
    ];

    public function customer(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function addresses(): \Illuminate\Database\Eloquent\Relations\MorphMany
    {
        return $this->morphMany(Address::class, 'addressable')->latest();
    }

    public function billingAddress(): \Illuminate\Database\Eloquent\Relations\MorphOne
    {
        return $this->morphOne(Address::class, 'addressable')->where('is_billing', true);
    }

    public function shippingAddress(): \Illuminate\Database\Eloquent\Relations\MorphOne
    {
        return $this->morphOne(Address::class, 'addressable')->where('is_billing', false);
    }

    public function orderDiscounts(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(OrderDiscount::class);
    }

    public function orderItems(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function paymentMethod(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(PaymentMethod::class);
    }

    public function payments(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Payment::class);
    }

    public function refunds(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Refund::class);
    }

    public function refundItems(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(RefundItem::class);
    }

    public function shipments(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Shipment::class);
    }

    public function shipmentItems(): \Illuminate\Database\Eloquent\Relations\HasManyThrough
    {
        return $this->hasManyThrough(ShipmentItem::class, Shipment::class);
    }

    protected function subtotal(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->orderItems->reduce(function ($value, $item) {
                return $value + $item->subtotal;
            }, 0)
        );
    }

    protected function discountTotal(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->orderDiscounts->reduce(function ($value, $discount) {
                return $value + $discount->discounted_amount;
            }, 0)
        );
    }

    protected function taxTotal(): Attribute
    {
        return Attribute::make(
            get: fn() => collect($this->tax_breakdown)->reduce(function ($value, $line) {
                return $value + ($this->subtotal - $this->discount_total) * $line['percentage'] / 100;
            }, 0),
        );
    }

    protected function total(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->subtotal - $this->discount_total + $this->tax_total + $this->shipping_price
        );
    }

    public function totalPaid(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->payments->reduce(fn($value, $payment) => $value + $payment->amount, 0)
        );
    }

    public function totalRefunded(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->refunds->reduce(fn($value, $refund) => $value + $refund->amount, 0)
        );
    }

    protected static function booted()
    {
        static::creating(function ($order) {
            if ($order->tax_breakdown === null) {
                $order->tax_breakdown = [];
            }

            if ($order->meta === null) {
                $order->meta = [];
            }
        });
    }
}
