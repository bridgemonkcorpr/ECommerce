<?php

namespace App\Models;

use App\Enums\ShippingCarrier;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shipment extends Model
{
    use HasFactory;

    protected $fillable = ['shipping_carrier', 'tracking_number', 'tracking_url', 'is_physical'];

    protected $casts = [
        'shipping_carrier' => ShippingCarrier::class,
        'is_physical' => 'boolean',
    ];

    public function order(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function shipmentItems(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(ShipmentItem::class);
    }
}
