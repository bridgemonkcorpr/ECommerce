<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration {
    public function up(): void
    {
        $this->migrator->add('general.store_name', config('app.name'));
        $this->migrator->add('general.contact_email', '');
        $this->migrator->add('general.contact_phone', '');
        $this->migrator->add('general.cookie_consent_enabled', false);
        $this->migrator->add('general.cookie_consent_message', 'We uses cookies to ensure you get the best experience on our website.');
        $this->migrator->add('general.cookie_consent_agree', 'Allow cookies');
        $this->migrator->add('general.cookie_consent_reject', 'Decline');
        $this->migrator->addEncrypted('general.license_key', '');
        $this->migrator->addEncrypted('general.license_user', '');
        $this->migrator->add('general.license_vendor', 'Envato');
        $this->migrator->add('general.license_active', false);
        $this->migrator->add('general.setup_finished', false);
    }

    public function down()
    {
        $this->migrator->deleteIfExists('general.store_name');
        $this->migrator->deleteIfExists('general.contact_email');
        $this->migrator->deleteIfExists('general.contact_phone');
        $this->migrator->deleteIfExists('general.cookie_consent_enabled');
        $this->migrator->deleteIfExists('general.cookie_consent_message');
        $this->migrator->deleteIfExists('general.cookie_consent_agree');
        $this->migrator->deleteIfExists('general.cookie_consent_reject');
        $this->migrator->deleteIfExists('general.license_key');
        $this->migrator->deleteIfExists('general.license_user');
        $this->migrator->deleteIfExists('general.license_vendor');
        $this->migrator->deleteIfExists('general.license_active');
        $this->migrator->deleteIfExists('general.setup_finished');
    }
};
