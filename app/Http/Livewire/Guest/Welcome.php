<?php

namespace App\Http\Livewire\Guest;

use App\Models\Carousel;
use App\Settings\TemplateSetting;
use Artesaos\SEOTools\Traits\SEOTools;
use Livewire\Component;

class Welcome extends Component
{
    use SEOTools;

    public function mount()
    {
        $this->seo()->setTitle($this->template_settings->home_page_title);

        $this->seo()->setDescription($this->template_settings->home_page_description);

        $this->seo()->opengraph()->addImage(asset('/img/social-card.jpg'), [
            'height' => 1260,
            'width' => 2400,
            'type' => 'image/jpeg'
        ]);

        $this->seo()->twitter()->addValue('card', 'summary_large_image');
    }

    public function getRandomProductsProperty(): \Illuminate\Database\Eloquent\Collection|array
    {
        return \App\Models\Product::query()
            ->with(['reviews', 'media'])
            ->where('name', 'like', "%xiaomi%")
            ->inRandomOrder()
            ->limit(8)
            ->get();
    }

    public function getTemplateSettingsProperty()
    {
        return app(TemplateSetting::class);
    }

    public function getCarouselsProperty()
    {
        return Carousel::with('slides.media')->get();
    }

    public function getHeroCarouselProperty()
    {
        if ($this->template_settings->home_page_hero_carousel_handle) {
            return $this->carousels
                ->where('slug', $this->template_settings->home_page_hero_carousel_handle)
                ->first();
        }
    }

    public function getPerkCarouselProperty()
    {
        if ($this->template_settings->home_page_perk_carousel_handle) {
            return $this->carousels
                ->where('slug', $this->template_settings->home_page_perk_carousel_handle)
                ->first();
        }
    }

    public function getCollectionCarouselProperty()
    {
        if ($this->template_settings->home_page_collection_section_carousel_handle) {
            return $this->carousels
                ->where('slug', $this->template_settings->home_page_collection_section_carousel_handle)
                ->first();
        }
    }

    public function render()
    {
        return view('livewire.guest.welcome')->layout('layouts.guest');
    }

    public function getAbout()
    {
        return view('livewire.guest.about')->layout('layouts.about');
    }
}
