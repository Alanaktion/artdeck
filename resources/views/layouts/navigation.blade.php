<header class="border-b bg-white dark:bg-gray-900 shadow">
    <div class="container">
        <div class="flex flex-wrap items-center gap-4 py-4 border-b">
            <a href="/" class="text-2xl font-light hover:text-primary-600 dark:hover:text-primary-500">{{ config('app.name', 'ArtDeck') }}</a>
            <form class="order-2 flex-grow flex-shrink-0 sm:flex-grow-0 sm:ml-auto sm:order-none" action="/works">
                <label for="search_tags" class="sr-only">Search works</label>
                <input class="w-full sm:w-auto" type="search" name="tags" id="search_tags" placeholder="Search works" value="{{ $searchTags ?? '' }}">
            </form>
            @auth
                <x-dropdown align="right" width="48" class="ml-auto sm:ml-0">
                    <x-slot name="trigger">
                        <button class="flex items-center text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-800 dark:text-gray-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <div class="sr-only">{{ Auth::user()->name }}</div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            @endauth
        </div>
        <nav class="flex items-center py-2 gap-1">
            <a href="{{ route('works.index') }}" class="nav-link {{ Route::is('works.*') ? 'nav-link__current' : '' }}">
                {{ __('Works') }}
            </a>
            <a href="{{ route('tags.index') }}" class="nav-link {{ Route::is('tags.*') ? 'nav-link__current' : '' }}">
                {{ __('Tags') }}
            </a>
            <a href="{{ route('dashboard') }}" class="nav-link {{ Route::is('dashboard*') ? 'nav-link__current' : '' }}">
                {{ __('Dashboard') }}
            </a>
        </nav>
    </div>
</header>
