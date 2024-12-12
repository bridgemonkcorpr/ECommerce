<?php

namespace App\Http\Livewire\Employee\Product\Components;

use App\Models\Product;
use App\Models\Variant;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig;

class ProductVariantShipping extends Component
{
    use WithFileUploads;

    public Product $product;

    public Variant $variant;

    public $attachment;

    protected $listeners = ['refresh' => '$refresh', 'upload:finished' => 'attachmentUploaded'];

    protected function rules()
    {
        return [
            'variant.shipping_type' => ['required', Rule::in(['physical', 'digital'])],
            'variant.weight_value' => ['required_if:variant.shipping_type,physical', 'numeric', 'min:0'],
            'variant.weight_unit' => ['required_if:variant.shipping_type,physical', Rule::in(['kg', 'g', 'lb', 'oz'])],
        ];
    }

    public function attachmentUploaded(): void
    {
        $this->dispatchBrowserEvent('variant-attachment-uploaded');
    }

    public function downloadAttachment(): ?\Spatie\MediaLibrary\MediaCollections\Models\Media
    {
        return $this->variant->getFirstMedia('attachment');
    }

    public function deleteAttachment(): void
    {
        if ($this->attachment) {
            $this->reset('attachment');
        }

        if ($this->variant->getFirstMedia('attachment')) {
            $this->variant->getFirstMedia('attachment')->delete();
        }

        $this->emitSelf('refresh');

        $this->dispatchBrowserEvent('variant-attachment-deleted');
    }

    public function save()
    {
        $this->validate();

        if ($this->attachment) {
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
        }

        $this->variant->save();

        $this->emit('refresh')->self();

        $this->dispatchBrowserEvent('variant-shipping-updated');
    }

    public function render()
    {
        return view('livewire.employee.product.components.product-variant-shipping');
    }
}
