<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Variant extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;

    protected $fillable = ['sku', 'barcode', 'price', 'compare_price', 'cost_price', 'stock_tracking', 'stock_value', 'shipping_type', 'weight_value', 'weight_unit'];

    protected $casts = [
        'price' => 'float',
        'compare_price' => 'float',
        'cost_price' => 'float',
        'stock_value' => 'float',
        'weight_value' => 'float',
        'on_sale' => 'boolean',
    ];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('image')
            ->singleFile()
            ->useFallbackUrl('/img/placeholder.png')
            ->useFallbackPath(public_path('/img/placeholder.png'));

        $this->addMediaCollection('attachment')->singleFile();
    }

    /**
     * @throws \Spatie\Image\Exceptions\InvalidManipulation
     */
    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')->performOnCollections('image')->width(100)->height(100);
        $this->addMediaConversion('thumb_small')->performOnCollections('image')->width(50)->height(50);
        $this->addMediaConversion('thumb_large')->performOnCollections('image')->width(200)->height(200);
        $this->addMediaConversion('responsive')->withResponsiveImages()->performOnCollections('image');
    }

    public function product(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function variantAttributes(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(VariantAttribute::class);
    }

    protected function price(): Attribute
    {
        $thousand_separator = config('money.' . config('app.currency') . '.thousands_separator');

        return Attribute::make(
            set: fn($value) => str_replace($thousand_separator, '', $value)
        );
    }

    protected function comparePrice(): Attribute
    {
        $thousand_separator = config('money.' . config('app.currency') . '.thousands_separator');

        return Attribute::make(
            set: fn($value) => str_replace($thousand_separator, '', $value)
        );
    }

    protected function costPrice(): Attribute
    {
        $thousand_separator = config('money.' . config('app.currency') . '.thousands_separator');

        return Attribute::make(
            set: fn($value) => str_replace($thousand_separator, '', $value)
        );
    }

    protected function profitMargin(): Attribute
    {
        return Attribute::make(
            get: fn($value) => round($this->gross_profit / $this->price * 100, 1)
        );
    }

    protected function grossProfit(): Attribute
    {
        return Attribute::make(
            get: fn($value, $attributes) => $attributes['price'] - $attributes['cost_price']
        );
    }

    protected function onSale(): Attribute
    {
        return Attribute::make(
            get: fn($value, $attributes) => $attributes['compare_price'] > $attributes['price']
        );
    }
}
