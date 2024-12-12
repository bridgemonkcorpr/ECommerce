<div class="bg-gradient-to-br from-pink-100 via-purple-100 via-blue-100 to-green-100 min-h-screen p-8 dark:from-purple-900 dark:via-purple-900 dark:to-indigo-900">
    <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-3xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-pink-500 via-purple-500 to-blue-500">
                {{ $discount->exists ? __("Discount $discount->code") : __('Create discount') }}
            </h1>

               <a href="{{ route('employee.discounts.list') }}"
                class="px-4 py-2 bg-white text-purple-700 font-semibold rounded-lg shadow-md hover:bg-purple-50 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-opacity-75 transition-all duration-300"
            >
                <x-heroicon-m-arrow-left class="w-5 h-5 inline-block mr-2"/>
                {{ __('Back to list') }}
            </a>
        </div>

        <!-- Content -->
        <div class="bg-white dark:bg-purple-800 rounded-3xl shadow-xl overflow-hidden">
            <div class="p-6 space-y-6">
                @if($message = session('success'))
                    <x-alert
                        type="success"
                        :message="$message"
                    />
                @endif

                <!-- Discount Code and Type -->
                <div
                    x-data="{
                        code: @entangle('discount.code').defer,
                        type: @entangle('discount.type').defer,
                        generateCode() {
                            const characters = 'ABCDEFGHJKLMNPQRSTUVWXYZ0123456789';
                            let code = '';
                            for (let i = 0; i < 12; i++) {
                               code += characters.charAt(Math.floor(Math.random() * characters.length));
                            }
                            return this.code = code;
                        }
                    }"
                >
                    <h2 class="text-lg font-medium text-purple-900 dark:text-purple-100 mb-4">{{ __('Discount Details') }}</h2>
                    <div class="grid sm:grid-cols-2 gap-4">
                        <div>
                            <x-input-label for="code" :value="__('Discount code')" />
                            <div class="mt-1 flex rounded-md shadow-sm">
                                <x-input
                                    x-model="code"
                                    id="code"
                                    type="text"
                                    class="flex-1 rounded-none rounded-l-md"
                                    placeholder="Enter discount code"
                                />
                                <button
                                    x-on:click="generateCode()"
                                    type="button"
                                    class="relative -ml-px inline-flex items-center px-4 py-2 border border-purple-300 text-sm font-medium rounded-r-md text-purple-700 bg-purple-50 hover:bg-purple-100 focus:outline-none focus:ring-1 focus:ring-purple-500 focus:border-purple-500"
                                >
                                    {{ __('Generate') }}
                                </button>
                            </div>
                            <x-input-error for="discount.code" class="mt-2" />
                        </div>
                        <div>
                            <x-input-label for="type" :value="__('Type')" />
                            <x-select
                                x-model="type"
                                id="type"
                                class="mt-1 block w-full"
                            >
                                <option value="percentage">{{ __('Percentage') }}</option>
                                <option value="fixed">{{ __('Fixed') }}</option>
                            </x-select>
                        </div>
                        <div>
                            <x-input-label for="value" :value="__('Value')" />
                            <div class="mt-1 relative rounded-md shadow-sm">
                                <x-input
                                    wire:model.defer="discount.value"
                                    id="value"
                                    type="number"
                                    step="any"
                                    class="block w-full pr-12"
                                    placeholder="Enter discount value"
                                />
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <span x-show="type === 'fixed'" class="text-purple-500 sm:text-sm">
                                        {{ config('app.currency') }}
                                    </span>
                                    <span x-show="type === 'percentage'" class="text-purple-500 sm:text-sm">
                                        %
                                    </span>
                                </div>
                            </div>
                            <x-input-error for="discount.value" class="mt-2" />
                        </div>
                    </div>
                </div>

                <!-- Applies to -->
                <div
                    x-data="{ applies: @entangle('discount.applies_to'), search: '' }"
                    x-init="$watch('search', value => {
                        if (applies === 'collections') {
                            $wire.searchCollections(value)
                        } else {
                            $wire.searchProducts(value)
                        }
                        search = ''
                    })"
                >
                    <h2 class="text-lg font-medium text-purple-900 dark:text-purple-100 mb-4">{{ __('Applies to') }}</h2>
                    <div class="space-y-4">
                        <div class="flex items-center space-x-4">
                            <label class="inline-flex items-center">
                                <x-input
                                    x-model="applies"
                                    wire:model.defer="discount.applies_to"
                                    type="radio"
                                    name="applies-to"
                                    value="collections"
                                />
                                <span class="ml-2">{{ __('Specific collections') }}</span>
                            </label>
                            <label class="inline-flex items-center">
                                <x-input
                                    x-model="applies"
                                    wire:model.defer="discount.applies_to"
                                    type="radio"
                                    name="applies-to"
                                    value="products"
                                />
                                <span class="ml-2">{{ __('Specific products') }}</span>
                            </label>
                        </div>
                        <div class="flex rounded-md shadow-sm">
                            <x-input
                                x-model="search"
                                type="text"
                                class="flex-1 rounded-none rounded-l-md"
                                ::placeholder="applies === 'collections' ? '{{ __('Search collection') }}' : '{{ __('Search product') }}'"
                            />
                            <button
                                x-on:click="applies === 'collections' ? $wire.searchCollections() : $wire.searchProducts()"
                                type="button"
                                class="relative -ml-px inline-flex items-center px-4 py-2 border border-purple-300 text-sm font-medium rounded-r-md text-purple-700 bg-purple-50 hover:bg-purple-100 focus:outline-none focus:ring-1 focus:ring-purple-500 focus:border-purple-500"
                            >
                                {{ __('Browse') }}
                            </button>
                        </div>
                        <x-input-error for="selectedCollections" class="mt-2" />
                        <x-input-error for="selectedProducts" class="mt-2" />
                    </div>

                    <!-- Display selected collections/products -->
                    @if($this->currentCollections->count() || $this->currentProducts->count())
                        <div class="mt-4">
                            <h3 class="text-sm font-medium text-purple-700 dark:text-purple-300 mb-2">{{ __('Selected items') }}</h3>
                            <ul class="divide-y divide-purple-200 dark:divide-purple-700">
                                @foreach($this->currentCollections as $currentCollection)
                                    <li class="py-3 flex justify-between items-center">
                                        <div class="flex items-center">
                                            <img class="h-10 w-10 rounded object-cover" src="{{ $currentCollection->getFirstMediaUrl('cover', 'thumb') }}" alt="{{ $currentCollection->title }}">
                                            <span class="ml-3 text-sm font-medium text-purple-900 dark:text-purple-100">{{ $currentCollection->title }}</span>
                                        </div>
                                        <button wire:click.prevent="removeCollections({{ $currentCollection->id }})" type="button" class="text-red-600 hover:text-red-800">
                                            <x-heroicon-o-x-mark class="h-5 w-5" />
                                        </button>
                                    </li>
                                @endforeach
                                @foreach($this->currentProducts as $product)
                                    <li class="py-3 flex justify-between items-center">
                                        <div class="flex items-center">
                                            <img class="h-10 w-10 rounded object-cover" src="{{ $product->getFirstMediaUrl('gallery', 'thumb') }}" alt="{{ $product->name }}">
                                            <span class="ml-3 text-sm font-medium text-purple-900 dark:text-purple-100">{{ $product->name }}</span>
                                        </div>
                                        <button wire:click.prevent="removeProducts({{ $product->id }})" type="button" class="text-red-600 hover:text-red-800">
                                            <x-heroicon-o-x-mark class="h-5 w-5" />
                                        </button>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>

                <!-- Active dates -->
                <div
                    x-data="{
                        startDate: @entangle('startDate').defer,
                        startTime: @entangle('startTime').defer,
                        endDate: @entangle('endDate').defer,
                        endTime: @entangle('endTime').defer,
                        hasEnd: @entangle('hasEnd').defer,
                    }"
                    x-init="
                        flatpickr('.start-date-input', {
                            dateFormat: 'Z',
                            defaultDate: startDate,
                            onChange: function(selectedDates, dateStr) {
                                startDate = dateStr;
                            }
                        });
                        flatpickr('.start-time-input', {
                            enableTime: true,
                            noCalendar: true,
                            dateFormat: 'Z',
                            defaultDate: startTime,
                            onChange: function(selectedDates, dateStr) {
                                startTime = dateStr;
                            }
                        });
                        flatpickr('.end-date-input', {
                            dateFormat: 'Z',
                            defaultDate: endDate,
                            onChange: function(selectedDates, dateStr) {
                                endDate = dateStr;
                            }
                        });
                        flatpickr('.end-time-input', {
                            enableTime: true,
                            noCalendar: true,
                            dateFormat: 'Z',
                            defaultDate: endTime,
                            onChange: function(selectedDates, dateStr) {
                                endTime = dateStr;
                            }
                        });
                    "
                >
                    <h2 class="text-lg font-medium text-purple-900 dark:text-purple-100 mb-4">{{ __('Active dates') }}</h2>
                    <div class="grid sm:grid-cols-2 gap-4">
                        <div>
                            <x-input-label for="starts_at_date" :value="__('Start date')" />
                            <x-input id="starts_at_date" type="text" class="mt-1 block w-full start-date-input" />
                            <x-input-error for="startDate" class="mt-2" />
                        </div>
                        <div>
                            <x-input-label for="starts_at_time" :value="__('Start time')" />
                            <x-input id="starts_at_time" type="text" class="mt-1 block w-full start-time-input" />
                            <x-input-error for="startTime" class="mt-2" />
                        </div>
                        <div class="sm:col-span-2">
                            <label class="inline-flex items-center">
                                <x-input x-model="hasEnd" type="checkbox" />
                                <span class="ml-2 text-sm text-purple-600 dark:text-purple-400">{{ __('Set end date') }}</span>
                            </label>
                        </div>
                        <div x-show="hasEnd">
                            <x-input-label for="ends_at_date" :value="__('End date')" />
                            <x-input id="ends_at_date" type="text" class="mt-1 block w-full end-date-input" />
                            <x-input-error for="endDate" class="mt-2" />
                        </div>
                        <div x-show="hasEnd">
                            <x-input-label for="ends_at_time" :value="__('End time')" />
                            <x-input id="ends_at_time" type="text" class="mt-1 block w-full end-time-input" />
                            <x-input-error for="endTime" class="mt-2" />
                        </div>
                    </div>
                </div>

                <div class="flex justify-end mt-6">
                    <button
                        wire:click="save"
                        type="submit"
                        class="px-4 py-2 bg-gradient-to-r from-pink-500 via-purple-500 to-blue-500 text-white font-semibold rounded-lg shadow-md hover:from-pink-700 hover:via-purple-700 hover:to-blue-700 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-opacity-75 transition-all duration-300"
                    >
                        {{ __('Save discount') }}
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for adding collections -->
    <form
        x-data="{ selectedCollections: @entangle('selectedCollections').defer }"
        wire:submit.prevent="addCollections"
    >
        <x-modal-dialog wire:model="showCollectionModal">
            <x-slot:title>
                {{ __('Add collections') }}
            </x-slot:title>
            <x-slot:content>
                <div class="space-y-4">
                    <div class="relative">
                        <x-input
                            wire:model.debounce.500ms="filterCollectionTitle"
                            type="search"
                            class="block w-full pl-10 pr-3 py-2"
                            placeholder="{{ __('Search collections') }}"
                        />
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <x-heroicon-m-magnifying-glass class="h-5 w-5 text-purple-400" />
                        </div>
                    </div>
                    <div class="border border-purple-200 rounded-md max-h-60 overflow-y-auto">
                        <ul class="divide-y divide-purple-200">
                            @forelse($collections as $collection)
                                <li class="p-4 hover:bg-purple-50">
                                    <label class="flex items-center">
                                        <input
                                            x-model.number="selectedCollections"
                                            type="checkbox"
                                            value="{{ $collection->id }}"
                                            class="h-4 w-4 text-purple-600 focus:ring-purple-500 border-purple-300 rounded"
                                        />
                                        <span class="ml-3 text-sm text-purple-700">{{ $collection->title }}</span>
                                    </label>
                                </li>
                            @empty
                                <li class="p-4 text-center text-purple-500">
                                    {{ __('No collections found.') }}
                                </li>
                            @endforelse
                        </ul>
                    </div>
                </div>
            </x-slot:content>
            <x-slot:footer>
                <button
                    x-bind:disabled="selectedCollections.length === 0"
                    type="submit"
                    class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-purple-600 text-base font-medium text-white hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 sm:ml-3 sm:w-auto sm:text-sm"
                >
                    {{ __('Add') }}
                </button>
                <button
                    x-on:click.prevent="$wire.showCollectionModal = false"
                    type="button"
                    class="mt-3 w-full inline-flex justify-center rounded-md border border-purple-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-purple-700 hover:bg-purple-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm"
                >
                    {{ __('Cancel') }}
                </button>
            </x-slot:footer>
        </x-modal-dialog>
    </form>

    <!-- Modal for adding products -->
    <form
        x-data="{ selectedProducts: @entangle('selectedProducts').defer }"
        wire:submit.prevent="addProducts"
    >
        <x-modal-dialog wire:model="showProductModal">
            <x-slot:title>
                {{ __('Add products') }}
            </x-slot:title>
            <x-slot:content>
                <div class="space-y-4">
                    <div class="relative">
                        <x-input
                            wire:model.debounce.500ms="filterProductName"
                            type="search"
                            class="block w-full pl-10 pr-3 py-2"
                            placeholder="{{ __('Search products') }}"
                        />
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <x-heroicon-m-magnifying-glass class="h-5 w-5 text-purple-400" />
                        </div>
                    </div>
                    <div class="border border-purple-200 rounded-md max-h-60 overflow-y-auto">
                        <ul class="divide-y divide-purple-200">
                            @forelse($products as $product)
                                <li class="p-4 hover:bg-purple-50">
                                    <label class="flex items-center">
                                        <input
                                            x-model.number="selectedProducts"
                                            type="checkbox"
                                            value="{{ $product->id }}"
                                            class="h-4 w-4 text-purple-600 focus:ring-purple-500 border-purple-300 rounded"
                                        />
                                        <span class="ml-3 text-sm text-purple-700">{{ $product->name }}</span>
                                    </label>
                                </li>
                            @empty
                                <li class="p-4 text-center text-purple-500">
                                    {{ __('No products found.') }}
                                </li>
                            @endforelse
                        </ul>
                    </div>
                </div>
            </x-slot:content>
            <x-slot:footer>
                <button
                    x-bind:disabled="selectedProducts.length === 0"
                    type="submit"
                    class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-purple-600 text-base font-medium text-white hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 sm:ml-3 sm:w-auto sm:text-sm"
                >
                    {{ __('Add') }}
                </button>
                <button
                    x-on:click.prevent="$wire.showProductModal = false"
                    type="button"
                    class="mt-3 w-full inline-flex justify-center rounded-md border border-purple-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-purple-700 hover:bg-purple-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm"
                >
                    {{ __('Cancel') }}
                </button>
            </x-slot:footer>
        </x-modal-dialog>
    </form>
</div>
