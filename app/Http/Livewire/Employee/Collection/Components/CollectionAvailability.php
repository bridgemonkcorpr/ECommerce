<?php

namespace App\Http\Livewire\Employee\Collection\Components;

use App\Models\Collection;
use Livewire\Component;

class CollectionAvailability extends Component
{
    public Collection $collection;

    public $published_at;

    public function mount()
    {
        $this->published_at = $this->collection->published_at ? $this->collection->published_at->toDateTimeString() : null;
    }

    public function save()
    {
        $this->collection->published_at = $this->published_at;

        $this->collection->save();

        $this->notify(trans('Collection availability updated.'));

        $this->dispatchBrowserEvent('collection-availability-updated');
    }

    public function render()
    {
        return view('livewire.employee.collection.components.collection-availability');
    }
}
