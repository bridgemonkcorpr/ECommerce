<div>
    <x-card>
        <x-slot:header>
            <div class="-ml-4 -mt-2 flex items-center justify-between flex-wrap sm:flex-nowrap">
                <div class="ml-4 mt-2">
                    <h3 class="text-base font-medium text-slate-900 dark:text-slate-200">
                        {{ __('Specification') }}
                    </h3>
                </div>
                <div class="ml-4 mt-2 flex-shrink-0">
                    <button
                        wire:click="create"
                        type="button"
                        class="btn btn-link  text-purple-600"
                    >
                        {{ __('Add specification') }}
                    </button>
                </div>
            </div>
        </x-slot:header>
        <x-slot:content>
            @if($product->specifications->isNotEmpty())
                <dl class="divide-y divide-slate-200 space-y-4 sm:space-y-5 dark:divide-slate-200/10">
                    @foreach($product->specifications as $specification)
                        <div @class(['sm:grid sm:grid-cols-3 sm:gap-4', 'pt-4 sm:pt-5' => !$loop->first])>
                            <dt class="text-sm font-medium text-slate-700 dark:text-slate-200">
                                {{ $specification->name }}
                            </dt>
                            <dd class="mt-1 flex text-sm text-slate-900 sm:col-span-2 sm:mt-0">
                                <div class="flex-grow prose prose-slate prose-sm prose-a:text-purple-500 hover:prose-a:text-purple-600 dark:prose-invert dark:hover:prose-a:text-purple-400">
                                    {!! $specification->value !!}
                                </div>
                                <span class="ml-4 flex-shrink-0">
                                    <button
                                        wire:click="edit({{ $specification->id }})"
                                        type="button"
                                        class="btn btn-link  text-purple-600"
                                    >
                                        {{ __('Update') }}
                                  </button>
                                </span>
                            </dd>
                        </div>
                    @endforeach
                </dl>
            @else
                <div class="-mt-5">
                    <p class="text-sm text-slate-500 dark:text-slate-400">
                        {{ __('Use specifications to provide more details about your product.') }}
                    </p>
                </div>
            @endif
        </x-slot:content>
    </x-card>

    <form wire:submit.prevent="save">
        <x-modal-dialog wire:model="editingSpecification">
            <x-slot:title>
                {{ __('Edit specification') }}
            </x-slot:title>
            <x-slot:content>
                <div class="space-y-6">
                    <div>
                        <x-input-label
                            for="name"
                            :value="__('Name')"
                        />
                        <x-input
                            id="name"
                            type="text"
                            class="block w-full mt-1 sm:text-sm"
                            wire:model.defer="specificationBeingUpdated.name"
                        />
                        <x-input-error
                            for="specificationBeingUpdated.name"
                            class="mt-2"
                        />
                    </div>
                    <div>
                        <x-standalone-label :value="__('Value')" />
                        <div class="block w-full mt-1 shadow-sm sm:text-sm">
                            <x-quill wire:model.defer="specificationBeingUpdated.value" />
                        </div>
                        <x-input-error
                            for="specificationBeingUpdated.value"
                            class="mt-2"
                        />
                    </div>
                </div>
            </x-slot:content>
            <x-slot:footer>
                <button
                    wire:loading.attr="disabled"
                    wire:target="save"
                    type="submit"
                    class="btn btn-primary bg-purple-600 hover:bg-purple-700 w-full sm:ml-3 sm:w-auto"
                >
                    {{ __('Save changes') }}
                </button>
                @if($specificationBeingUpdated?->exists && !$specificationBeingUpdated->wasRecentlyCreated)
                    <button
                        wire:click="confirmSpecificationDeletion({{ $specificationBeingUpdated->id }})"
                        type="button"
                        class="mt-3 btn btn-outline-danger w-full sm:ml-3 sm:mt-0 sm:w-auto"
                    >
                        {{ __('Delete') }}
                    </button>
                @endif
                <button
                    x-on:click="show = false"
                    type="button"
                    class="mt-3 btn btn-invisible text-purple-600 w-full sm:mt-0 sm:w-auto"
                >
                    {{ __('Cancel') }}
                </button>
            </x-slot:footer>
        </x-modal-dialog>
    </form>

    <form wire:submit.prevent="deleteSpecification">
        <x-modal-dialog
            wire:model="confirmingSpecificationDeletion"
            wire:loading.attr="disabled"
            wire:target="deleteSpecification"
        >
            <x-slot:title>
                {{ __('Delete specification') }}
            </x-slot:title>
            <x-slot:content>
                <p class="text-sm text-slate-500">
                    {{ __('Are you sure you want to delete this specification?') }}
                </p>
            </x-slot:content>
            <x-slot:footer>
                <button
                    wire:click="deleteSpecification"
                    class="btn btn-danger w-full sm:ml-3 sm:w-auto"
                >
                    {{ __('Delete') }}
                </button>
                <button
                    wire:click.prevent="$set('confirmingSpecificationDeletion', false)"
                    type="button"
                    class="mt-3 btn btn-invisible text-purple-600 w-full sm:mt-0 sm:w-auto"
                >
                    {{ __('Cancel') }}
                </button>
            </x-slot:footer>
        </x-modal-dialog>
    </form>
</div>
