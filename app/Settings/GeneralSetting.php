<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class GeneralSetting extends Settings
{
    public string $store_name;

    public string $contact_email;

    public string $contact_phone;

    public bool $cookie_consent_enabled;

    public string $cookie_consent_message;

    public string $cookie_consent_agree;

    public string $cookie_consent_reject;

    public string $license_key;

    public string $license_user;

    public string $license_vendor;

    public bool $license_active;

    public bool $setup_finished;

    public static function group(): string
    {
        return 'general';
    }

    public static function encrypted(): array
    {
        return [
            'license_key',
            'license_user',
        ];
    }
}
