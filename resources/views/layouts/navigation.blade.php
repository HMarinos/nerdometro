<nav x-data="{ open: false }" class="bg-customgrad backdrop-blur-xl rounded-[0_0_15px_15px] z-50 text-white sticky w-full top-0 shadow-[0_0_20px_rgba(0,0,0,0.8)] h-[70px] flex items-center justify-center">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8  text-white flex item-center justify-between w-full">
        <div class="flex justify-between h-16 w-full">
            <div class="flex justify-start w-1/3">
                <!-- Logo -->
                <div class="flex items-center justify-center">
                    <a href="/dashboard">
                        <x-application-logo />
                    </a>
                </div>
            </div>

            <div class="flex items-center justify-center w-1/3">
                <ul class="flex items-center justify-center gap-2 text-sm">
                    <li><a href="" class="hover:font-bold transition-all">ANIME</a></li>
                    <li class="w-[6px] h-[6px] rounded-full bg-white"></li>
                    <li><a href="" class="hover:font-bold transition-all">MOVIES</a></li>
                    <li class="w-[6px] h-[6px] rounded-full bg-white"></li>
                    <li><a href="" class="hover:font-bold transition-all">GAMES</a></li>
                </ul>
            </div>

            <div class="flex items-center justify-end gap-2 w-1/3">
                <a href="{{route('my-lists')}}" class="group">
                    <svg class="w-[24px] fill-white group-hover:scale-[1.1] transition-all" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640"><path d="M128 128C128 92.7 156.7 64 192 64L448 64C483.3 64 512 92.7 512 128L512 545.1C512 570.7 483.5 585.9 462.2 571.7L320 476.8L177.8 571.7C156.5 585.9 128 570.6 128 545.1L128 128zM192 112C183.2 112 176 119.2 176 128L176 515.2L293.4 437C309.5 426.3 330.5 426.3 346.6 437L464 515.2L464 128C464 119.2 456.8 112 448 112L192 112z"/></svg>
                </a>
                <!-- Settings Dropdown -->
                <div class="hidden sm:flex sm:items-center sm:ms-6">
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button
                                class="inline-flex items-center group px-3 py-2 text-lg leading-4 font-medium focus:outline-none transition ease-in-out duration-150 relative">
                                <div>{{ Auth::user()->name }}</div>
                                <div
                                    class="absolute w-[25px] h-[25px] inset-0 m-auto rounded-full transition-all border group-hover:translate-x-[4px] group-hover:translate-y-[-4px] border-[rgba(255,255,255,0.4)]">
                                </div>
                            </button>
                        </x-slot>
                        <x-slot name="content">
                            <x-dropdown-link :href="route('profile.edit')">
                                {{ __('Profile') }}
                            </x-dropdown-link>
                            <x-dropdown-link :href="route('user.stats')">
                                {{ __('My nerd Stats') }}
                            </x-dropdown-link>
                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                    this.closest('form').submit();">
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                </div>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open"
                    class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{ 'block': open, 'hidden': !open }" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                        onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
