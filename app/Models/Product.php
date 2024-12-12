<?php

namespace App\Models;

use App\Enums\ProductStatus;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Product extends Model implements HasMedia
{
    use HasFactory;
    use HasSlug;
    use InteractsWithMedia;

    protected $attributes = ['price' => 0];

    protected $casts = [
        'price' => 'float',
        'status' => ProductStatus::class,
        'is_active' => 'boolean',
        'is_published' => 'boolean',
        'published_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();

        static::created(function (Product $product) {
            $variant = new Variant();
            $variant->product_id = $product->id;
            $variant->price = $product->price;
            $variant->save();
        });
    }

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug')
            ->preventOverwrite()
            ->doNotGenerateSlugsOnUpdate();
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('cover')
            ->useFallbackUrl('/img/placeholder.png')
            ->useFallbackPath(public_path('img/placeholder.png'))
            ->singleFile();

        $this->addMediaCollection('gallery')
            ->useFallbackPath(public_path('img/placeholder.png'))
            ->useFallbackUrl('/img/placeholder.png');
    }

    /**
     * @throws \Spatie\Image\Exceptions\InvalidManipulation
     */
    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')->performOnCollections('gallery')->width(100)->height(100);
        $this->addMediaConversion('thumb_small')->performOnCollections('gallery')->width(50)->height(50);
        $this->addMediaConversion('thumb_large')->performOnCollections('gallery')->width(200)->height(200);
        $this->addMediaConversion('responsive')->performOnCollections('gallery')->withResponsiveImages();
    }

    public function options(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Option::class);
    }

    public function optionValues(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(OptionValue::class);
    }

    public function variants(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Variant::class);
    }

    public function variantAttributes(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(VariantAttribute::class);
    }

    public function collections(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Collection::class);
    }

    public function reviews(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function metas(): \Illuminate\Database\Eloquent\Relations\MorphMany
    {
        return $this->morphMany(Meta::class, 'metable');
    }

    public function specifications(): \Illuminate\Database\Eloquent\Relations\MorphMany
    {
        return $this->morphMany(Meta::class, 'metable')->where('key', 'specifications');
    }

    public function scopeActive($query)
    {
        return $query->where('status', ProductStatus::ACTIVE->name);
    }

    public function scopePublished($query)
    {
        return $query->where('published_at', '<=', now());
    }

    protected function isActive(): Attribute
    {
        return Attribute::make(
            get: fn($value, $attributes) => $attributes['status'] === ProductStatus::ACTIVE->name,
        );
    }

    protected function isPublished()
    {
        return Attribute::make(
            get: fn($value, $attributes) => $attributes['published_at'] <= now(),
        );
    }

    protected function price(): Attribute
    {
        $thousand_separator = config('money.' . config('app.currency') . '.thousands_separator');

        return Attribute::make(
            set: fn($value) => str_replace($thousand_separator, '', $value)
        );
    }

    protected function seoTitle(): Attribute
    {
        return Attribute::make(
            get: fn($value) => $value ?: \Str::of($this->name)->limit(66),
        );
    }

    protected function seoDescription(): Attribute
    {
        return Attribute::make(
            get: fn($value) => $value ?: \Str::of(strip_tags($this->description))->limit(316),
        );
    }
}
