<div>
    <form
        x-data="{ dirty: new Set(), date: new Date(), published_at: @entangle('published_at'), scheduled_at: null }"
        x-init="flatpickr($refs.date, {
            enableTime: true,
            dateFormat: 'Z',
            minDate: Date.now(),
            defaultHour: date.getHours(),
            defaultMinute: date.getMinutes(),
            disableMobile: true,
            plugins: [new confirmDatePlugin({
                confirmIcon: '',
                confirmText: '{{ __('Schedule availability') }}',
                showAlways: true
            })],
            onClose: function(date, dateString) {
                if (dateString !== undefined) {
                    published_at = dateString;
                    scheduled_at = dateString;
                    dirty.add('schedule_at');
                }
            }
        })"
        x-on:product-status-updated.window="dirty.clear()"
        wire:submit.prevent="save"
    >
        <x-card>
            <x-slot:header>
                <div class="-ml-4 -mt-2 flex items-center justify-between flex-wrap sm:flex-nowrap">
                    <div class="ml-4 mt-2">
                        <h3 class="text-base font-medium text-slate-900 dark:text-slate-200">
                            {{ __('Product status') }}
                        </h3>
                    </div>
                    <div
                        x-show="dirty.size >= 1"
                        class="ml-4 mt-2 flex-shrink-0"
                    >
                        <button
                            type="submit"
                            class="btn btn-link  text-purple-600"
                        >
                            {{ __('Save') }}
                        </button>
                    </div>
                </div>
            </x-slot:header>
            <x-slot:content class="-mt-5">
                <x-select
                    x-on:change="$nextTick(() => $el.value !== '{{ $product->status->name }}' ? dirty.add('status') : dirty.delete('status'))"
                    wire:model="product.status"
                    class="sm:text-sm"
                >
                    @foreach(\App\Enums\ProductStatus::cases() as $status)
                        <option value="{{ $status->name }}">{{ $status->label() }}</option>
                    @endforeach
                </x-select>
                <div class="mt-2 sm:text-sm">
                    <div class="text-slate-500 text-sm dark:text-slate-400">
                        @if($published_at && \Carbon\Carbon::parse($published_at)->isFuture())
                            <p>
                                {{ __('Scheduled for ') }}
                                <span x-text="scheduled_at ? new Date(scheduled_at) : new Date(Date.parse(published_at + ' {{ config('app.timezone') }}'))"></span>
                            </p>

                            @if($product->status->name !== \App\Enums\ProductStatus::ACTIVE->name)
                                <p class="mt-1">
                                    {{ __('Scheduling won\'t apply until product status is set as active.') }}
                                </p>
                            @endif
                        @endif
                    </div>
                    <div class="mt-1 space-x-3">
                        @if($published_at && \Carbon\Carbon::parse($published_at)->isFuture())
                            <span
                                x-ref="date"
                                class="btn btn-link  text-purple-600 cursor-pointer"
                            >
                                {{ __('Edit') }}
                            </span>
                            <a
                                role="button"
                                x-on:click="published_at = new Date(); scheduled_at = null; dirty.add('schedule_at');"
                                class="btn btn-link  text-purple-600 cursor-pointer"
                            >
                                {{ __('Clear Schedule') }}
                            </a>
                        @else
                            <span
                                x-ref="date"
                                class="btn btn-link  text-purple-600 cursor-pointer"
                            >
                                {{ __('Schedule availability') }}
                            </span>
                        @endif
                    </div>
                </div>
            </x-slot:content>
        </x-card>
    </form>
</div>
