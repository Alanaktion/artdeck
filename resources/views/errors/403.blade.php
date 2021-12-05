<x-app-layout :title="__('Unauthorized')">
    <div class="py-8 md:py-20 text-center">
        <p class="text-4xl mb-4">
            {{ __('Forbidden') }}
        </p>
        <p class="text-gray-600 dark:text-gray-400">
            {{ __('You are not authorized to access this page.') }}
        </p>
    </div>
</x-app-layout>
