<?php

namespace App\Http\Livewire\Employee\Product;

use App\Models\Product;
use Livewire\Component;

class ProductDetail extends Component
{
    public Product $product;

    public int $product_options_count = 0;

    protected $listeners = [
        'refresh' => '$refresh',
        'reload' => 'reload',
    ];

    public function mount()
    {
        $this->product->load('variants')->loadCount('options');

        $this->product_options_count = $this->product->options_count;
    }

    public function reload()
    {
        $this->product->load('variants')->loadCount('options');

        $this->product_options_count = $this->product->options_count;
    }

    public function render()
    {
        return view('livewire.employee.product.product-detail')->layout('layouts.admin');
    }
}
