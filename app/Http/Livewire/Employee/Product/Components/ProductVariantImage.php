<?php

namespace App\Http\Livewire\Employee\Product\Components;

use App\Models\Product;
use App\Models\Variant;
use Livewire\Component;
use Livewire\WithFileUploads;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig;

class ProductVariantImage extends Component
{
    use WithFileUploads;

    public Product $product;

    public Variant $variant;

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
            $this->variant
                ->addMedia($this->image->getRealPath())
                ->usingName(pathinfo($this->image->getClientOriginalName(), PATHINFO_FILENAME))
                ->usingFileName($this->image->getClientOriginalName())
                ->toMediaCollection('image');
        } catch (FileDoesNotExist|FileIsTooBig $e) {
            $this->notify($e->getMessage());
        }

        $this->reset('image');

        $this->emit('refresh');
    }

    public function delete()
    {
        $this->variant->getFirstMedia('image')->delete();

        $this->emit('refresh');
    }

    public function render()
    {
        return view('livewire.employee.product.components.product-variant-image');
    }
}
