<x-app-layout :title="__('Works')">
    <div class="sm:flex gap-6">
        <div class="sm:w-60">
            @auth
                <a class="btn btn-primary" href="{{ route('works.create') }}">
                    {{ __('Add work') }}
                </a>
            @endauth
            <dl class="my-6">
                <dt class="uppercase text-gray-600 dark:text-gray-400 text-xs mb-1">
                    {{ __('Tags') }}
                </dt>
                <dd class="mb-4 flex flex-col gap-2 items-start">
                    @forelse($tags as $tag)
                        <x-tag-link :tag="$tag"/>
                    @empty
                        <span class="text-gray-600 dark:text-gray-400">{{ __('None') }}</span>
                    @endforelse
                </dd>
            </dl>
        </div>
        <div class="flex-1">
            <div class="w-full grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-4 mb-6">
                @foreach($works as $work)
                    <div class="flex flex-col items-center justify-center">
                        <a class="block max-w-full" href="{{ route('works.show', $work) }}">
                            @if ($work->type == 'image')
                                <img src="{{ $work->thumbnail_url }}" alt="" class="rounded-sm hover:brightness-105">
                            @endif
                            <p class="mt-1 truncate" title="{{ $work->title ?? basename($work->file_path) }}">
                                {{ $work->title ?? basename($work->file_path) }}
                            </p>
                        </a>
                    </div>
                @endforeach
            </div>
            {{ $works->links() }}
        </div>
    </div>
</x-app-layout>
