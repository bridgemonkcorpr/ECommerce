<?php

namespace App\Http\Livewire\Employee\Discount;

use App\Models\Collection;
use App\Models\Discount;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Support\Facades\Route;
use Livewire\Component;

class DiscountDetail extends Component
{
    public Discount $discount;

    public $collections = [];

    public $readyToLoadCollections = false;

    public $showCollectionModal = false;

    public $selectedCollections = [];

    public $filterCollectionTitle = '';

    public $products = [];

    public $readyToLoadProducts = false;

    public $showProductModal = false;

    public $selectedProducts = [];

    public $filterProductName = '';

    public $startDate = null;

    public $startTime = null;

    public $endDate = null;

    public $endTime = null;

    public $hasEnd = false;

    protected $rules = [
        'discount.code' => 'required|string',
        'discount.type' => 'required|in:fixed,percentage',
        'discount.value' => 'required|numeric',
        'discount.applies_to' => 'required|in:all,collections,products,variants',
        'startDate' => 'date',
        'startTime' => 'date',
        'endDate' => 'nullable|date',
        'endTime' => 'nullable|date',
        'selectedCollections' => 'required_if:discount.applies_to,collections|array',
        'selectedProducts' => 'required_if:discount.applies_to,products|array',
    ];

    public function mount()
    {
        if (Route::currentRouteName() === 'employee.discounts.create') {
            $this->discount = new Discount([
                'type' => 'percentage',
                'applies_to' => 'collections',
            ]);

            $this->startDate = now()->toISOString();

            $this->startTime = now()->toISOString();

            $this->endDate = now()->toISOString();

            $this->endTime = now()->toISOString();
        } else {
            $this->discount->load([
                'collections' => function ($query) {
                    $query->select('discount_id', 'collection_id')->withPivot('collection_id');
                },
                'products' => function ($query) {
                    $query->select('discount_id', 'product_id')->withPivot('product_id');
                },
            ]);

            $this->startDate = $this->discount->starts_at->toISOString();

            $this->startTime = $this->discount->starts_at->toISOString();

            $this->hasEnd = (bool)$this->discount->ends_at;

            $this->endDate = $this->hasEnd ? $this->discount->ends_at->toISOString() : now()->toISOString();

            $this->endTime = $this->hasEnd ? $this->discount->ends_at->toISOString() : now()->toISOString();

            $this->selectedCollections = $this->discount->collections->pluck('collection_id')->toArray();

            $this->selectedProducts = $this->discount->products->pluck('product_id')->toArray();
        }
    }

    public function searchCollections(?string $title = '')
    {
        if (!empty($title)) $this->filterCollectionTitle = $title;

        $this->showCollectionModal = true;
    }

    public function updatedfilterCollectionTitle()
    {
        $this->loadCollections();
    }

    public function loadCollections(): \Illuminate\Database\Eloquent\Collection|array
    {
        return $this->collections = Collection::query()
            ->with('media')
            ->when($this->filterCollectionTitle, fn($query, $search) => $query->where('title', 'like', '%' . $search . '%'))
            ->get();
    }

    public function addCollections()
    {
        $this->selectedCollections = array_values(array_unique($this->selectedCollections));

        $this->showCollectionModal = false;
    }

    public function removeCollections($collectionId)
    {
        $this->selectedCollections = array_values(array_diff($this->selectedCollections, [$collectionId]));
    }

    public function searchProducts(?string $name = '')
    {
        if (!empty($name)) $this->filterProductName = $name;

        $this->showProductModal = true;
    }

    public function updatedfilterProductName()
    {
        $this->loadProducts();
    }

    public function loadProducts()
    {
        $this->products = Product::query()
            ->with('media')
            ->when($this->filterProductName, fn($query, $search) => $query->where('name', 'like', '%' . $search . '%'))
            ->get();
    }

    public function addProducts()
    {
        $this->selectedProducts = array_values(array_unique($this->selectedProducts));

        $this->showProductModal = false;
    }

    public function removeProducts($productId)
    {
        $this->selectedProducts = array_values(array_diff($this->selectedProducts, [$productId]));
    }

    public function getCurrentCollectionsProperty(): \Illuminate\Database\Eloquent\Collection|array
    {
        return Collection::query()
            ->with('media')
            ->whereIn('id', $this->selectedCollections)
            ->get();
    }

    public function getCurrentProductsProperty(): \Illuminate\Database\Eloquent\Collection|array
    {
        return Product::query()
            ->with('media')
            ->whereIn('id', $this->selectedProducts)
            ->get();
    }

    public function save()
    {
        $this->validate();

        $this->discount->starts_at = Carbon::parse($this->startDate)->setTimeFrom(Carbon::parse($this->startTime))->toDateTimeString();

        $this->discount->ends_at = $this->hasEnd ? Carbon::parse($this->endDate)->setTimeFrom(Carbon::parse($this->endTime))->toDateTimeString() : null;

        $this->discount->save();

        if ($this->discount->applies_to === 'collections') {
            $this->discount->products()->detach();

            $this->discount->collections()->sync($this->selectedCollections);
        }

        if ($this->discount->applies_to === 'products') {
            $this->discount->collections()->detach();

            $this->discount->products()->sync($this->selectedProducts);
        }

        if ($this->discount->wasRecentlyCreated) {
            session()->flash('success', 'Discount saved successfully!');

            $this->redirect(route('employee.discounts.detail', $this->discount));
        }

        $this->notify('Discount saved successfully!');
    }

    public function render()
    {
        return view('livewire.employee.discount.discount-detail')->layout('layouts.admin');
    }
}
