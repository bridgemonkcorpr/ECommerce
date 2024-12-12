<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Collection extends Model implements HasMedia
{
    use HasFactory;
    use HasSlug;
    use InteractsWithMedia;

    protected $casts = [
        'is_active' => 'boolean',
        'published_at' => 'datetime',
    ];

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
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
            ->useFallbackPath(public_path('/img/placeholder.png'))
            ->singleFile();

        $this->addMediaCollection('images');
    }

    public function products(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Product::class);
    }

    public function scopePublished($query)
    {
        return $query->where('published_at', '<=', now());
    }

    protected function status(): Attribute
    {
        return Attribute::make(
            get: fn($value, $attributes) => is_null($attributes['published_at']) ? 'Unavailable' : ($attributes['published_at'] > now() ? 'Scheduled' : 'Published'),
        );
    }

    protected function seoTitle(): Attribute
    {
        return Attribute::make(
            get: fn($value) => $value ?? \Str::of($this->title)->limit(66),
        );
    }

    protected function seoDescription(): Attribute
    {
        return Attribute::make(
            get: fn($value) => $value ?? \Str::of(strip_tags($this->description))->limit(316),
        );
    }
}
