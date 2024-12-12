<div
    x-data="{
        messages: [],
        add(e) {
            this.messages.unshift({ id: e.timeStamp, content: e.detail });
        },
        remove(message) {
            this.messages = this.messages.filter(i => i.id !== message.id);
        }
    }"
    x-on:notify.window="add($event);"
    aria-live="assertive"
    class="pointer-events-none fixed top-14 inset-0 flex flex-col items-end px-4 py-6 space-y-4 sm:items-start sm:p-6"
>
    <template
        x-for="message in messages"
        :key="message.id"
        hidden
    >
        <div
            x-data="{
                show: false,
                init() {
                    this.$nextTick(() => this.show = true)
                    setTimeout(() => this.transitionOut(), 5000)
                },
                transitionOut() {
                    this.show = false
                    setTimeout(() => this.remove(this.message), 1000)
                },
            }"
            class="flex w-full flex-col items-center space-y-4 sm:items-end"
        >
            <div
                x-show="show"
                x-transition:enter="transition ease-out duration-300 transition"
                x-transition:enter-start="translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-2"
                x-transition:enter-end="translate-y-0 opacity-100 sm:translate-x-0"
                x-transition:leave="transition ease-in duration-100"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                class="pointer-events-auto w-full max-w-sm overflow-hidden rounded-lg bg-white shadow-lg ring-1 ring-black ring-opacity-5 dark:bg-slate-800"
            >
                <div class="p-4">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <x-heroicon-o-information-circle class="w-6 h-6 text-purple-400" />
                        </div>
                        <div class="ml-3 flex w-0 flex-1 justify-between">
                            <p
                                x-text="message.content"
                                class="w-0 flex-1 text-sm font-medium text-slate-900 dark:text-slate-200"
                            ></p>
                            <div class="ml-4 flex flex-shrink-0">
                                <button
                                    x-on:click="remove(message)"
                                    type="button"
                                    class="inline-flex rounded-md text-slate-400 hover:text-slate-500 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2 dark:hover:text-slate-300"
                                >
                                    <span class="sr-only">{{ __('Close') }}</span>
                                    <x-heroicon-m-x-mark class="h-5 w-5" />
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </template>
</div>
