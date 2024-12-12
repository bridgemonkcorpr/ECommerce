<?php

namespace App\Http\Livewire\Employee\Product\Components;

use App\Models\Product;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileCannotBeAdded;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class ProductInformation extends Component
{
    use WithFileUploads;

    public Product $product;
    public $image;
    public $imageUrl;
    public $selectedImage;
    public $showImageModal = false;

    protected $listeners = ['openImageModal'];

    protected function rules()
    {
        return [
            'product.name' => ['required', 'string'],
            'product.slug' => ['required', 'string'],
            'product.excerpt' => ['nullable', 'string'],
            'product.price' => ['required', 'numeric'],
            'product.description' => ['nullable', 'string'],
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
        $this->product
            ->addMedia($this->image->getRealPath())
            ->usingName(pathinfo($this->image->getClientOriginalName(), PATHINFO_FILENAME))
            ->usingFileName($this->image->getClientOriginalName())
            ->toMediaCollection('images');

        $this->product->load(['media' => function ($query) {
            return $query->latest();
        }]);

        $this->reset('image');

        $this->dispatchBrowserEvent('upload-image-success', ['imageId' => $this->product->getMedia('images')->last()->id]);
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

        $this->product->addMediaFromUrl($this->imageUrl)
            ->toMediaCollection('images');

        $this->product->load(['media' => function ($query) {
            return $query->latest();
        }]);

        $this->reset('imageUrl');

        $this->dispatchBrowserEvent('upload-image-success', ['imageId' => $this->product->getMedia('images')->last()->id]);
    }

    public function insertImage(Media $image)
    {
        $this->dispatchBrowserEvent('tiptap-insert-image', ['name' => $image->name, 'url' => $image->getFullUrl()]);

        $this->showImageModal = false;
    }

    public function deleteImage(Media $image)
    {
        $image->delete();

        $this->product->load(['media' => function ($query) {
            return $query->latest();
        }]);
    }

    public function save()
    {
        $this->validate();

        $this->product->save();

        $this->emit('refresh');

        $this->notify(trans('Product information updated.'));
    }

    public function render()
    {
        return view('livewire.employee.product.components.product-information');
    }
}
