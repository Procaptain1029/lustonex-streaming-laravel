<nav x-data="{ open: false }"
    class="bg-dark-800/95 backdrop-blur-md border-b border-dark-700/50 shadow-xl sticky top-0 z-40">
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('home') }}" class="flex items-center space-x-3 group">
                        <div
                            class="w-10 h-10 bg-gradient-to-br from-primary-500 to-fire-500 rounded-xl flex items-center justify-center shadow-lg group-hover:shadow-glow-red transition-all duration-300">
                            <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2L2 7v10c0 5.55 3.84 9.74 9 11 5.16-1.26 9-5.45 9-11V7l-10-5z" />
                                <circle cx="12" cy="12" r="3" />
                            </svg>
                        </div>
                        <span
                            class="text-xl font-bold bg-gradient-to-r from-white to-gray-300 bg-clip-text text-transparent">
                            Lustonex
                        </span>
                    </a>
                </div>

                
                <div class="hidden space-x-1 sm:-my-px sm:ms-10 sm:flex">
                    <a href="{{ route('home') }}"
                        class="nav-link {{ request()->routeIs('home') ? 'nav-link-active' : '' }}">
                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z" />
                        </svg>
                        {{ __('layouts.navigation.home') }}
                    </a>

                    @auth
                        @if(auth()->user()->isModel())
                            <a href="{{ route('model.dashboard') }}"
                                class="nav-link {{ request()->routeIs('model.dashboard') ? 'nav-link-active' : '' }}">
                                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z" />
                                </svg>
                                {{ __('layouts.navigation.dashboard') }}
                            </a>
                            <a href="{{ route('model.streams.index') }}"
                                class="nav-link {{ request()->routeIs('model.streams.*') ? 'nav-link-active' : '' }}">
                                <div class="w-2 h-2 bg-primary-500 rounded-full animate-pulse mr-2"></div>
                                {{ __('layouts.navigation.streams') }}
                            </a>
                            <a href="{{ route('model.photos.index') }}"
                                class="nav-link {{ request()->routeIs('model.photos.*') ? 'nav-link-active' : '' }}">
                                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" />
                                </svg>
                                {{ __('layouts.navigation.photos') }}
                            </a>
                            <a href="{{ route('model.videos.index') }}"
                                class="nav-link {{ request()->routeIs('model.videos.*') ? 'nav-link-active' : '' }}">
                                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M2 6a2 2 0 012-2h6a2 2 0 012 2v8a2 2 0 01-2 2H4a2 2 0 01-2-2V6zM14.553 7.106A1 1 0 0014 8v4a1 1 0 00.553.894l2 1A1 1 0 0018 13V7a1 1 0 00-1.447-.894l-2 1z" />
                                </svg>
                                {{ __('layouts.navigation.videos') }}
                            </a>
                        @elseif(auth()->user()->isAdmin())
                            <a href="{{ route('admin.dashboard') }}"
                                class="nav-link {{ request()->routeIs('admin.*') ? 'nav-link-active' : '' }}">
                                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-6-3a2 2 0 11-4 0 2 2 0 014 0zm-2 4a5 5 0 00-4.546 2.916A5.986 5.986 0 0010 16a5.986 5.986 0 004.546-2.084A5 5 0 0010 11z" />
                                </svg>
                                {{ __('layouts.navigation.admin_panel') }}
                            </a>
                            <a href="{{ route('admin.users.index') }}"
                                class="nav-link {{ request()->routeIs('admin.users.*') ? 'nav-link-active' : '' }}">
                                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z" />
                                </svg>
                                {{ __('layouts.navigation.users') }}
                            </a>
                        @else
                            <a href="{{ route('fan.dashboard') }}"
                                class="nav-link {{ request()->routeIs('fan.dashboard') ? 'nav-link-active' : '' }}">
                                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z" />
                                </svg>
                                Dashboard
                            </a>
                            <a href="{{ route('fan.missions.index') }}"
                                class="nav-link {{ request()->routeIs('fan.missions.*') ? 'nav-link-active' : '' }}">
                                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z" />
                                    <path fill-rule="evenodd"
                                        d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z"
                                        clip-rule="evenodd" />
                                </svg>
                                {{ __('layouts.navigation.missions') }}
                            </a>
                            <a href="{{ route('fan.achievements.index') }}"
                                class="nav-link {{ request()->routeIs('fan.achievements.*') ? 'nav-link-active' : '' }}">
                                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                                {{ __('layouts.navigation.achievements') }}
                            </a>
                            <a href="{{ route('fan.leaderboard.index') }}"
                                class="nav-link {{ request()->routeIs('fan.leaderboard.*') ? 'nav-link-active' : '' }}">
                                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M2 11a1 1 0 011-1h2a1 1 0 011 1v5a1 1 0 01-1 1H3a1 1 0 01-1-1v-5zM8 7a1 1 0 011-1h2a1 1 0 011 1v9a1 1 0 01-1 1H9a1 1 0 01-1-1V7zM14 4a1 1 0 011-1h2a1 1 0 011 1v12a1 1 0 01-1 1h-2a1 1 0 01-1-1V4z" />
                                </svg>
                                {{ __('layouts.navigation.ranking') }}
                            </a>
                        @endif
                    @endauth
                </div>
            </div>

            
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                @auth
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button
                                class="inline-flex items-center px-4 py-2 border border-dark-600/50 text-sm leading-4 font-medium rounded-lg text-gray-300 bg-dark-700/50 hover:text-white hover:bg-dark-600/50 focus:outline-none focus:ring-2 focus:ring-primary-500/50 transition ease-in-out duration-150">
                                <div class="flex items-center">
                                    <div
                                        class="w-8 h-8 bg-gradient-to-br from-primary-500 to-fire-500 rounded-full flex items-center justify-center mr-3">
                                        <span
                                            class="text-white font-bold text-sm">{{ substr(auth()->user()->name ?? 'U', 0, 1) }}</span>
                                    </div>
                                    <div>{{ auth()->user()->name ?? __('layouts.navigation.user') }}</div>
                                </div>

                                <div class="ms-2">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            @if(auth()->user()->isModel())
                                <x-dropdown-link :href="route('model.profile.edit')">
                                    {{ __('layouts.navigation.profile') }}
                                </x-dropdown-link>
                                <x-dropdown-link :href="route('profiles.show', auth()->user())">
                                    {{ __('layouts.navigation.public_profile') }}
                                </x-dropdown-link>
                            @else
                                <x-dropdown-link :href="route('fan.profile.index')">
                                    {{ __('Mi Perfil') }}
                                </x-dropdown-link>
                                <x-dropdown-link :href="route('fan.tokens.index')">
                                    {{ __('layouts.navigation.tokens') }}
                                </x-dropdown-link>
                                <x-dropdown-link :href="route('fan.subscriptions.index')">
                                    {{ __('layouts.navigation.subscriptions') }}
                                </x-dropdown-link>
                                <x-dropdown-link :href="route('fan.favorites.index')">
                                    {{ __('layouts.navigation.favorites') }}
                                </x-dropdown-link>
                                <x-dropdown-link :href="route('fan.notifications.index')">
                                    {{ __('layouts.navigation.notifications') }}
                                </x-dropdown-link>
                            @endif

                            
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf

                                <x-dropdown-link :href="route('logout')" onclick="event.preventDefault();
                                                        this.closest('form').submit();">
                                    {{ __('layouts.navigation.logout') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                @else
                    <div class="flex items-center space-x-3">
                        <a href="{{ route('login') }}" class="btn-ghost px-4 py-2 text-sm">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1">
                                </path>
                            </svg>
                            {{ __('layouts.navigation.login') }}
                        </a>
                        <a href="{{ route('register') }}" class="btn-primary px-4 py-2 text-sm">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z">
                                </path>
                            </svg>
                            {{ __('layouts.navigation.register') }}
                        </a>
                    </div>
                @endauth
            </div>

            
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open"
                    class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('home')" :active="request()->routeIs('home')">
                {{ __('layouts.navigation.home') }}
            </x-responsive-nav-link>

            @auth
                @if(auth()->user()->isModel())
                    <x-responsive-nav-link :href="route('model.dashboard')" :active="request()->routeIs('model.dashboard')">
                        {{ __('layouts.navigation.dashboard') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('model.streams.index')" :active="request()->routeIs('model.streams.*')">
                        {{ __('layouts.model.nav.streams') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('model.photos.index')" :active="request()->routeIs('model.photos.*')">
                        {{ __('layouts.model.nav.photos') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('model.videos.index')" :active="request()->routeIs('model.videos.*')">
                        {{ __('layouts.model.nav.videos') }}
                    </x-responsive-nav-link>
                @elseif(auth()->user()->isAdmin())
                    <x-responsive-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.*')">
                        {{ __('layouts.navigation.admin_panel') }}
                    </x-responsive-nav-link>
                @else
                    <x-responsive-nav-link :href="route('fan.dashboard')" :active="request()->routeIs('fan.dashboard')">
                        {{ __('layouts.navigation.dashboard') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('fan.tokens.index')" :active="request()->routeIs('fan.tokens.*')">
                        {{ __('layouts.navigation.tokens') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('fan.subscriptions.index')"
                        :active="request()->routeIs('fan.subscriptions.*')">
                        {{ __('layouts.navigation.subscriptions') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('fan.missions.index')" :active="request()->routeIs('fan.missions.*')">
                        {{ __('layouts.navigation.missions') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('fan.favorites.index')" :active="request()->routeIs('fan.favorites.*')">
                        {{ __('layouts.navigation.favorites') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('fan.notifications.index')"
                        :active="request()->routeIs('fan.notifications.*')">
                        {{ __('layouts.navigation.notifications') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('fan.achievements.index')"
                        :active="request()->routeIs('fan.achievements.*')">
                        {{ __('layouts.navigation.achievements') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('fan.leaderboard.index')"
                        :active="request()->routeIs('fan.leaderboard.*')">
                        {{ __('layouts.navigation.ranking') }}
                    </x-responsive-nav-link>
                @endif
            @endauth
        </div>

        @auth
            
            <div class="pt-4 pb-1 border-t border-gray-200">
                <div class="px-4">
                    <div class="font-medium text-base text-gray-800">{{ auth()->user()->name ?? __('layouts.navigation.user') }}</div>
                    <div class="font-medium text-sm text-gray-500">{{ auth()->user()->email ?? '' }}</div>
                </div>

                <div class="mt-3 space-y-1">
                    @if(auth()->user()->isModel())
                        <x-responsive-nav-link :href="route('model.profile.edit')">
                            {{ __('Mi Perfil') }}
                        </x-responsive-nav-link>
                    @else
                        <x-responsive-nav-link :href="route('fan.profile.index')">
                            {{ __('Mi Perfil') }}
                        </x-responsive-nav-link>
                    @endif

                    
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf

                        <x-responsive-nav-link :href="route('logout')" onclick="event.preventDefault();
                                                this.closest('form').submit();">
                            {{ __('Cerrar Sesión') }}
                        </x-responsive-nav-link>
                    </form>
                </div>
            </div>
        @else
            <div class="pt-4 pb-1 border-t border-dark-700/50">
                <div class="px-4 space-y-3">
                    <a href="{{ route('login') }}" class="btn-ghost w-full justify-center py-3">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1">
                            </path>
                        </svg>
                        Iniciar Sesión
                    </a>
                    <a href="{{ route('register') }}" class="btn-primary w-full justify-center py-3">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z">
                            </path>
                        </svg>
                        Registrarse
                    </a>
                </div>
            </div>
        @endauth
    </div>
</nav>