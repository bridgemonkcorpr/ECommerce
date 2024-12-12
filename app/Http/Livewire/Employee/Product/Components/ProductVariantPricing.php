<?php

namespace App\Http\Livewire\Employee\Product\Components;

use App\Models\Product;
use App\Models\Variant;
use Livewire\Component;

class ProductVariantPricing extends Component
{
    public Product $product;

    public Variant $variant;

    protected function rules()
    {
        return [
            'variant.price' => 'required|numeric|min:0',
            'variant.compare_price' => 'nullable|numeric|min:0',
            'variant.cost_price' => 'nullable|numeric|min:0',
        ];
    }

    public function save()
    {
        $this->validate();

        $this->variant->save();

        $this->dispatchBrowserEvent('variant-pricing-updated');

        $this->notify(trans('Pricing updated.'));
    }

    public function render()
    {
        return view('livewire.employee.product.components.product-variant-pricing');
    }
}
