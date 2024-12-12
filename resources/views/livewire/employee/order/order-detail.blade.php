<div class="bg-gradient-to-br from-pink-100 via-purple-100 via-blue-100 to-green-100 min-h-screen p-8 dark:from-purple-900 dark:via-purple-900 dark:to-indigo-900">
    <!-- Meta title & description -->
    <x-slot:title>
        {{ __('Orders - :id', ['id' => $order->id]) }}
    </x-slot:title>

    <div class="max-w-7xl mx-auto">
        <!-- Page title & actions -->
        <div class="flex items-center mb-8">

              <a  href="{{ route('employee.orders.list') }}"
                class="mr-4 bg-white dark:bg-purple-800 p-2 rounded-full shadow-md hover:bg-purple-100 dark:hover:bg-purple-700 transition-colors duration-200"
            >
                <x-heroicon-m-arrow-left class="w-6 h-6 text-purple-600 dark:text-purple-300" />
            </a>
            <div>
                <h1 class="text-3xl font-bold text-purple-900 dark:text-white">
                    {{ __('Order: #:orderId', ['orderId' => $order->id]) }}
                </h1>
                <div class="mt-2 flex items-center space-x-4">
                    <span class="text-sm text-purple-600 dark:text-purple-300">
                        {{ $order->created_at->toDayDateTimeString() }}
                    </span>
                    <x-badge class="bg-{{ $order->payment_status->color() }}-100 text-{{ $order->payment_status->color() }}-800 dark:bg-{{ $order->payment_status->color() }}-800 dark:text-{{ $order->payment_status->color() }}-100">
                        {{ $order->payment_status->label() }}
                    </x-badge>
                    <x-badge class="bg-{{ $order->shipping_status->color() }}-100 text-{{ $order->shipping_status->color() }}-800 dark:bg-{{ $order->shipping_status->color() }}-800 dark:text-{{ $order->shipping_status->color() }}-100">
                        {{ $order->shipping_status->label() }}
                    </x-badge>
                </div>
            </div>
        </div>

        <!-- Page content -->
        <div class="grid grid-cols-1 xl:grid-cols-3 gap-8">
            <div class="xl:col-span-2 space-y-8">
                @if($order->shipping_status->value != \App\Enums\ShippingStatus::SHIPPED->value)
                    <div class="bg-white dark:bg-purple-800 rounded-3xl shadow-xl overflow-hidden">
                        <div class="p-6">
                            <h2 class="text-2xl font-semibold text-purple-900 dark:text-white mb-4">
                                {{ __('Order Items') }}
                            </h2>
                            <livewire:employee.order.components.order-items :order="$order" />
                        </div>
                    </div>
                @endif

                @if($order->shipments_count)
                    <div class="bg-white dark:bg-purple-800 rounded-3xl shadow-xl overflow-hidden">
                        <div class="p-6">
                            <h2 class="text-2xl font-semibold text-purple-900 dark:text-white mb-4">
                                {{ __('Shipments') }}
                            </h2>
                            <livewire:employee.order.components.order-shipments :order="$order" />
                        </div>
                    </div>
                @endif

                @if($order->refunds_count && $order->refund_items_count)
                    <div class="bg-white dark:bg-purple-800 rounded-3xl shadow-xl overflow-hidden">
                        <div class="p-6">
                            <h2 class="text-2xl font-semibold text-purple-900 dark:text-white mb-4">
                                {{ __('Refunded Items') }}
                            </h2>
                            <livewire:employee.order.components.order-refunded-items :order="$order" />
                        </div>
                    </div>
                @endif

                <div class="bg-white dark:bg-purple-800 rounded-3xl shadow-xl overflow-hidden">
                    <div class="p-6">
                        <h2 class="text-2xl font-semibold text-purple-900 dark:text-white mb-4">
                            {{ __('Payment Details') }}
                        </h2>
                        <livewire:employee.order.components.order-payment-detail :order="$order" />
                    </div>
                </div>
            </div>

            <div class="space-y-8">
                <div class="bg-white dark:bg-purple-800 rounded-3xl shadow-xl overflow-hidden">
                    <div class="p-6">
                        <h2 class="text-2xl font-semibold text-purple-900 dark:text-white mb-4">
                            {{ __('Order Notes') }}
                        </h2>
                        <livewire:employee.order.components.order-notes :order="$order" />
                    </div>
                </div>

                <div class="bg-white dark:bg-purple-800 rounded-3xl shadow-xl overflow-hidden">
                    <div class="p-6">
                        <h2 class="text-2xl font-semibold text-purple-900 dark:text-white mb-4">
                            {{ __('Customer Details') }}
                        </h2>
                        <livewire:employee.order.components.order-customer-detail :order="$order" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
