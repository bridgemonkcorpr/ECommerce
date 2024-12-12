<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class CheckoutSetting extends Settings
{
    public bool $requires_login;

    public static function group(): string
    {
        return 'checkout';
    }
}
