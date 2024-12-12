<?php

namespace App\Http\Livewire\Employee\Customer;

use App\Http\Livewire\Traits\WithBulkActions;
use App\Models\Customer;
use Livewire\Component;
use Livewire\WithPagination;

class CustomerList extends Component
{
    use WithBulkActions;
    use WithPagination;

    public $search = '';

    public $perPage = 10;

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

    public function getRowsQueryProperty()
    {
        return Customer::query()
            ->with(['media', 'orders.orderItems', 'orders.orderDiscounts'])
            ->withCount('orders')
            ->when($this->search, fn($query, $search) => $query->where('name', 'like', '%' . $search . '%')->orWhere('email', 'like', '%' . $search . '%'))
            ->latest();
    }

    public function getRowsProperty()
    {
        return $this->rowsQuery->paginate($this->perPage);
    }

    public function render()
    {
        return view('livewire.employee.customer.customer-list', [
            'customers' => $this->rows,
        ])->layout('layouts.admin');
    }
}
