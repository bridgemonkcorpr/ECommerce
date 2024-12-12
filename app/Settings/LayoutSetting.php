<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class LayoutSetting extends Settings
{
    public bool $header_top_bar_enabled;

    public string $header_top_bar_message;

    public string $header_top_bar_menu_handle;

    public string $header_main_menu_handle;

    public bool $footer_bottom_bar_enabled;

    public string $footer_bottom_bar_message;

    public string $footer_bottom_bar_menu_handle;

    public string $footer_main_menu_handle;

    public static function group(): string
    {
        return 'layout';
    }
}
