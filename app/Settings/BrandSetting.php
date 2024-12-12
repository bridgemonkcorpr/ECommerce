<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class BrandSetting extends Settings
{
    public string $slogan;

    public string $short_description;

    public string $logo_path;

    public string $favicon_path;

    public string $cover_path;

    public array $social_links;

    public static function group(): string
    {
        return 'brand';
    }
}
