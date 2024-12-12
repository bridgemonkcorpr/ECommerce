<?php

namespace App\Http\Livewire\Employee\Collection\Components;

use App\Models\Collection;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileCannotBeAdded;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class CollectionInformation extends Component
{
    use WithFileUploads;

    public Collection $collection;
    public $image;
    public $imageUrl;
    public $selectedImage;
    public $showImageModal = false;

    protected $listeners = ['openImageModal'];

    protected function rules()
    {
        return [
            'collection.title' => ['required', 'string'],
            'collection.slug' => ['required', 'string', Rule::unique('collections', 'slug')->ignoreModel($this->collection)],
            'collection.description' => ['nullable', 'string'],
        ];
    }

    /**
     * @throws FileDoesNotExist
     * @throws FileIsTooBig
     */
    public function updatedImage()
    {
        $this->validate([
            'image' => 'required|image|max:5120',
        ]);

        $this->uploadImageFromFile();
    }

    public function openImageModal()
    {
        $this->showImageModal = true;
    }

    /**
     * @throws FileDoesNotExist
     * @throws FileIsTooBig
     */
    public function uploadImageFromFile()
    {
        $this->collection
            ->addMedia($this->image->getRealPath())
            ->usingName(pathinfo($this->image->getClientOriginalName(), PATHINFO_FILENAME))
            ->usingFileName($this->image->getClientOriginalName())
            ->toMediaCollection('images');

        $this->collection->load(['media' => function ($query) {
            return $query->latest();
        }]);

        $this->reset('image');

        $this->dispatchBrowserEvent('upload-image-success', ['imageId' => $this->collection->getMedia('images')->last()->id]);
    }

    /**
     * @throws FileCannotBeAdded
     * @throws FileDoesNotExist
     * @throws FileIsTooBig
     */
    public function uploadImageFromURL()
    {
        $this->validate([
            'imageUrl' => 'required|url',
        ]);

        $this->collection->addMediaFromUrl($this->imageUrl)
            ->toMediaCollection('images');

        $this->collection->load(['media' => function ($query) {
            return $query->latest();
        }]);

        $this->reset('imageUrl');

        $this->dispatchBrowserEvent('upload-image-success', ['imageId' => $this->collection->getMedia('images')->last()->id]);
    }

    public function insertImage(Media $image)
    {
        $this->dispatchBrowserEvent('tiptap-insert-image', ['name' => $image->name, 'url' => $image->getFullUrl()]);

        $this->showImageModal = false;
    }

    public function deleteImage(Media $image)
    {
        $image->delete();

        $this->collection->load(['media' => function ($query) {
            return $query->latest();
        }]);
    }

    public function save()
    {
        $this->validate();

        $this->collection->save();

        $this->notify(trans('Collection information updated.'));
    }

    public function render()
    {
        return view('livewire.employee.collection.components.collection-information');
    }
}
