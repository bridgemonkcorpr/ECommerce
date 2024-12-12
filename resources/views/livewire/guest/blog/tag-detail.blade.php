<div class="bg-gradient-to-br from-pink-100 via-purple-100 via-blue-100 to-green-100 min-h-screen p-8 dark:from-purple-900 dark:via-purple-900 dark:to-indigo-900">
    <div class="max-w-3xl mx-auto">
        <!-- Back to blog link -->

           <a href="{{ route('guest.blog.articles.list') }}"
            class="inline-flex items-center text-purple-600 hover:text-purple-700 dark:text-purple-400 dark:hover:text-purple-300 transition-colors duration-200 mb-6"
        >
            <x-heroicon-m-arrow-long-left class="w-5 h-5 mr-2" />
            {{ __('Back to blog') }}
        </a>

        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-pink-500 via-purple-500 to-blue-500">
                {{ __('Tag: :tagName', ['tagName' => $tag->name]) }}
            </h1>
        </div>

        <!-- Content -->
        <div class="bg-white dark:bg-purple-800 rounded-3xl shadow-xl overflow-hidden p-8">
            <div class="space-y-16 border-t border-purple-200 dark:border-purple-700 pt-10">
                @foreach($articles as $article)
                    <article class="flex flex-col items-start justify-between">
                        @if($article->hasMedia('cover'))
                            <div class="relative w-full">
                                <img
                                    src="{{ $article->getFirstMediaUrl('cover') }}"
                                    alt="{{ $article->title }}"
                                    class="aspect-[16/9] w-full rounded-2xl bg-purple-100 dark:bg-purple-700 object-cover"
                                >
                            </div>
                        @endif
                        <div class="mt-8 flex items-center gap-x-4 text-xs text-purple-500 dark:text-purple-400">
                            <time datetime="{{ $article->published_at->format('Y-m-d') }}">
                                {{ $article->published_at->format('M d, Y') }}
                            </time>
                        </div>
                        <div class="group relative">
                            <h3 class="mt-3 text-lg font-semibold leading-6 text-purple-900 dark:text-purple-100 group-hover:text-purple-600 dark:group-hover:text-purple-400">
                                <a href="{{ route('guest.blog.articles.detail', $article->slug) }}">
                                    <span class="absolute inset-0"></span>
                                    {{ $article->title }}
                                </a>
                            </h3>
                            @if($article->excerpt)
                                <div class="mt-5 max-w-none prose prose-gray dark:prose-invert line-clamp-2">
                                    {!! $article->excerpt !!}
                                </div>
                            @endif
                        </div>
                        <div class="mt-8">
                            @foreach($article->tags as $tag)
                                <a href="{{ route('guest.blog.tags.detail', $tag->slug) }}">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200 hover:bg-purple-200 dark:hover:bg-purple-800 transition-colors duration-200 mr-2">
                                        {{ $tag->name }}
                                    </span>
                                </a>
                            @endforeach
                        </div>
                    </article>
                @endforeach
            </div>
        </div>

        <div class="mt-6">
            {{ $articles->links() }}
        </div>
    </div>
</div>
