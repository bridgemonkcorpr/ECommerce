<div class="bg-gradient-to-br from-pink-100 via-purple-100 via-blue-100 to-green-100 min-h-screen p-8 dark:from-purple-900 dark:via-purple-900 dark:to-indigo-900">
    <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <div class="flex justify-between items-center mb-12">
            <h1 class="text-5xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-pink-500 via-purple-500 to-blue-500">
                {{ __('Dashboard') }}
            </h1>
            <select
                wire:model="periods"
                class="bg-white dark:bg-purple-800 text-purple-600 dark:text-purple-300 rounded-full px-6 py-3 border-2 border-purple-300 dark:border-purple-600 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-300"
            >
                <option value="7">{{ __('Last 7 days') }}</option>
                <option value="10">{{ __('Last 10 days') }}</option>
                <option value="30">{{ __('Last 30 days') }}</option>
            </select>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-12">
            @foreach([
                ['title' => __('New Orders'), 'value' => $this->ordersCount, 'data' => $this->dailyOrders, 'icon' => 'M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z', 'color' => 'from-blue-400 to-blue-600'],
                ['title' => __('Items Sold'), 'value' => $this->orderItemsCount, 'data' => $this->dailyorderItems, 'icon' => 'M16 8v8m-4-5v5m-4-2v2m-4 4h18M4 12h18M4 4h18', 'color' => 'from-green-400 to-green-600'],
                ['title' => __('New Customers'), 'value' => $this->customersCount, 'data' => $this->dailyCustomers, 'icon' => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z', 'color' => 'from-pink-400 to-pink-600']
            ] as $stat)
                <div class="bg-white dark:bg-purple-800 rounded-3xl shadow-xl overflow-hidden transition-all duration-300 hover:shadow-2xl transform hover:-translate-y-1">
                    <div class="p-8">
                        <div class="flex items-center justify-between mb-6">
                            <div class="bg-gradient-to-r {{ $stat['color'] }} p-3 rounded-2xl">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $stat['icon'] }}"></path></svg>
                            </div>
                            <h3 class="text-xl font-semibold text-purple-700 dark:text-purple-200">{{ $stat['title'] }}</h3>
                        </div>
                        <p class="text-4xl font-bold text-purple-800 dark:text-white mb-6">{{ $stat['value'] }}</p>
                        <div class="h-16" x-data x-init="
                            new ApexCharts($el, {
                                series: [{ data: {{ json_encode($stat['data']) }} }],
                                chart: { type: 'area', height: 64, sparkline: { enabled: true } },
                                colors: ['{{ str_replace(['from-', '-400 to-', '-600'], '', $stat['color']) }}'],
                                fill: { type: 'gradient', gradient: { shadeIntensity: 1, opacityFrom: 0.7, opacityTo: 0.3, stops: [0, 90, 100] } },
                                stroke: { curve: 'smooth', width: 2 },
                                tooltip: { theme: 'dark', fixed: { enabled: false }, x: { show: false }, marker: { show: false } }
                            }).render()
                        "></div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Sales Chart -->
        <div class="bg-white dark:bg-purple-800 rounded-3xl shadow-xl overflow-hidden mb-12">
            <div class="p-8">
                <h3 class="text-2xl font-bold text-purple-800 dark:text-white mb-6">{{ __('Sales Report') }}</h3>
                <div class="h-96" x-data x-init="
                    new ApexCharts($el, {
                        series: [{ name: 'Amount', data: {{ json_encode($this->dailySalesReport['sales']) }} }],
                        chart: { type: 'area', height: 384, toolbar: { show: false } },
                        colors: ['#8B5CF6'],
                        fill: { type: 'gradient', gradient: { shadeIntensity: 1, opacityFrom: 0.7, opacityTo: 0.3, stops: [0, 90, 100] } },
                        dataLabels: { enabled: false },
                        stroke: { curve: 'smooth', width: 3 },
                        xaxis: { type: 'datetime', categories: {{ json_encode($this->dailySalesReport['days']) }}, labels: { style: { colors: '#64748B' } } },
                        yaxis: { labels: { style: { colors: '#64748B' }, formatter: (value) => new Intl.NumberFormat('{{ config('app.locale') }}', { style: 'currency', currency: '{{ config('app.currency') }}' }).format(value) } },
                        tooltip: { theme: 'dark', x: { format: 'dd MMM yyyy' } }
                    }).render()
                "></div>
            </div>
        </div>

        <!-- Recent Orders and Top Products -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
            @foreach([
                ['title' => __('Recent Orders'), 'data' => $this->recentOrders, 'columns' => ['ID', 'Customer', 'Total', 'Date']],
                ['title' => __('Top Selling Products'), 'data' => $this->topSellingProducts, 'columns' => ['Name', 'Amount']]
            ] as $table)
                <div class="bg-white dark:bg-purple-800 rounded-3xl shadow-xl overflow-hidden">
                    <div class="p-8">
                        <h3 class="text-2xl font-bold text-purple-800 dark:text-white mb-6">{{ $table['title'] }}</h3>
                        <div class="overflow-x-auto">
                            <table class="w-full">
                                <thead>
                                    <tr>
                                        @foreach($table['columns'] as $column)
                                            <th class="px-6 py-3 text-left text-xs font-medium text-purple-500 dark:text-purple-300 uppercase tracking-wider">{{ __($column) }}</th>
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-purple-200 dark:divide-purple-700">
                                    @forelse($table['data'] as $item)
                                        <tr class="hover:bg-purple-50 dark:hover:bg-purple-700 transition-colors duration-200">
                                            @if($table['title'] === __('Recent Orders'))
                                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-purple-600 dark:text-purple-400"><a href="{{ route('employee.orders.detail', $item) }}" class="hover:underline">{{ $item->id }}</a></td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-purple-700 dark:text-purple-300">{{ $item->customer ? $item->customer->name : __('No customer') }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-purple-700 dark:text-purple-300"><x-money :amount="$item->total" :currency="config('app.currency')" /></td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-purple-700 dark:text-purple-300">{{ $item->created_at->format('Y-m-d') }}</td>
                                            @else
                                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-purple-600 dark:text-purple-400"><a href="{{ route('employee.products.detail', $item->id) }}" class="hover:underline">{{ $item->name }}</a></td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-purple-700 dark:text-purple-300"><x-money :amount="$item->total_sales" :currency="config('app.currency')" /></td>
                                            @endif
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="{{ count($table['columns']) }}" class="px-6 py-4 whitespace-nowrap text-sm text-purple-500 dark:text-purple-400 text-center">{{ __('No records found.') }}</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
