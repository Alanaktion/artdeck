<x-guest-layout>
    <div class="sm:flex">
        <div class="sm:w-60">
            <a class="btn btn-primary" href="{{ route('works.create') }}">
                {{ __('Add work') }}
            </a>
        </div>
        <div class="flex-1 grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-4">
            @foreach($works as $work)
                <div class="flex flex-col items-center justify-center">
                    <a class="block max-w-full" href="{{ route('works.show', $work) }}">
                        @if ($work->type == 'image')
                            <img src="{{ $work->thumbnail_url }}" alt="" class="rounded-sm hover:brightness-105">
                        @endif
                        <p class="mt-1 truncate">{{ $work->title ?? basename($work->file_path) }}</p>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</x-guest-layout>
