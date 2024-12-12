<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration {
    public function up(): void
    {
        $this->migrator->add('layout.header_top_bar_enabled', true);
        $this->migrator->add('layout.header_top_bar_message', 'Welcome to our store!');
        $this->migrator->add('layout.header_top_bar_menu_handle', '');
        $this->migrator->add('layout.header_main_menu_handle', '');
        $this->migrator->add('layout.footer_bottom_bar_enabled', true);
        $this->migrator->add('layout.footer_bottom_bar_message', '© ' . now()->year . ' All rights reserved.');
        $this->migrator->add('layout.footer_bottom_bar_menu_handle', '');
        $this->migrator->add('layout.footer_main_menu_handle', '');

    }

    public function down()
    {
        $this->migrator->deleteIfExists('layout.header_top_bar_enabled');
        $this->migrator->deleteIfExists('layout.header_top_bar_message');
        $this->migrator->deleteIfExists('layout.header_top_bar_menu_handle');
        $this->migrator->deleteIfExists('layout.header_main_menu_handle');
        $this->migrator->deleteIfExists('layout.footer_bottom_bar_enabled');
        $this->migrator->deleteIfExists('layout.footer_bottom_bar_message');
        $this->migrator->deleteIfExists('layout.footer_bottom_bar_menu_handle');
        $this->migrator->deleteIfExists('layout.footer_main_menu_handle');
    }
};
