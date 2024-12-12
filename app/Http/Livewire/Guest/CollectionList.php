<?php

namespace App\Http\Livewire\Guest;

use App\Models\Collection;
use Artesaos\SEOTools\Traits\SEOTools;
use Livewire\Component;

class CollectionList extends Component
{
    use SEOTools;

    public $perPage = 12;

    public function mount()
    {
        $this->seo()->setTitle(trans('All Collections'));

        $this->seo()->setDescription(trans('Explore our vast collection of fashion, accessories, home decor, electronics, and more. Find everything you need in one place. Shop now and discover your perfect collection.'));
    }

    public function getRowsQueryProperty()
    {
        return Collection::query()
            ->with('media')
            ->published()
            ->latest();
    }

    public function getRowsProperty()
    {
        return $this->rowsQuery->paginate($this->perPage);
    }

    public function render()
    {
        return view('livewire.guest.collection-list', [
            'collections' => $this->rows,
        ])->layout('layouts.guest');
    }
}
