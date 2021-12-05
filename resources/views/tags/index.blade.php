<x-app-layout :title="__('Tags')">
    <div class="flex flex-wrap gap-2 mb-6">
        @forelse ($tags as $tag)
            <x-tag-link :tag="$tag" />
        @empty
            <p class="text-center text-gray-600 dark:text-gray-400">
                {{ __('No tags have been added yet.') }}
            </p>
        @endforelse
    </div>
    {{ $tags->links() }}
</x-app-layout>
