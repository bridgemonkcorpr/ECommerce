<?php

namespace App\Http\Livewire\Employee\Product\Components;

use App\Models\Product;
use App\Models\Variant;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig;

class ProductVariantInventory extends Component
{
    public Product $product;

    public Variant $variant;

    public $digitalAttachment;

    protected function rules()
    {
        return [
            'variant.sku' => 'nullable|string|unique:variants,sku,' . $this->variant->id,
            'variant.barcode' => 'nullable|string|unique:variants,barcode,' . $this->variant->id,
            'variant.stock_value' => 'required|numeric|min:0',
            'variant.weight_value' => 'required|numeric|min:0',
            'variant.weight_unit' => ['required', Rule::in(['lb', 'oz', 'kg', 'g'])],
        ];
    }

    public function updatedVariantSKU($value)
    {
        if (!$value) $this->variant->sku = null;
    }

    public function updatedVariantBarcode($value)
    {
        if (!$value) $this->variant->barcode = null;
    }

    /**
     * @throws FileDoesNotExist
     * @throws FileIsTooBig
     */
    public function save()
    {
        $this->validate();

        $this->variant->save();

        $this->dispatchBrowserEvent('variant-inventory-updated');

        $this->notify(trans('Inventory updated.'));
    }

    public function render()
    {
        return view('livewire.employee.product.components.product-variant-inventory');
    }
}
