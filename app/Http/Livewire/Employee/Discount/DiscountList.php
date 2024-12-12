<?php

namespace App\Http\Livewire\Employee\Discount;

use App\Http\Livewire\Traits\WithBulkActions;
use App\Models\Discount;
use Livewire\Component;
use Livewire\WithPagination;

class DiscountList extends Component
{
    use WithBulkActions;
    use WithPagination;

    public $perPage = 10;

    public $search = '';

    public $showDeleteConfirmationModal = false;

    protected $queryString = [
        'search' => ['except' => ''],
    ];

    public function deleteSelected()
    {
        Discount::query()->whereIn('id', $this->selected)->delete();

        $this->reset('selectAll', 'selectPage', 'selected');

        $this->showDeleteConfirmationModal = false;
    }

    public function getRowsQueryProperty()
    {
        return Discount::query()->withCount('collections', 'products')->latest();
    }

    public function getRowsProperty()
    {
        return $this->rowsQuery->paginate($this->perPage);
    }

    public function render()
    {
        return view('livewire.employee.discount.discount-list', [
            'discounts' => $this->rows,
        ])->layout('layouts.admin');
    }
}
