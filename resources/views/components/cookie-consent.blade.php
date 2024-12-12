<div x-data="{ isTemporaryHidden: false, isCookiesAllowed: $persist(false).as('is-cookies-allowed') }">
    <div
        x-cloak
        x-show="!isCookiesAllowed && !isTemporaryHidden"
        class="fixed inset-x-0 bottom-0 flex flex-col justify-between gap-x-8 gap-y-4 bg-white p-6 ring-1 ring-purple-900/10 md:flex-row md:items-center lg:px-8"
    >
        <p class="max-w-4xl text-sm leading-6 text-purple-900">
            {!! $generalSettings->cookie_consent_message !!}
        </p>
        <div class="flex flex-none items-center gap-x-5">
            <button
                x-on:click="isCookiesAllowed = true"
                type="button"
                class="rounded-md bg-purple-900 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-purple-700 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-purple-900"
            >
                {{ $generalSettings->cookie_consent_agree }}
            </button>
            <button
                x-on:click="isTemporaryHidden = true"
                type="button"
                class="text-sm font-semibold leading-6 text-purple-900"
            >
                {{ $generalSettings->cookie_consent_reject }}
            </button>
        </div>
    </div>
</div>
