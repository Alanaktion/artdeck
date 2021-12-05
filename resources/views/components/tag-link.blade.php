<div class="inline-flex items-stretch bg-gray-200 dark:bg-gray-900 rounded-full text-sm font-semibold text-gray-700 dark:text-gray-300">
    <a class="px-3 py-1" href="{{ route('works.index', ['tags' => $tag->name]) }}">
        {{ $tag->name }}
        <span class="ml-1 text-primary-600 dark:text-primary-300">{{ $tag->works_count }}</span>
    </a>
    @if(auth()->check() && isset($work))
        <form class="-ml-1 pl-1" action="{{ route('works.tags.remove', [$work, $tag]) }}" method="post">
            @csrf
            @method('DELETE')
            <button type="submit" class="text-gray-700 hover:text-gray-900 dark:text-gray-300 dark:hover:text-gray-100 h-full px-1 -ml-1 z-10" title="{{ __('Remove tag') }}">
                <span class="sr-only">{{ __('Remove tag') }}</span>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                </svg>
            </button>
        </form>
    @endif
</div>
