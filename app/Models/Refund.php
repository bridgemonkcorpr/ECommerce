<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Refund extends Model
{
    use HasFactory;

    protected $casts = [
        'amount' => 'float',
        'meta' => 'json',
    ];

    protected $fillable = [
        'amount',
        'reason',
        'meta',
    ];
    
    public function refundItems(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(RefundItem::class);
    }

    protected function amount(): Attribute
    {
        $thousand_separator = config('money.' . config('app.currency') . '.thousands_separator');

        return Attribute::make(
            set: fn($value) => str_replace($thousand_separator, '', $value)
        );
    }
}
