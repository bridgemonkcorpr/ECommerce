@props(['rating' => 0])

<div class="flex items-center">
    @for($star = 1; $star <= 5; $star++)
        <x-heroicon-s-star class="h-5 w-5 flex-shrink-0 {{ $star > $rating ? 'text-slate-300' : 'text-purple-500' }}" />
    @endfor
</div>
