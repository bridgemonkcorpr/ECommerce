<?php

namespace App\Http\Livewire\Setup;

use Artesaos\SEOTools\Traits\SEOTools;
use Livewire\Component;

class Setup extends Component
{
    use SEOTools;

    public function mount()
    {
        $this->seo()->setTitle(trans('Setup'));

        $this->seo()->setDescription(trans('Setup your store with ease. Our setup wizard will guide you through the process of setting up your store.'));
    }

    public function render()
    {
        return view('livewire.setup.setup')->layout('layouts.blank');
    }
}
