<div>
    <form
        x-data="{ isEditing: false }"
        x-on:saved.window="isEditing = false"
        wire:submit.prevent="save"
    >
        <x-card class="relative overflow-hidden">
            <x-slot:header>
                <div class="-ml-4 -mt-2 flex items-center justify-between flex-wrap sm:flex-nowrap">
                    <div class="ml-4 mt-2">
                        <h3 class="text-base font-medium text-slate-900 dark:text-slate-200">
                            {{ __('Search engine listing preview') }}
                        </h3>
                    </div>
                    <div class="ml-4 mt-2 flex-shrink-0">
                        <button
                            x-show="isEditing"
                            type="submit"
                            class="btn btn-link  text-purple-600"
                        >
                            {{ __('Save') }}
                        </button>
                        <button
                            x-show="!isEditing"
                            x-on:click="isEditing = true"
                            type="button"
                            class="btn btn-link  text-purple-600"
                        >
                            {{ __('Edit') }}
                        </button>
                    </div>
                </div>
            </x-slot:header>
            <x-slot:content class="-mt-10 space-y-5">
                @unless($model->getRawOriginal('seo_title') != null && $model->getRawOriginal('seo_description') != null)
                    <p class="mt-1 text-slate-500 text-sm dark:text-slate-400">
                        {{ __('Add a description to see how this collection might appear in a search engine listing') }}
                    </p>
                @else
                    <div class="mt-3">
                        <p class="text-sm text-[#1a0dab] dark:text-[#8ab4f8]">
                            {{ $model->seo_title }}
                        </p>
                        <p class="text-sm text-emerald-600">
                            @if($model instanceof \App\Models\Article)
                                {{ config('app.url') . '/blog/articles/' . $model->slug }}
                            @elseif($model instanceof \App\Models\Collection)
                                {{ config('app.url') . '/collections/' . $model->slug }}
                            @elseif($model instanceof \App\Models\Product)
                                {{ config('app.url') . '/products/' . $model->slug }}
                            @endif
                        </p>
                        <p class="text-sm text-slate-500 dark:text-slate-400">
                            {{ $model->seo_description }}
                        </p>
                    </div>
                @endunless
                <div
                    x-cloak
                    x-show="isEditing"
                    class="space-y-6"
                >
                    <hr class="-mx-4 border-slate-200 sm:-mx-6 dark:border-white/10" />

                    <div>
                        <x-input-label
                            for="seo-title"
                            :value="__('Page title')"
                        />
                        <x-input
                            wire:model.lazy="model.seo_title"
                            type="text"
                            id="seo-title"
                            name="seo-title"
                            class="mt-1 block w-full sm:text-sm"
                        />
                        <x-input-error
                            for="model.seo_title"
                            class="mt-2"
                        />
                        <x-input-description>
                            {{ __(':count of 70 characters used', ['count' => strlen($model->seo_title)]) }}
                        </x-input-description>
                    </div>

                    <div>
                        <x-input-label
                            for="seo-description"
                            value="Description"
                        />
                        <x-textarea
                            wire:model.lazy="model.seo_description"
                            id="seo-description"
                            name="seo-description"
                            class="mt-1 block w-full sm:text-sm"
                        />
                        <x-input-error
                            for="model.seo_description"
                            class="mt-2"
                        />
                        <x-input-description>
                            {{ __(':count of 320 characters used', ['count' => strlen($model->seo_description)]) }}
                        </x-input-description>
                    </div>

                    <div>
                        <x-input-label
                            for="urlHandleInput"
                            value="{{ __('URL handle') }}"
                        />
                        <x-input
                            wire:model.lazy="model.slug"
                            type="text"
                            id="urlHandleInput"
                            name="urlHandleInput"
                            rows="4"
                            class="mt-1 block w-full sm:text-sm"
                        />
                        <x-input-error
                            for="model.slug"
                            class="mt-2"
                        />
                    </div>
                </div>
            </x-slot:content>
        </x-card>
    </form>
</div>
