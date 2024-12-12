<?php

namespace App\Http\Livewire\Employee\Collection;

use App\Models\Collection;
use Livewire\Component;

class CollectionDetail extends Component
{
    public Collection $collection;

    public bool $confirmingCollectionDeletion = false;

    public function delete()
    {
        $this->collection->delete();

        $this->redirect(route('employee.collections.list'));
    }

    public function render()
    {
        return view('livewire.employee.collection.collection-detail')->layout('layouts.admin');
    }
}
