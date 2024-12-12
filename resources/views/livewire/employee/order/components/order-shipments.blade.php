<div class="space-y-6">
    @foreach($shipments as $shipment)
        <x-card class="-mx-4 sm:-mx-0 overflow-hidden">
            <x-slot:header>
                <div class="-ml-4 -mt-2 flex items-center justify-between flex-wrap sm:flex-nowrap">
                    <div class="ml-4 mt-2 flex items-center space-x-3">
                        <h2 class="text-base font-medium text-slate-900 dark:text-slate-200">
                            {{ __('Shipment') }} #{{ $shipment->id }}
                        </h2>

                        @if($shipment->tracking_number)
                            <p class="text-sm text-slate-500 dark:text-slate-400">
                                {{ $shipment->shipping_carrier->label() }} tracking {{ $shipment->tracking_number }}
                            </p>
                        @else
                            <button
                                wire:click="edit('{{ $shipment->id }}')"
                                type="button"
                                class="btn btn-link  text-purple-600"
                            >
                                {{ __('Add tracking') }}
                            </button>
                        @endif
                    </div>
                    <div class="ml-4 mt-2 flex-shrink-0">
                        <x-dropdown>
                            <x-slot name="trigger">
                                <button
                                    type="button"
                                    class="-m-2 rounded-full flex items-center text-slate-500 hover:text-slate-600 dark:hover:text-slate-400"
                                    aria-expanded="false"
                                    aria-haspopup="true"
                                >
                                    <span class="sr-only">{{ __('Open options') }}</span>
                                    <x-heroicon-m-ellipsis-horizontal class="h-5 w-5" />
                                </button>
                            </x-slot>
                            <x-slot name="content">
                                <x-dropdown-link
                                    wire:click="edit('{{ $shipment->id }}')"
                                    role="button"
                                >
                                    {{ __('Edit tracking') }}
                                </x-dropdown-link>
                                <x-dropdown-link
                                    wire:click="delete('{{ $shipment->id }}')"
                                    role="button"
                                    class="text-red-600 dark:text-red-500"
                                >
                                    {{ __('Cancel shipment') }}
                                </x-dropdown-link>
                            </x-slot>
                        </x-dropdown>
                    </div>
                </div>
            </x-slot:header>
            <x-slot:content>
                <div class="space-y-6 -mx-4 -my-5 sm:-mx-6">
                    <div class="relative overflow-auto">
                        <table class="min-w-full divide-y divide-slate-200 dark:divide-slate-200/10">
                            <thead class="border-t border-slate-200 bg-slate-50 dark:border-slate-200/10 dark:bg-slate-800/75">
                                <tr>
                                    <th
                                        scope="col"
                                        class="px-3 py-3 sm:px-6 text-left text-xs font-medium text-slate-500 uppercase tracking-wider dark:text-slate-400"
                                    >
                                    </th>
                                    <th
                                        scope="col"
                                        class="px-3 py-3 sm:px-6 text-center text-xs font-medium text-slate-500 uppercase tracking-wider dark:text-slate-400"
                                    >
                                        {{ __('QTY') }}
                                    </th>
                                    <th
                                        scope="col"
                                        class="px-3 py-3 sm:px-6 text-right text-xs font-medium text-slate-500 uppercase tracking-wider dark:text-slate-400"
                                    >
                                        {{ __('Price') }}
                                    </th>
                                    <th
                                        scope="col"
                                        class="px-3 py-3 sm:px-6 text-right text-xs font-medium text-slate-500 uppercase tracking-wider dark:text-slate-400"
                                    >
                                        {{ __('Subtotal') }}
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-200 dark:divide-slate-200/10">
                                @foreach($shipment->shipmentItems as $item)
                                    <tr>
                                        <td class="px-3 py-4 sm:px-6 w-full max-w-sm text-sm text-slate-5">
                                            <div class="flex items-center">
                                                <div class="h-10 w-10 flex-shrink-0">
                                                    <img
                                                        class="h-10 w-10 rounded object-center object-cover"
                                                        src="{{ $item->orderItem->variant->hasMedia('image') ? $item->orderItem->variant->getFirstMediaUrl('image', 'thumb') : $item->orderItem->variant->product->getFirstMediaUrl('gallery', 'thumb') }}"
                                                        alt="{{ $item->orderItem->name }}"
                                                    >
                                                </div>
                                                <div class="ml-4 max-w-xs flex flex-col">
                                                    <div class="font-medium text-slate-900 hover:text-purple-600 truncate ... dark:text-slate-200 dark:hover:text-purple-400">
                                                        <a href="{{ route('employee.products.detail', $item->orderItem->variant->product) }}">{{ $item->orderItem->name }}</a>
                                                    </div>
                                                    @if($item->orderItem->variant->variantAttributes)
                                                        <ul class="space-x-2 divide-x divide-slate-200 text-slate-500 dark:divide-slate-200/10 dark:text-slate-400">
                                                            @foreach($item->orderItem->variant->variantAttributes as $attribute)
                                                                <li @class(['inline', 'pl-2' => !$loop->first])>{{ $attribute->optionValue->label }}</li>
                                                            @endforeach
                                                        </ul>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-3 py-4 sm:px-6 whitespace-nowrap text-center text-sm text-slate-500 dark:text-slate-400">
                                            {{ $item->quantity }}
                                        </td>
                                        <td class="px-3 py-4 sm:px-6 whitespace-nowrap text-right text-sm text-slate-500 tabular-nums dark:text-slate-400">
                                            <x-money
                                                :amount="$item->orderItem->price"
                                                :currency="config('app.currency')"
                                            />
                                        </td>
                                        <td class="px-3 py-4 sm:px-6 whitespace-nowrap text-right text-sm text-slate-500 tabular-nums dark:text-slate-400">
                                            <x-money
                                                :amount="$item->quantity * $item->orderItem->price"
                                                :currency="config('app.currency')"
                                            />
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </x-slot:content>
        </x-card>
    @endforeach

    <form wire:submit.prevent="update">
        <x-modal-dialog wire:model.defer="isEditingShipment">
            <x-slot:title>
                {{ __('Edit tracking') }}
            </x-slot:title>
            <x-slot:content>
                <div class="mt-2 grid grid-cols-2 gap-5">
                    <div>
                        <x-input-label
                            for="shipping_carrier"
                            value="{{ __('Shipping carrier') }}"
                        />
                        <x-select
                            wire:model="shipmentBeingUpdated.shipping_carrier"
                            id="shipping_carrier"
                            class="mt-1 block w-full sm:text-sm"
                        >
                            @foreach($shippingCarriers as $shippingCarrier)
                                <option value="{{ $shippingCarrier->value }}">{{ $shippingCarrier->label() }}</option>
                            @endforeach
                        </x-select>
                        <x-input-error
                            for="shipmentBeingUpdated.shipping_carrier"
                            class="mt-2"
                        />
                    </div>
                    <div>
                        <x-input-label
                            for="tracking_number"
                            :value="__('Tracking number')"
                        />
                        <x-input
                            wire:model.defer="shipmentBeingUpdated.tracking_number"
                            type="text"
                            id="tracking_number"
                            class="mt-1 block w-full sm:text-sm"
                        />
                        <x-input-error
                            for="shipmentBeingUpdated.tracking_number"
                            class="mt-2"
                        />
                    </div>
                    @if($shipmentBeingUpdated?->shipping_carrier->value === \App\Enums\ShippingCarrier::OTHER->value)
                        <div class="col-span-2">
                            <x-input-label
                                for="tracking_url"
                                :value="__('Tracking URL')"
                            />
                            <x-input
                                wire:model.defer="shipmentBeingUpdated.tracking_url"
                                type="text"
                                id="tracking_url"
                                class="mt-1 block w-full sm:text-sm"
                            />
                            <x-input-error
                                for="shipmentBeingUpdated.tracking_url"
                                class="mt-2"
                            />
                        </div>
                    @endif
                </div>
            </x-slot:content>
            <x-slot:footer>
                <button
                    type="submit"
                    class="btn btn-primary bg-purple-600 hover:bg-purple-700 w-full sm:ml-3 sm:w-auto"
                >
                    {{ __('Save') }}
                </button>
                <button
                    wire:click="$set('isEditingShipment', false)"
                    type="button"
                    class="mt-3 btn btn-invisible text-purple-600 w-full sm:mt-0 sm:w-auto"
                >
                    {{ __('Cancel') }}
                </button>
            </x-slot:footer>
        </x-modal-dialog>
    </form>
</div>
