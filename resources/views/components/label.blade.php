@props(['value', 'optional'])

<label {{ $attributes->merge(['class' => 'block font-medium text-sm text-gray-700 dark:text-gray-300']) }}>
    {{ $value ?? $slot }}
    @if ($optional ?? false)
        <span class="text-gray-500 dark:text-gray-400">{{ __('(optional)') }}</span>
    @endif
</label>
