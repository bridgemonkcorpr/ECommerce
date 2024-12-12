<div>
    <form
        x-data="{ dirty: false, date: new Date(), published_at: @entangle('published_at'), scheduled_at: null }"
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
                    dirty = true;
                }
            }
        })"
        x-on:collection-availability-updated.window="dirty = false"
        wire:submit.prevent="save"
    >
        <x-card>
            <x-slot:header>
                <div class="-ml-4 -mt-2 flex items-center justify-between flex-wrap sm:flex-nowrap">
                    <div class="ml-4 mt-2">
                        <h3 class="text-base font-medium text-slate-900 dark:text-slate-200">
                            {{ __('Collection availability') }}
                        </h3>
                    </div>
                    <div
                        x-show="dirty"
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
                <p class="text-sm">
                    @if(!$published_at)
                        {{ __('This collection is not available.') }}
                    @elseif(\Carbon\Carbon::parse($published_at)->isPast())
                        {{ __('This collection is available.') }}
                    @else
                        {{ __('Scheduled for ') }}
                        <span x-text="scheduled_at ? new Date(scheduled_at) : new Date(Date.parse(published_at + ' {{ config('app.timezone') }}'))"></span>
                    @endif
                </p>
                <div class="mt-1 space-x-3">
                    @if(!$published_at)
                        <a
                            role="button"
                            x-on:click="published_at = '{{ now()->toIso8601ZuluString() }}'; dirty = !dirty"
                            class="btn btn-link  text-purple-600 cursor-pointer"
                        >
                            {{ __('Publish') }}
                        </a>
                    @else
                        <a
                            role="button"
                            x-on:click="published_at = null; dirty = !dirty"
                            class="btn btn-link  text-purple-600 cursor-pointer"
                        >
                            {{ __('Take down') }}
                        </a>
                    @endif
                    <span
                        x-ref="date"
                        class="btn btn-link  text-purple-600 cursor-pointer"
                    >
                        {{ __('Schedule availability') }}
                    </span>
                </div>
            </x-slot:content>
        </x-card>
    </form>
</div>
