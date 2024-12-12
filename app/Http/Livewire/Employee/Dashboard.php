<?php

namespace App\Http\Livewire\Employee;

use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Carbon\Carbon;
use Carbon\CarbonInterval;
use DatePeriod;
use Livewire\Component;

class Dashboard extends Component
{
    public $periods = 7;

    public function getOrdersCountProperty()
    {
        return Order::query()->whereBetween('created_at', [Carbon::now()->subDays($this->periods)->startOfDay(), Carbon::now()->endOfDay()])->count();
    }

    public function getDailyOrdersProperty()
    {
        $periods = new DatePeriod(Carbon::now()->subDays($this->periods)->startOfDay(), CarbonInterval::day(), Carbon::now()->endOfDay());

        $orders = Order::query()
            ->whereBetween('created_at', [Carbon::now()->subDays($this->periods)->startOfDay(), Carbon::now()->endOfDay()])
            ->groupBy('day')
            ->orderBy('day')
            ->get([
                \DB::raw('DATE_FORMAT(created_at, "%Y-%m-%d") as day'),
                \DB::raw('count(*) as orders_count'),
            ])
            ->keyBy('day')
            ->map(function ($item) {
                $item->date = Carbon::parse($item->date);
                return $item;
            });

        return array_map(function ($datePeriod) use ($orders) {
            $date = $datePeriod->format('Y-m-d');
            return $orders->has($date) ? $orders->get($date)->orders_count : 0;
        }, iterator_to_array($periods));
    }

    public function getOrderItemsCountProperty()
    {
        return OrderItem::query()->whereBetween('created_at', [Carbon::now()->subDays($this->periods)->startOfDay(), Carbon::now()->endOfDay()])->count();
    }

    public function getDailyOrderItemsProperty()
    {
        $periods = new DatePeriod(Carbon::now()->subDays($this->periods)->startOfDay(), CarbonInterval::day(), Carbon::now()->endOfDay());

        $orderItems = OrderItem::query()
            ->whereBetween('created_at', [Carbon::now()->subDays($this->periods)->startOfDay(), Carbon::now()->endOfDay()])
            ->groupBy('day')
            ->orderBy('day')
            ->get([
                \DB::raw('DATE_FORMAT(created_at, "%Y-%m-%d") as day'),
                \DB::raw('count(*) as order_items_count'),
            ])
            ->keyBy('day')
            ->map(function ($item) {
                $item->date = Carbon::parse($item->date);
                return $item;
            });

        return array_map(function ($datePeriod) use ($orderItems) {
            $date = $datePeriod->format('Y-m-d');
            return $orderItems->has($date) ? $orderItems->get($date)->order_items_count : 0;
        }, iterator_to_array($periods));
    }

    public function getProductsCountProperty()
    {
        return Product::query()->whereBetween('created_at', [Carbon::now()->subDays($this->periods)->startOfDay(), Carbon::now()->endOfDay()])->count();
    }

    public function getDailyProductsProperty()
    {
        $periods = new DatePeriod(Carbon::now()->subDays($this->periods)->startOfDay(), CarbonInterval::day(), Carbon::now()->endOfDay());

        $products = Product::query()
            ->whereBetween('created_at', [Carbon::now()->subDays($this->periods)->startOfDay(), Carbon::now()->endOfDay()])
            ->groupBy('day')
            ->orderBy('day')
            ->get([
                \DB::raw('DATE_FORMAT(created_at, "%Y-%m-%d") as day'),
                \DB::raw('count(*) as products_count'),
            ])
            ->keyBy('day')
            ->map(function ($item) {
                $item->date = Carbon::parse($item->date);
                return $item;
            });

        return array_map(function ($datePeriod) use ($products) {
            $date = $datePeriod->format('Y-m-d');
            return $products->has($date) ? $products->get($date)->products_count : 0;
        }, iterator_to_array($periods));
    }

    public function getCustomersCountProperty()
    {
        return Customer::query()->whereBetween('created_at', [Carbon::now()->subDays($this->periods)->startOfDay(), Carbon::now()->endOfDay()])->count();
    }

    public function getDailyCustomersProperty()
    {
        $periods = new DatePeriod(Carbon::now()->subDays($this->periods)->startOfDay(), CarbonInterval::day(), Carbon::now()->endOfDay());

        $customers = Customer::query()
            ->whereBetween('created_at', [Carbon::now()->subDays($this->periods)->startOfDay(), Carbon::now()->endOfDay()])
            ->groupBy('day')
            ->orderBy('day')
            ->get([
                \DB::raw('DATE_FORMAT(created_at, "%Y-%m-%d") as day'),
                \DB::raw('count(*) as customers_count'),
            ])
            ->keyBy('day')
            ->map(function ($item) {
                $item->date = Carbon::parse($item->date);
                return $item;
            });

        return array_map(function ($datePeriod) use ($customers) {
            $date = $datePeriod->format('Y-m-d');
            return $customers->has($date) ? $customers->get($date)->customers_count : 0;
        }, iterator_to_array($periods));
    }

    public function getDailySalesReportProperty()
    {
        $periods = new DatePeriod(Carbon::now()->subDays($this->periods)->startOfDay(), CarbonInterval::day(), Carbon::now()->endOfDay());

        $days = array_map(function ($period) {
            return $period->format('Y-m-d');
        }, iterator_to_array($periods));

        $sales = OrderItem::query()
            ->whereBetween('created_at', [Carbon::now()->subDays($this->periods)->startOfDay(), Carbon::now()->endOfDay()])
            ->groupBy('day')
            ->orderBy('day')
            ->get([
                \DB::raw('DATE_FORMAT(created_at, "%Y-%m-%d") as day'),
                \DB::raw('SUM(subtotal) as total'),
            ])
            ->keyBy('day')
            ->map(function ($item) {
                $item->date = Carbon::parse($item->date);
                return $item;
            });

        $dailySale = array_map(function ($datePeriod) use ($sales) {
            $date = $datePeriod->format('Y-m-d');
            return $sales->has($date) ? $sales->get($date)->total : 0;
        }, iterator_to_array($periods));

        return ['days' => $days, 'sales' => $dailySale];
    }

    public function getRecentOrdersProperty()
    {
        return Order::query()
            ->with(['customer', 'orderItems', 'orderDiscounts'])
            ->latest()
            ->limit(5)
            ->get();
    }

    public function getTopSellingProductsProperty()
    {
        return \DB::table('order_items')
            ->crossJoin('products')
            ->whereRaw('order_items.product_id = products.id')
            ->select('products.id', 'products.name', 'products.slug')
            ->selectRaw('sum(subtotal) as total_sales')
            ->groupBy('products.id', 'products.name', 'products.slug')
            ->orderByRaw('total_sales DESC')
            ->limit(5)
            ->get();
    }

    public function render()
    {
        return view('livewire.employee.dashboard')->layout('layouts.admin');
    }
}
