<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ !empty($title) ? $title . ' - ' . config('app.name', 'ArtDeck') : config('app.name', 'ArtDeck') }}</title>

        <link rel="shortcut icon" href="{{ asset('favicon.svg') }}" type="image/svg+xml">
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
        <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
        <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined">
        @routes
        <script src="{{ asset('js/app.js') }}" defer></script>
    </head>
    <body>
        @include('layouts.navigation')

        @if (session('success'))
            <div class="container mt-4">
                <div class="rounded border border-green-700 bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100 px-4 py-3" role="alert">
                    {{ session('success') }}
                </div>
            </div>
        @endif
        @if (session('error'))
            <div class="container mt-4">
                <div class="rounded border border-red-700 bg-red-100 text-red-800 dark:bg-red-800 dark:text-red-100 px-4 py-3" role="alert">
                    {{ session('error') }}
                </div>
            </div>
        @endif

        <main id="main" class="container py-4 md:py-6">
            {{ $slot }}
        </main>
    </body>
</html>
