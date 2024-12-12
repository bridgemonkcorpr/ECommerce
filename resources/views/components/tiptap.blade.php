<div
    wire:ignore
    x-data="setupEditor(@entangle($attributes->wire('model')){{ $attributes->wire('model')->hasModifier('defer') ? '': '.defer' }})"
    x-init="() => init($refs.element)"
    x-on:tiptap-insert-media.window="insertMedia($event.detail.type, $event.detail.url, $event.detail.alt)"
    {{ $attributes->whereDoesntStartWith('wire:model') }}
>
    <div class="pt-4 pb-2 space-y-2 sm:grid sm:grid-flow-col-dense sm:auto-cols-fr sm:gap-1 sm:space-y-0">
        {{--Paragraph--}}
        <button
            type="button"
            @click="setParagraph()"
            class="inline-flex items-center justify-center p-2 rounded-md border"
            :class="{ 'bg-purple-500 text-white border-purple-500 hover:bg-purple-600 hover:border-purple-600 dark:hover:bg-purple-400 dark:hover:border-purple-400': isActive('paragraph', updatedAt), 'hover:bg-slate-100 dark:border-slate-600 dark:text-slate-400 dark:hover:bg-slate-700/50': !isActive('paragraph', updatedAt) }"
        >
            <svg
                xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 24 24"
                width="24"
                height="24"
                class="h-3.5 w-3.5 fill-current"
            >
                <path
                    fill="none"
                    d="M0 0h24v24H0z"
                />
                <path d="M12 6v15h-2v-5a6 6 0 1 1 0-12h10v2h-3v15h-2V6h-3zm-2 0a4 4 0 1 0 0 8V6z" />
            </svg>
            <span class="sr-only">{{ __('paragraph') }}</span>
        </button>
        {{--Bold--}}
        <button
            type="button"
            @click="toggleBold()"
            class="inline-flex items-center justify-center p-2 rounded-md border"
            :class="{ 'bg-purple-500 text-white border-purple-500 hover:bg-purple-600 hover:border-purple-600 dark:hover:bg-purple-400 dark:hover:border-purple-400': isActive('bold', updatedAt), 'hover:bg-slate-100 dark:border-slate-600 dark:text-slate-400 dark:hover:bg-slate-700/50': !isActive('bold', updatedAt) }"
        >
            <svg
                xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 24 24"
                width="24"
                height="24"
                class="h-3.5 w-3.5 fill-current"
            >
                <path
                    fill="none"
                    d="M0 0h24v24H0z"
                />
                <path d="M8 11h4.5a2.5 2.5 0 1 0 0-5H8v5zm10 4.5a4.5 4.5 0 0 1-4.5 4.5H6V4h6.5a4.5 4.5 0 0 1 3.256 7.606A4.498 4.498 0 0 1 18 15.5zM8 13v5h5.5a2.5 2.5 0 1 0 0-5H8z" />
            </svg>
            <span class="sr-only">{{ __('bold') }}</span>
        </button>
        {{--Italic--}}
        <button
            type="button"
            @click="toggleItalic()"
            class="inline-flex items-center justify-center p-2 rounded-md border"
            :class="{ 'bg-purple-500 text-white border-purple-500 hover:bg-purple-600 hover:border-purple-600 dark:hover:bg-purple-400 dark:hover:border-purple-400': isActive('italic', updatedAt), 'hover:bg-slate-100 dark:border-slate-600 dark:text-slate-400 dark:hover:bg-slate-700/50': !isActive('italic', updatedAt) }"
        >
            <svg
                xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 24 24"
                width="24"
                height="24"
                class="h-3.5 w-3.5 fill-current"
            >
                <path
                    fill="none"
                    d="M0 0h24v24H0z"
                />
                <path d="M15 20H7v-2h2.927l2.116-12H9V4h8v2h-2.927l-2.116 12H15z" />
            </svg>
            <span class="sr-only">{{ __('italic') }}</span>
        </button>
        {{--Underline--}}
        <button
            type="button"
            @click="toggleUnderline()"
            class="inline-flex items-center justify-center p-2 rounded-md border"
            :class="{ 'bg-purple-500 text-white border-purple-500 hover:bg-purple-600 hover:border-purple-600 dark:hover:bg-purple-400 dark:hover:border-purple-400': isActive('underline', updatedAt), 'hover:bg-slate-100 dark:border-slate-600 dark:text-slate-400 dark:hover:bg-slate-700/50': !isActive('underline', updatedAt) }"
        >
            <svg
                xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 24 24"
                width="24"
                height="24"
                class="h-3.5 w-3.5 fill-current"
            >
                <path
                    fill="none"
                    d="M0 0h24v24H0z"
                />
                <path d="M8 3v9a4 4 0 1 0 8 0V3h2v9a6 6 0 1 1-12 0V3h2zM4 20h16v2H4v-2z" />
            </svg>
            <span class="sr-only">{{ __('underline') }}</span>
        </button>
        {{--Heading level 2--}}
        <button
            type="button"
            @click="toggleHeading(2)"
            class="inline-flex items-center justify-center p-2 rounded-md border"
            :class="{ 'bg-purple-500 text-white border-purple-500 hover:bg-purple-600 hover:border-purple-600 dark:hover:bg-purple-400 dark:hover:border-purple-400': isActive('heading', { level: 2 }, updatedAt), 'hover:bg-slate-100 dark:border-slate-600 dark:text-slate-400 dark:hover:bg-slate-700/50': !isActive('heading', { level: 2 }, updatedAt) }"
        >
            <svg
                xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 24 24"
                width="24"
                height="24"
                class="h-3.5 w-3.5 fill-current"
            >
                <path
                    fill="none"
                    d="M0 0H24V24H0z"
                />
                <path d="M4 4v7h7V4h2v16h-2v-7H4v7H2V4h2zm14.5 4c2.071 0 3.75 1.679 3.75 3.75 0 .857-.288 1.648-.772 2.28l-.148.18L18.034 18H22v2h-7v-1.556l4.82-5.546c.268-.307.43-.709.43-1.148 0-.966-.784-1.75-1.75-1.75-.918 0-1.671.707-1.744 1.606l-.006.144h-2C14.75 9.679 16.429 8 18.5 8z" />
            </svg>
            <span class="sr-only">h2</span>
        </button>
        {{--Heading level 3--}}
        <button
            type="button"
            @click="toggleHeading(3)"
            class="inline-flex items-center justify-center p-2 rounded-md border"
            :class="{ 'bg-purple-500 text-white border-purple-500 hover:bg-purple-600 hover:border-purple-600 dark:hover:bg-purple-400 dark:hover:border-purple-400': isActive('heading', { level: 3 }, updatedAt), 'hover:bg-slate-100 dark:border-slate-600 dark:text-slate-400 dark:hover:bg-slate-700/50': !isActive('heading', { level: 3 }, updatedAt) }"
        >
            <svg
                xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 24 24"
                width="24"
                height="24"
                class="h-3.5 w-3.5 fill-current"
            >
                <path
                    fill="none"
                    d="M0 0H24V24H0z"
                />
                <path d="M22 8l-.002 2-2.505 2.883c1.59.435 2.757 1.89 2.757 3.617 0 2.071-1.679 3.75-3.75 3.75-1.826 0-3.347-1.305-3.682-3.033l1.964-.382c.156.806.866 1.415 1.718 1.415.966 0 1.75-.784 1.75-1.75s-.784-1.75-1.75-1.75c-.286 0-.556.069-.794.19l-1.307-1.547L19.35 10H15V8h7zM4 4v7h7V4h2v16h-2v-7H4v7H2V4h2z" />
            </svg>
            <span class="sr-only">h3</span>
        </button>
        {{--Heading level 4--}}
        <button
            type="button"
            @click="toggleHeading(4)"
            class="inline-flex items-center justify-center p-2 rounded-md border"
            :class="{ 'bg-purple-500 text-white border-purple-500 hover:bg-purple-600 hover:border-purple-600 dark:hover:bg-purple-400 dark:hover:border-purple-400': isActive('heading', { level: 4 }, updatedAt), 'hover:bg-slate-100 dark:border-slate-600 dark:text-slate-400 dark:hover:bg-slate-700/50': !isActive('heading', { level: 4 }, updatedAt) }"
        >
            <svg
                xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 24 24"
                width="24"
                height="24"
                class="h-3.5 w-3.5 fill-current"
            >
                <path
                    fill="none"
                    d="M0 0H24V24H0z"
                />
                <path d="M13 20h-2v-7H4v7H2V4h2v7h7V4h2v16zm9-12v8h1.5v2H22v2h-2v-2h-5.5v-1.34l5-8.66H22zm-2 3.133L17.19 16H20v-4.867z" />
            </svg>
            <span class="sr-only">h4</span>
        </button>
        {{--Bullet list--}}
        <button
            type="button"
            @click="toggleBulletList()"
            class="inline-flex items-center justify-center p-2 rounded-md border"
            :class="{ 'bg-purple-500 text-white border-purple-500 hover:bg-purple-600 hover:border-purple-600 dark:hover:bg-purple-400 dark:hover:border-purple-400': isActive('bulletList', updatedAt), 'hover:bg-slate-100 dark:border-slate-600 dark:text-slate-400 dark:hover:bg-slate-700/50': !isActive('bulletList', updatedAt) }"
        >
            <svg
                xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 24 24"
                width="24"
                height="24"
                class="h-3.5 w-3.5 fill-current"
            >
                <path
                    fill="none"
                    d="M0 0h24v24H0z"
                />
                <path d="M8 4h13v2H8V4zM4.5 6.5a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm0 7a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm0 6.9a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zM8 11h13v2H8v-2zm0 7h13v2H8v-2z" />
            </svg>
            <span class="sr-only">{{ __('bullet list') }}</span>
        </button>
        {{--Ordered list--}}
        <button
            type="button"
            @click="toggleOrderedList()"
            class="inline-flex items-center justify-center p-2 rounded-md border"
            :class="{ 'bg-purple-500 text-white border-purple-500 hover:bg-purple-600 hover:border-purple-600 dark:hover:bg-purple-400 dark:hover:border-purple-400': isActive('orderedList', updatedAt), 'hover:bg-slate-100 dark:border-slate-600 dark:text-slate-400 dark:hover:bg-slate-700/50': !isActive('orderedList', updatedAt) }"
        >
            <svg
                xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 24 24"
                width="24"
                height="24"
                class="h-3.5 w-3.5 fill-current"
            >
                <path
                    fill="none"
                    d="M0 0h24v24H0z"
                />
                <path d="M8 4h13v2H8V4zM5 3v3h1v1H3V6h1V4H3V3h2zM3 14v-2.5h2V11H3v-1h3v2.5H4v.5h2v1H3zm2 5.5H3v-1h2V18H3v-1h3v4H3v-1h2v-.5zM8 11h13v2H8v-2zm0 7h13v2H8v-2z" />
            </svg>
            <span class="sr-only">{{ __('ordered list') }}</span>
        </button>
        {{--Align left--}}
        <button
            type="button"
            @click="setTextAlign('left')"
            class="inline-flex items-center justify-center p-2 rounded-md border"
            :class="{ 'bg-purple-500 text-white border-purple-500 hover:bg-purple-600 hover:border-purple-600 dark:hover:bg-purple-400 dark:hover:border-purple-400': isActive({ textAlign: 'left' }, updatedAt), 'hover:bg-slate-100 dark:border-slate-600 dark:text-slate-400 dark:hover:bg-slate-700/50': !isActive({ textAlign: 'left' }, updatedAt) }"
        >
            <svg
                xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 24 24"
                width="24"
                height="24"
                class="h-3.5 w-3.5 fill-current"
            >
                <path
                    fill="none"
                    d="M0 0h24v24H0z"
                />
                <path d="M3 4h18v2H3V4zm0 15h14v2H3v-2zm0-5h18v2H3v-2zm0-5h14v2H3V9z" />
            </svg>
            <span class="sr-only">{{ __('align left') }}</span>
        </button>
        {{--Align center--}}
        <button
            type="button"
            @click="setTextAlign('center')"
            class="inline-flex items-center justify-center p-2 rounded-md border"
            :class="{ 'bg-purple-500 text-white border-purple-500 hover:bg-purple-600 hover:border-purple-600 dark:hover:bg-purple-400 dark:hover:border-purple-400': isActive({ textAlign: 'center' }, updatedAt), 'hover:bg-slate-100 dark:border-slate-600 dark:text-slate-400 dark:hover:bg-slate-700/50': !isActive({ textAlign: 'center' }, updatedAt) }"
        >
            <svg
                xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 24 24"
                width="24"
                height="24"
                class="h-3.5 w-3.5 fill-current"
            >
                <path
                    fill="none"
                    d="M0 0h24v24H0z"
                />
                <path d="M3 4h18v2H3V4zm2 15h14v2H5v-2zm-2-5h18v2H3v-2zm2-5h14v2H5V9z" />
            </svg>
            <span class="sr-only">{{ __('align center') }}</span>
        </button>
        {{--Align right--}}
        <button
            type="button"
            @click="setTextAlign('right')"
            class="inline-flex items-center justify-center p-2 rounded-md border"
            :class="{ 'bg-purple-500 text-white border-purple-500 hover:bg-purple-600 hover:border-purple-600 dark:hover:bg-purple-400 dark:hover:border-purple-400': isActive({ textAlign: 'right' }, updatedAt), 'hover:bg-slate-100 dark:border-slate-600 dark:text-slate-400 dark:hover:bg-slate-700/50': !isActive({ textAlign: 'right' }, updatedAt) }"
        >
            <svg
                xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 24 24"
                width="24"
                height="24"
                class="h-3.5 w-3.5 fill-current"
            >
                <path
                    fill="none"
                    d="M0 0h24v24H0z"
                />
                <path d="M3 4h18v2H3V4zm4 15h14v2H7v-2zm-4-5h18v2H3v-2zm4-5h14v2H7V9z" />
            </svg>
            <span class="sr-only">{{ __('align right') }}</span>
        </button>
        {{--Link--}}
        <button
            type="button"
            @click="toggleLink()"
            class="inline-flex items-center justify-center p-2 rounded-md border"
            :class="{ 'bg-purple-500 text-white border-purple-500 hover:bg-purple-600 hover:border-purple-600 dark:hover:bg-purple-400 dark:hover:border-purple-400': isActive('link', updatedAt), 'hover:bg-slate-100 dark:border-slate-600 dark:text-slate-400 dark:hover:bg-slate-700/50': !isActive('link', updatedAt) }"
        >
            <svg
                xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 24 24"
                width="24"
                height="24"
                class="h-3.5 w-3.5 fill-current"
            >
                <path
                    fill="none"
                    d="M0 0h24v24H0z"
                />
                <path d="M18.364 15.536L16.95 14.12l1.414-1.414a5 5 0 1 0-7.071-7.071L9.879 7.05 8.464 5.636 9.88 4.222a7 7 0 0 1 9.9 9.9l-1.415 1.414zm-2.828 2.828l-1.415 1.414a7 7 0 0 1-9.9-9.9l1.415-1.414L7.05 9.88l-1.414 1.414a5 5 0 1 0 7.071 7.071l1.414-1.414 1.415 1.414zm-.708-10.607l1.415 1.415-7.071 7.07-1.415-1.414 7.071-7.07z" />
            </svg>
            <span class="sr-only">{{ __('link') }}</span>
        </button>
        {{--Quote--}}
        <button
            type="button"
            @click="toggleBlockquote()"
            class="inline-flex items-center justify-center p-2 rounded-md border"
            :class="{ 'bg-purple-500 text-white border-purple-500 hover:bg-purple-600 hover:border-purple-600 dark:hover:bg-purple-400 dark:hover:border-purple-400': isActive('blockquote', updatedAt), 'hover:bg-slate-100 dark:border-slate-600 dark:text-slate-400 dark:hover:bg-slate-700/50': !isActive('blockquote', updatedAt) }"
        >
            <svg
                xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 24 24"
                width="24"
                height="24"
                class="h-3.5 w-3.5 fill-current"
            >
                <path
                    fill="none"
                    d="M0 0h24v24H0z"
                />
                <path d="M4.583 17.321C3.553 16.227 3 15 3 13.011c0-3.5 2.457-6.637 6.03-8.188l.893 1.378c-3.335 1.804-3.987 4.145-4.247 5.621.537-.278 1.24-.375 1.929-.311 1.804.167 3.226 1.648 3.226 3.489a3.5 3.5 0 0 1-3.5 3.5c-1.073 0-2.099-.49-2.748-1.179zm10 0C13.553 16.227 13 15 13 13.011c0-3.5 2.457-6.637 6.03-8.188l.893 1.378c-3.335 1.804-3.987 4.145-4.247 5.621.537-.278 1.24-.375 1.929-.311 1.804.167 3.226 1.648 3.226 3.489a3.5 3.5 0 0 1-3.5 3.5c-1.073 0-2.099-.49-2.748-1.179z" />
            </svg>
            <span class="sr-only">{{ __('blockquote') }}</span>
        </button>
        {{--Horizontal rule--}}
        <button
            type="button"
            @click="setHorizontalRule()"
            class="inline-flex items-center justify-center p-2 rounded-md border border-slate-200 hover:bg-slate-100 dark:border-slate-200/20 dark:border-slate-600 dark:text-slate-400 dark:hover:border-slate-500 dark:hover:bg-slate-700/50 dark:hover:text-slate-200"
        >
            <svg
                xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 24 24"
                width="24"
                height="24"
                class="h-3.5 w-3.5 fill-current"
            >
                <path
                    fill="none"
                    d="M0 0h24v24H0z"
                />
                <path d="M2 11h2v2H2v-2zm4 0h12v2H6v-2zm14 0h2v2h-2v-2z" />
            </svg>
            <span class="sr-only">{{ __('horizontal rule') }}</span>
        </button>
        {{--Image--}}
        <button
            type="button"
            @click="$dispatch('open-media-modal')"
            class="inline-flex items-center justify-center p-2 rounded-md border border-slate-200 hover:bg-slate-100 dark:border-slate-200/20 dark:border-slate-600 dark:text-slate-400 dark:hover:border-slate-500 dark:hover:bg-slate-700/50 dark:hover:text-slate-200"
        >
            <svg
                xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 24 24"
                width="24"
                height="24"
                class="h-3.5 w-3.5 fill-current"
            >
                <path
                    fill="none"
                    d="M0 0h24v24H0z"
                />
                <path d="M4.828 21l-.02.02-.021-.02H2.992A.993.993 0 0 1 2 20.007V3.993A1 1 0 0 1 2.992 3h18.016c.548 0 .992.445.992.993v16.014a1 1 0 0 1-.992.993H4.828zM20 15V5H4v14L14 9l6 6zm0 2.828l-6-6L6.828 19H20v-1.172zM8 11a2 2 0 1 1 0-4 2 2 0 0 1 0 4z" />
            </svg>
            <span class="sr-only">{{ __('image') }}</span>
        </button>
        {{--Undo--}}
        <button
            type="button"
            @click="undo()"
            class="inline-flex items-center justify-center p-2 rounded-md border border-slate-200 hover:bg-slate-100 dark:border-slate-200/20 dark:border-slate-600 dark:text-slate-400 dark:hover:border-slate-500 dark:hover:bg-slate-700/50 dark:hover:text-slate-200"
        >
            <svg
                xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 24 24"
                width="24"
                height="24"
                class="h-3.5 w-3.5 fill-current"
            >
                <path
                    fill="none"
                    d="M0 0h24v24H0z"
                />
                <path d="M5.828 7l2.536 2.536L6.95 10.95 2 6l4.95-4.95 1.414 1.414L5.828 5H13a8 8 0 1 1 0 16H4v-2h9a6 6 0 1 0 0-12H5.828z" />
            </svg>
            <span class="sr-only">{{ __('undo') }}</span>
        </button>
        {{--Redo--}}
        <button
            type="button"
            @click="redo()"
            class="inline-flex items-center justify-center p-2 rounded-md border border-slate-200 hover:bg-slate-100 dark:border-slate-200/20 dark:border-slate-600 dark:text-slate-400 dark:hover:border-slate-500 dark:hover:bg-slate-700/50 dark:hover:text-slate-200"
        >
            <svg
                xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 24 24"
                width="24"
                height="24"
                class="h-3.5 w-3.5 fill-current"
            >
                <path
                    fill="none"
                    d="M0 0h24v24H0z"
                />
                <path d="M18.172 7H11a6 6 0 1 0 0 12h9v2h-9a8 8 0 1 1 0-16h7.172l-2.536-2.536L17.05 1.05 22 6l-4.95 4.95-1.414-1.414L18.172 7z" />
            </svg>
            <span class="sr-only">{{ __('redo') }}</span>
        </button>
    </div>
    <div
        x-ref="element"
        class="prose prose-slate max-h-96 max-w-none overflow-y-auto sm:prose-sm prose-base prose-a:text-purple-500 hover:prose-a:text-purple-600 dark:prose-invert dark:hover:prose-a:text-purple-400"
    ></div>
</div>
