<?php

namespace App\Http\Livewire\Employee\Product;

use App\Models\Product;
use App\Models\Variant;
use Livewire\Component;

class ProductVariantDetail extends Component
{
    public Product $product;

    public Variant $variant;

    protected $listeners = ['refresh' => '$refresh'];

    public function mount()
    {
        $this->product->load('variants.variantAttributes.optionValue', 'variants.media')->loadCount('variants');

        $this->variant->load('variantAttributes.optionValue', 'media');
    }

    public function render()
    {
        return view('livewire.employee.product.product-variant-detail')->layout('layouts.admin');
    }
}
