<?php

namespace App\Http\Livewire\Employee\Collection\Components;

use App\Models\Collection;
use Livewire\Component;
use Livewire\WithFileUploads;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig;

class CollectionCover extends Component
{
    use WithFileUploads;

    public Collection $collection;
    
    public $image;

    protected $listeners = ['refresh' => '$refresh', 'upload:finished' => 'save'];

    /**
     * @throws \Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist
     * @throws \Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig
     */
    public function save()
    {
        $this->validate([
            'image' => 'file|image|max:5120',
        ]);

        try {
            $this->collection
                ->addMedia($this->image->getRealPath())
                ->usingName(pathinfo($this->image->getClientOriginalName(), PATHINFO_FILENAME))
                ->usingFileName($this->image->getClientOriginalName())
                ->toMediaCollection('cover');
        } catch (FileDoesNotExist|FileIsTooBig $e) {
            $this->notify($e->getMessage());
        }

        $this->reset('image');

        $this->emit('refresh')->self();
    }

    public function delete()
    {
        $this->collection->getFirstMedia('cover')->delete();

        $this->emit('refresh')->self();
    }

    public function render()
    {
        return view('livewire.employee.collection.components.collection-cover');
    }
}
