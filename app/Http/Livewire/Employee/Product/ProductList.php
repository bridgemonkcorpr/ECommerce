<?php

namespace App\Http\Livewire\Employee\Product;

use App\Http\Livewire\Traits\WithBulkActions;
use App\Models\Product;
use Livewire\Component;
use Livewire\WithPagination;

class ProductList extends Component
{
    use WithBulkActions;
    use WithPagination;

    public $perPage = 10;

    public string $search = '';

    protected $queryString = [
        'search' => ['except' => ''],
    ];

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedPage()
    {
        $this->clearSelection();
    }

    public function newProduct()
    {
        $product = new Product();

        $product->name = '';

        $product->save();

        $this->redirect(route('employee.products.detail', $product));
    }

    public function getRowsQueryProperty()
    {
        return Product::query()
            ->with('media')
            ->withSum('variants', 'stock_value')
            ->when($this->search, fn($query, $search) => $query->where('name', 'like', '%' . $search . '%'))
            ->latest();
    }

    public function getRowsProperty()
    {
        return $this->rowsQuery->paginate($this->perPage);
    }

    public function render()
    {
        return view('livewire.employee.product.product-list', [
            'products' => $this->rows,
        ])->layout('layouts.admin');
    }
}
