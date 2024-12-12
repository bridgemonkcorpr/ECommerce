<?php

namespace App\Http\Livewire\Employee\Product\Components;

use App\Models\Product;
use Illuminate\Validation\Rules\Enum;
use App\Enums\ProductStatus as ProductStatusEnum;
use Livewire\Component;

class ProductStatus extends Component
{
    public Product $product;

    public $published_at;

    protected function rules()
    {
        return [
            'product.status' => ['required', new Enum(\App\Enums\ProductStatus::class)],
        ];
    }

    public function mount()
    {
        $this->published_at = $this->product->published_at ? $this->product->published_at->toDateTimeString() : null;
    }

    public function updatedProductStatus($value)
    {
        if ($value === ProductStatusEnum::ACTIVE->name && ! $this->published_at) {
            $this->published_at = now();
        }
    }

    public function save()
    {
        $this->product->published_at = $this->published_at;

        $this->product->save();

        // emit to parent component to refresh the collection status name
        $this->emitUp('refresh');

        $this->notify(trans('Product status updated.'));

        $this->dispatchBrowserEvent('product-status-updated');
    }

    public function render()
    {
        return view('livewire.employee.product.components.product-status');
    }
}
