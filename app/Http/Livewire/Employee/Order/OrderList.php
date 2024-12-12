<?php

namespace App\Http\Livewire\Employee\Order;

use App\Http\Livewire\Traits\WithBulkActions;
use App\Models\Order;
use Livewire\Component;
use Livewire\WithPagination;

class OrderList extends Component
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

    public function getRowsQueryProperty()
    {
        return Order::query()
            ->with([
                'orderDiscounts.orderItem',
                'orderItems:order_id,subtotal',
                'customer:id,name',
            ])
            ->withSum('orderItems', 'quantity')
            ->when($this->search, fn($query, $search) => $query->where('id', 'like', "%{$search}%"))
            ->latest();
    }

    public function getRowsProperty()
    {
        return $this->rowsQuery->paginate($this->perPage);
    }

    public function render()
    {
        return view('livewire.employee.order.order-list', [
            'orders' => $this->rows,
        ])->layout('layouts.admin');
    }
}
