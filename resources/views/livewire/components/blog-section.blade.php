<div>
    <div class="mx-auto mt-5 grid max-w-2xl grid-cols-1 gap-x-8 gap-y-20 md:mx-0 md:max-w-none lg:grid-cols-3">
        @foreach($this->articles as $article)
            <article class="relative group overflow-hidden transition transform ease-in hover:-translate-y-1">
                @if($article->hasMedia('cover'))
                    {{ $article->getFirstMedia('cover')('responsive')->attributes(['alt' => $article->title, 'class' => 'aspect-[16/9] w-full bg-slate-100 object-cover rounded-lg sm:aspect-[2/1] lg:aspect-[3/2]']) }}
                @else
                    <img
                        src="{{ $article->getFirstMediaUrl('cover') }}"
                        alt="{{ $article->title }}"
                        class="aspect-[16/9] w-full bg-slate-100 object-cover rounded-lg sm:aspect-[2/1] lg:aspect-[3/2]"
                    >
                @endif
                <div class="bg-white pt-4 sm:pt-6">
                    <time
                        datetime="{{ $article->published_at->format('Y-m-d') }}"
                        class="text-xs text-slate-500"
                    >
                        {{ $article->published_at->format('M d, Y') }}
                    </time>
                    <a href="{{ route('guest.blog.articles.detail', $article->slug) }}">
                        <h3 class="mt-3 text-lg font-semibold leading-6 text-slate-900 line-clamp-2">
                            <span class="absolute inset-0"></span>
                            {!! $article->title !!}
                        </h3>
                    </a>
                    <div class="mt-5 prose prose-sm prose-slate line-clamp-3">
                        {!! $article->excerpt !!}
                    </div>
                    <p class="mt-5 flex items-center text-sm font-medium">
                        <span>
                            {{ __('Read more') }}
                        </span>
                        <svg
                            class="mt-0.5 ml-2 -mr-1 stroke-slate-900 stroke-2"
                            fill="none"
                            width="10"
                            height="10"
                            viewBox="0 0 10 10"
                            aria-hidden="true"
                        >
                            <path
                                class="opacity-0 transition group-hover:opacity-100"
                                d="M0 5h7"
                            ></path>
                            <path
                                class="transition group-hover:translate-x-[3px]"
                                d="M1 1l4 4-4 4"
                            ></path>
                        </svg>
                    </p>
                </div>
            </article>
        @endforeach
    </div>
</div>
