<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class TemplateSetting extends Settings
{
    public string $home_page_title;

    public string $home_page_description;

    public string $home_page_hero_carousel_handle;

    public string $home_page_perk_carousel_handle;

    public array $home_page_sections;

    public static function group(): string
    {
        return 'template';
    }
}
