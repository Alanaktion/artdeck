<x-app-layout :title="__('Add work')">
    <nav class="flex items-center py-2 gap-1 mb-6 justify-center">
        <span class="text-gray-600 dark:text-gray-400 mr-2">
            {{ __('Type') }}
        </span>
        <a href="{{ route('works.create', ['type' => 'image']) }}" class="nav-link {{ $type == 'image' ? 'nav-link__current' : '' }}">
            {{ __('Image') }}
        </a>
        <a href="{{ route('works.create', ['type' => 'text']) }}" class="nav-link {{ $type == 'text' ? 'nav-link__current' : '' }}">
            {{ __('Text') }}
        </a>
    </nav>

    @include("works.create.$type")
</x-app-layout>
