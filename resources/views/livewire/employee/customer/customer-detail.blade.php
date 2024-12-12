<div class="bg-gradient-to-br from-pink-100 via-purple-100 via-blue-100 to-green-100 min-h-screen p-8 dark:from-purple-900 dark:via-purple-900 dark:to-indigo-900">
    <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <div class="flex items-center mb-8">

              <a  href="{{ route('employee.customers.list') }}"
                class="mr-4 bg-white dark:bg-purple-800 p-2 rounded-full shadow-md hover:bg-purple-100 dark:hover:bg-purple-700 transition-colors duration-200"
            >
                <x-heroicon-m-arrow-left class="w-6 h-6 text-purple-600 dark:text-purple-300" />
            </a>
            <h1 class="text-3xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-pink-500 via-purple-500 to-blue-500">
                {{ $customer->name }}
            </h1>
        </div>

        <!-- Content -->
        <div class="grid grid-cols-1 xl:grid-cols-3 gap-8">
            <div class="xl:col-span-2 space-y-8">
                @if($customer->orders_count)
                    <div class="bg-white dark:bg-purple-800 rounded-3xl shadow-xl overflow-hidden">
                        <div class="p-6">
                            <h2 class="text-2xl font-semibold text-purple-900 dark:text-purple-200 mb-4">
                                {{ __('Customer Statistics') }}
                            </h2>
                            <livewire:employee.customer.components.customer-statistics :customer="$customer" />
                        </div>
                    </div>
                @endif

                <div class="bg-white dark:bg-purple-800 rounded-3xl shadow-xl overflow-hidden">
                    <div class="p-6">
                        <h2 class="text-2xl font-semibold text-purple-900 dark:text-purple-200 mb-4">
                            {{ __('Latest Order') }}
                        </h2>
                        <livewire:employee.customer.components.customer-latest-order :customer="$customer" />
                    </div>
                </div>
            </div>

            <div class="xl:col-span-1 space-y-8">
                <div class="bg-white dark:bg-purple-800 rounded-3xl shadow-xl overflow-hidden">
                    <div class="p-6">
                        <h2 class="text-2xl font-semibold text-purple-900 dark:text-purple-200 mb-4">
                            {{ __('Customer Notes') }}
                        </h2>
                        <livewire:employee.customer.components.customer-notes :customer="$customer" />
                    </div>
                </div>

                <div class="bg-white dark:bg-purple-800 rounded-3xl shadow-xl overflow-hidden">
                    <div class="p-6">
                        <h2 class="text-2xl font-semibold text-purple-900 dark:text-purple-200 mb-4">
                            {{ __('Customer Information') }}
                        </h2>
                        <livewire:employee.customer.components.customer-information :customer="$customer" />
                    </div>
                </div>

                <div class="bg-white dark:bg-purple-800 rounded-3xl shadow-xl overflow-hidden">
                    <div class="p-6">
                        <h2 class="text-2xl font-semibold text-purple-900 dark:text-purple-200 mb-4">
                            {{ __('Customer Address') }}
                        </h2>
                        <livewire:employee.customer.components.customer-address :customer="$customer" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
