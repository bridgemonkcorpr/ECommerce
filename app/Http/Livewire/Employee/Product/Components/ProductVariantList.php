<?php

namespace App\Http\Livewire\Employee\Product\Components;

use App\Models\Product;
use Livewire\Component;

class ProductVariantList extends Component
{
    public Product $product;

    protected $listeners = ['reloadProductVariants'];

    public function mount()
    {
        $this->product->load('variants.variantAttributes.optionValue', 'variants.media');
    }

    public function reloadProductVariants()
    {
        $this->product->load('variants.variantAttributes.optionValue', 'variants.media');
    }

    public function render()
    {
        return view('livewire.employee.product.components.product-variant-list');
    }
}
