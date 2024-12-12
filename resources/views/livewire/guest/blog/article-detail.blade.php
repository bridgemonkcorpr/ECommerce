<div class="bg-gradient-to-br from-pink-100 via-purple-100 via-blue-100 to-green-100 min-h-screen p-8 dark:from-purple-900 dark:via-purple-900 dark:to-indigo-900">
    <div class="max-w-3xl mx-auto">
        <!-- Back to blog link -->

           <a href="{{ route('guest.blog.articles.list') }}"
            class="inline-flex items-center text-purple-600 hover:text-purple-700 dark:text-purple-400 dark:hover:text-purple-300 transition-colors duration-200 mb-6"
        >
            <x-heroicon-m-arrow-long-left class="w-5 h-5 mr-2" />
            {{ __('Back to blog') }}
        </a>

        <!-- Content -->
        <div class="bg-white dark:bg-purple-800 rounded-3xl shadow-xl overflow-hidden p-8">
            <article class="text-base leading-7 text-purple-700 dark:text-purple-300">
                <h1 class="text-3xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-pink-500 via-purple-500 to-blue-500">
                    {{ $article->title }}
                </h1>

                <div class="mt-5 flex items-center gap-x-4 text-xs text-purple-500 dark:text-purple-400">
                    <time datetime="{{ $article->published_at->format('Y-m-d') }}">
                        {{ $article->published_at->format('M d, Y') }}
                    </time>
                </div>

                @if($article->hasMedia('cover'))
                    <div class="mt-6 relative w-full">
                        <img
                            src="{{ $article->getFirstMediaUrl('cover') }}"
                            alt="{{ $article->title }}"
                            class="aspect-[16/9] w-full rounded-2xl bg-purple-100 dark:bg-purple-700 object-cover"
                        >
                    </div>
                @endif

                <div class="mt-6 prose prose-gray max-w-none dark:prose-invert">
                    {!! $article->content !!}
                </div>
            </article>
        </div>
    </div>
</div>
