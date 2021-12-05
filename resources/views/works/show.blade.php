<x-app-layout :title="$work->title">
    <div class="sm:flex gap-6">
        <div class="sm:w-60">
            <dl>
                <dt class="uppercase text-gray-600 dark:text-gray-400 text-xs mb-1">
                    {{ __('Type') }}
                </dt>
                <dd class="mb-4">
                    <span class="capitalize">{{ __($work->type) }}</span>
                    @if ($work->type == 'image' && $work->file_path)
                        <span class="text-gray-600 dark:text-gray-400">&middot;</span>
                        <span class="uppercase">{{ pathinfo($work->file_path, PATHINFO_EXTENSION) }}</span>
                    @endif
                </dd>
                @if ($work->user_id)
                    <dt class="uppercase text-gray-600 dark:text-gray-400 text-xs mb-1">
                        {{ __('Uploaded by') }}
                    </dt>
                    <dd class="mb-4">
                        {{ $work->user->name }}
                    </dd>
                @endif
                @if ($work->file_size)
                    <dt class="uppercase text-gray-600 dark:text-gray-400 text-xs mb-1">
                        {{ __('Size') }}
                    </dt>
                    <dd class="mb-4">
                        {{ $work->formatSize() }}
                    </dd>
                @endif
                @if ($work->width)
                    <dt class="uppercase text-gray-600 dark:text-gray-400 text-xs mb-1">
                        {{ __('Dimensions') }}
                    </dt>
                    <dd class="mb-4">
                        {{ $work->width }} x {{ $work->height }}
                    </dd>
                @endif
                <dt class="uppercase text-gray-600 dark:text-gray-400 text-xs mb-1">
                    {{ __('Tags') }}
                </dt>
                <dd class="mb-4">
                    <div class="flex flex-wrap gap-2">
                        @forelse($tags as $tag)
                            <x-tag-link :tag="$tag" :work="$work" />
                        @empty
                            <span class="text-gray-600 dark:text-gray-400">{{ __('None') }}</span>
                        @endforelse
                    </div>
                    @auth
                        <form class="flex mt-4" action="{{ route('works.tags.add', $work) }}" method="post">
                            @csrf
                            <input class="flex-1 min-w-0 !rounded-r-none" type="text" name="tag" placeholder="{{ __('Add tag') }}">
                            <button type="submit" class="btn btn-primary px-3 rounded-l-none">
                                <span class="sr-only">
                                    {{ __('Add tag') }}
                                </span>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </form>
                    @endauth
                </dd>
                @if ($work->source_url)
                    <dt class="uppercase text-gray-600 dark:text-gray-400 text-xs mb-1">
                        {{ __('Source') }}
                    </dt>
                    <dd class="mb-4 truncate">
                        <a class="link" href="{{ $work->source_url }}" target="_blank" rel="nofollow noopener">
                            {{ parse_url($work->source_url, PHP_URL_HOST) }}
                        </a>
                    </dd>
                @endif
            </dl>
            <a class="btn btn-primary" href="{{ $work->file_url }}" download>
                {{ __('Download') }}
            </a>
        </div>
        <div class="flex-1">
            <img src="{{ $work->file_url }}" alt="" class="mb-6">
            @if ($work->title)
                <h1 class="text-3xl mb-2">{{ $work->title }}</h1>
            @endif
            @if ($work->description)
                <p class="mb-4 whitespace-pre-wrap">{{ $work->description }}</p>
            @endif
        </div>
    </div>
</x-app-layout>
