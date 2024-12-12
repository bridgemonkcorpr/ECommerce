<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration {
    public function up(): void
    {
        $this->migrator->add('template.home_page_title', 'Modernize Your Home, Simplify Your Day with Our Appliances and Gadgets.');
        $this->migrator->add('template.home_page_description', 'Discover a vast selection of top-notch home appliances and electronic gadgets. Elevate your living with innovative, energy-efficient solutions.');
        $this->migrator->add('template.home_page_hero_carousel_handle', '');
        $this->migrator->add('template.home_page_perk_carousel_handle', '');
        $this->migrator->add('template.home_page_sections', []);
    }

    public function down()
    {
        $this->migrator->deleteIfExists('template.home_page_title');
        $this->migrator->deleteIfExists('template.home_page_description');
        $this->migrator->deleteIfExists('template.home_page_hero_carousel_handle');
        $this->migrator->deleteIfExists('template.home_page_perk_carousel_handle');
        $this->migrator->deleteIfExists('template.home_page_sections');
    }
};
