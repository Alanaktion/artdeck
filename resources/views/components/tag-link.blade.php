<div class="inline-flex items-stretch bg-gray-200 dark:bg-gray-900 rounded-full text-sm font-semibold text-gray-700 dark:text-gray-300">
    <a class="px-3 py-1" href="{{ route('works.index', ['tags' => $tag->name]) }}">
        {{ $tag->name }}
        <span class="ml-1 text-primary-600 dark:text-primary-300">{{ $tag->works_count }}</span>
    </a>
</div>
