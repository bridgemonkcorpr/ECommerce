<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration {
    public function up(): void
    {
        $this->migrator->add('brand.slogan', 'Modernize Your Home, Simplify Your Day with Our Appliances and Gadgets.');
        $this->migrator->add('brand.short_description', 'Discover a vast selection of top-notch home appliances and electronic gadgets. Elevate your living with innovative, energy-efficient solutions.');
        $this->migrator->add('brand.logo_path', '');
        $this->migrator->add('brand.favicon_path', '');
        $this->migrator->add('brand.cover_path', '');
        $this->migrator->add('brand.social_links', [
            [
                'name' => 'Facebook',
                'url' => '',
                'url_placeholder' => 'https://facebook.com/thinkofbest',
            ],
            [
                'name' => 'Twitter',
                'url' => '',
                'url_placeholder' => 'https://twitter.com/thinkofbest',
            ],
            [
                'name' => 'Pinterest',
                'url' => '',
                'url_placeholder' => 'https://pinterest.com/thinkofbest',
            ],
            [
                'name' => 'Instagram',
                'url' => '',
                'url_placeholder' => 'https://instagram.com/thinkofbest',
            ],
            [
                'name' => 'TikTok',
                'url' => '',
                'url_placeholder' => 'https://tiktok.com/@thinkofbest',
            ],
            [
                'name' => 'Tumblr',
                'url' => '',
                'url_placeholder' => 'https://thinkofbest.tumblr.com',
            ],
            [
                'name' => 'Snapchat',
                'url' => '',
                'url_placeholder' => 'https://snapchat.com/add/thinkofbest',
            ],
            [
                'name' => 'YouTube',
                'url' => '',
                'url_placeholder' => 'https://youtube.com/c/thinkofbest',
            ],
            [
                'name' => 'Vimeo',
                'url' => '',
                'url_placeholder' => 'https://vimeo.com/thinkofbest',
            ],
        ]);
    }

    public function down()
    {
        $this->migrator->deleteIfExists('brand.slogan');
        $this->migrator->deleteIfExists('brand.short_description');
        $this->migrator->deleteIfExists('brand.logo_path');
        $this->migrator->deleteIfExists('brand.favicon_path');
        $this->migrator->deleteIfExists('brand.cover_path');
        $this->migrator->deleteIfExists('brand.socials');
    }
};
