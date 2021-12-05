<x-app-layout :title="__('Unauthorized')">
    <div class="py-8 md:py-20 text-center">
        <p class="text-4xl mb-4">
            {{ __('Service Unavailable') }}
        </p>
        <p class="text-gray-600 dark:text-gray-400">
            {{ __('Something went wrong displaying this page. Try again later.') }}
        </p>
    </div>
</x-app-layout>
