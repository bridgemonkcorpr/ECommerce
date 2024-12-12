<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShippingZoneRate extends Model
{
    use HasFactory;

    protected $attributes = [
        'price' => 0,
    ];

    protected $casts = [
        'price' => 'float',
        'min_value' => 'float',
        'max_value' => 'float',
        'hasConditions' => 'boolean',
    ];

    public function zone(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(ShippingZone::class, 'shipping_zone_id');
    }

    protected function price(): Attribute
    {
        $thousand_separator = config('money.' . config('app.currency') . '.thousands_separator');

        return Attribute::make(
            set: fn($value) => str_replace($thousand_separator, '', $value)
        );
    }

    protected function hasConditions(): Attribute
    {
        return new Attribute(
            get: fn() => $this->based_on || $this->min_value || $this->max_value
        );
    }
}
