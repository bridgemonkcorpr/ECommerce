<?php

namespace App\Http\Livewire\Guest;

use App\Models\Collection;
use App\Models\OptionValue;
use App\Models\Product;
use Artesaos\SEOTools\Traits\SEOTools;
use Livewire\Component;
use Livewire\WithPagination;

class CollectionDetail extends Component
{
    use SEOTools;
    use WithPagination;

    public Collection $collection;

    public $filters = [
        'search' => '',
        'price' => [
            'min' => 1,
            'max' => 1,
        ],
        'options' => [],
    ];

    public $showMobileFilterDialog = false;

    public $sortBy = '';

    public $sortDirection = 'asc';

    public $perPage = 12;

    public function mount()
    {
        $this->filters['price']['min'] = $this->minPrice;

        $this->filters['price']['max'] = $this->maxPrice;

        $this->seo()->setTitle($this->collection->seo_title ?: $this->collection->title);

        $this->seo()->setDescription($this->collection->seo_description ?: null);
    }

    public function showMobileFilter()
    {
        $this->showMobileFilterDialog = true;
    }

    public function applySorting($sortBy, $sortDirection)
    {
        $this->sortBy = $sortBy;

        $this->sortDirection = $sortDirection;
    }

    public function getProductOptionValuesProperty()
    {
        return OptionValue::query()
            ->with('option')
            ->whereIn('product_id', $this->collection->products->pluck('id'))
            ->get();
    }

    public function getProductRowsQueryProperty()
    {
        return Product::query()
            ->with([
                'media',
                'options.optionValues',
            ])
            ->whereHas('collections', fn($query) => $query->where('id', $this->collection->id))
            ->whereRaw('price BETWEEN ? AND ?', [$this->filters['price']['min'], $this->filters['price']['max']])
            ->when($this->filters['options'], fn($query, $options) => $query->whereHas('optionValues', function ($query) use ($options) {
                $query->whereIn('label', $options);
            }))
            ->when($this->sortBy, fn($query, $sortBy) => $query->orderBy($sortBy, $this->sortDirection))
            ->when(!$this->sortBy, fn($query) => $query->orderBy('name', 'asc'))
            ->published();
    }

    public function getProductRowsProperty()
    {
        return $this->productRowsQuery->paginate($this->perPage);
    }

    public function getMinPriceProperty()
    {
        return Product::query()
            ->whereHas('collections', function ($query) {
                $query->where('id', $this->collection->id);
            })
            ->orderBy('price')
            ->first()
            ->price ?? 0;
    }

    public function getMaxPriceProperty()
    {
        return Product::query()
            ->whereHas('collections', function ($query) {
                $query->where('id', $this->collection->id);
            })
            ->orderByDesc('price')
            ->first()
            ->price ?? 0;
    }

    public function render()
    {
        return view('livewire.guest.collection-detail', [
            'products' => $this->productRows,
        ])->layout('layouts.guest');
    }
}
