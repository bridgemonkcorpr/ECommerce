<?php

namespace App\Http\Livewire\Guest;

use App\Models\Carousel;
use App\Settings\TemplateSetting;
use Artesaos\SEOTools\Traits\SEOTools;
use Livewire\Component;

class About extends Component
{


    public function render()
    {
        return view('livewire.guest.about');
    }
}
