<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ !empty($title) ? $title . ' - ' . config('app.name', 'ArtDeck') : config('app.name', 'ArtDeck') }}</title>

        <link rel="shortcut icon" href="{{ asset('favicon.svg') }}" type="image/svg+xml">
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
        <script src="{{ asset('js/app.js') }}" defer></script>
    </head>
    <body>
        <header class="border-b bg-white dark:bg-gray-900 shadow">
            <div class="container">
                <div class="flex items-center gap-4 py-4 border-b">
                    <a href="/" class="text-2xl font-light hover:text-primary-600 dark:hover:text-primary-500">{{ config('app.name', 'ArtDeck') }}</a>
                    <form class="ml-auto" action="/works">
                        <label for="search_tags" class="sr-only">Search works</label>
                        <input type="search" name="tags" id="search_tags" placeholder="Search works" value="{{ $searchTags ?? '' }}">
                    </form>
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-800 dark:text-gray-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
                <nav class="flex items-center py-2 gap-1">
                    <a href="/works" class="nav-link {{ Route::is('works.*') ? 'nav-link__current' : '' }}">Works</a>
                    <a href="/tags" class="nav-link {{ Route::is('tags.*') ? 'nav-link__current' : '' }}">Tags</a>
                    <a href="/wiki" class="nav-link {{ Route::is('wiki.*') ? 'nav-link__current' : '' }}">Wiki</a>
                    <a href="/dashboard" class="nav-link {{ Route::is('dashboard', 'dashboard.*', 'login', 'register') ? 'nav-link__current' : '' }}">My account</a>
                </nav>
            </div>
        </header>

        <main id="main" class="container py-4 md:py-6">
            {{ $slot }}
        </main>
    </body>
</html>
