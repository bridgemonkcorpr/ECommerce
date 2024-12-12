<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration {
    public function up(): void
    {
        $this->migrator->add('checkout.requires_login', false);
    }

    public function down(): void
    {
        $this->migrator->deleteIfExists('checkout.requires_login');
    }
};
