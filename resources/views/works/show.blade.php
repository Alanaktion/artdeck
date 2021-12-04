<x-guest-layout>
    <div class="sm:flex">
        <div class="sm:w-60">
            <a class="btn btn-primary" href="{{ $work->file_url }}" download>
                {{ __('Download') }}
            </a>
        </div>
        <div class="flex-1">
            <img src="{{ $work->file_url }}" alt="">
        </div>
    </div>
</x-guest-layout>
