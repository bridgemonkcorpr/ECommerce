<?php

namespace App\Http\Livewire\Employee\Product\Components;

use App\Models\Product;
use App\Models\Variant;
use Livewire\Component;
use Livewire\WithFileUploads;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig;

class ProductVariantAttachment extends Component
{
    use WithFileUploads;

    public Product $product;

    public Variant $variant;

    public $attachment;

    protected $listeners = ['refresh' => '$refresh', 'upload:finished' => 'save'];

    public function save()
    {
        $this->validate([
            'attachment' => 'file|max:5242880',
        ]);

        try {
            $this->variant
                ->addMedia($this->attachment->getRealPath())
                ->usingName(pathinfo($this->attachment->getClientOriginalName(), PATHINFO_FILENAME))
                ->usingFileName($this->attachment->getClientOriginalName())
                ->toMediaCollection('attachment');
        } catch (FileDoesNotExist|FileIsTooBig $e) {
            $this->notify($e->getMessage());
        }

        $this->reset('attachment');

        $this->emitSelf('refresh');
    }

    public function delete()
    {
        $this->variant->getFirstMedia('attachment')->delete();

        $this->emitSelf('refresh');
    }

    public function download()
    {
        return $this->variant->getFirstMedia('attachment');
    }

    public function render()
    {
        return view('livewire.employee.product.components.product-variant-attachment');
    }
}
