<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'type',
        'value',
        'applies_to',
        'starts_at',
        'ends_at',
    ];

    protected $casts = [
        'value' => 'float',
        'starts_at' => 'datetime',
        'ends_at' => 'datetime',
    ];

    public function collections(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Collection::class, 'discount_collection');
    }

    public function products(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Product::class);
    }

    protected function status(): Attribute
    {
        return Attribute::make(
            get: function () {
                if ($this->starts_at->isFuture()) {
                    return __('scheduled');
                } elseif ($this->ends_at && $this->ends_at->isPast()) {
                    return __('expired');
                } else {
                    return __('active');
                }
            }
        );
    }
}
