<header class="z-30 py-4 bg-white shadow-md dark:bg-gray-800 fixed top-0 sm:relative w-full transition-colors">
    <div
        class="container flex items-center justify-between h-full px-6 mx-auto text-psi-blue-600 dark:text-psi-blue-300 gap-3">
        <!-- Mobile hamburger -->
        @if (is_null(getUserToken()))
        <button class="p-1 shadow -ml-1 rounded-md focus:outline-none focus:shadow-outline-psi-blue"
            @click="toggleSideMenu" aria-label="Menu" x-bind:class="{'hidden' : !mobile}">
            <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd"
                    d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z"
                    clip-rule="evenodd"></path>
            </svg>
        </button>
        @endif
        <!-- Search input -->
        <div class="lg:mr-auto lg:ml-0 w-full max-w-md lg:max xl:max-w-2xl">
            @auth
            @if (isStandarUser())
            <div class="relative w-full max-w-xl mr-6 focus-within:text-psi-blue-500">
                <div class="absolute inset-y-0 flex items-center pl-2">
                    <x-icon-search class="w-4 h-4"/>
                </div>
                <form x-on:submit.prevent>
                    @livewire('search-to-do')
                </form>
            </div>
            @else
            <span class="text-lg font-bold text-psi-gray dark:text-gray-200 inline-flex mx-auto" href="/">
                <x-logo-sharing class="w-16 pr-2 dark:current"/><x-application-logo class="w-36 pl-2 border-l-2 border-gray-600 dark:border-gray-200 h-min my-auto" />
            </span>
            @endif
            @endauth
        </div>
        <ul class="flex items-center flex-shrink-0 space-x-4">
            <!-- Theme toggler -->
            <li class="flex">
                <button class="rounded-md focus:outline-none focus:shadow-outline-psi-blue" id="btn-toggle-theme"
                    @click="toggleTheme" aria-label="Toggle color mode">
                    <template x-if="!dark">
                        <x-icon-moon class="w-4 h-4"/>
                    </template>
                    <template x-if="dark">
                        <x-icon-sun class="w-4 h-4"/>
                    </template>
                </button>
            </li>
            <!-- Notifications menu -->
            @auth
            @if (isStandarUser())
            @livewire('notification-item')
            @endif
            @endauth
            <!-- Profile menu -->
            <li class="relative">
                @php
                $name = 'Yonier';
                @endphp
                <button class="align-middle rounded-full focus:shadow-outline-psi-blue focus:outline-none"
                    @click="toggleProfileMenu" @keydown.escape="closeProfileMenu" aria-label="Account"
                    aria-haspopup="true" id="btn-profile-options">

                    {{-- @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                    <img class="object-cover w-8 h-8 rounded-full" width="32" height="32"
                        src="{{ isStandarUser() ? Auth::user()->profile_photo_url :  guestPhoto() }}" alt="{{ $name }}" aria-hidden="true" />
                        @endif --}}
                </button>
                <template x-if="isProfileMenuOpen">
                    <ul x-transition:leave="transition ease-in duration-150" id="profile-options"
                        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                        @click.away="closeProfileMenu" @keydown.escape="closeProfileMenu"
                        class="absolute right-0 w-60 p-2 mt-2 space-y-2 text-gray-600 bg-white border border-gray-100 rounded-md shadow-md dark:border-gray-700 dark:text-gray-300 dark:bg-gray-700"
                        aria-label="submenu">
                        @if (is_null(getUserToken()))
                        <li class="px-2">
                            <div class="font-medium text-sm text-gray-800">{{ $name }}</div>
                            @auth
                            @if (isStandarUser())
                            <div class="font-medium text-xs text-gray-400">{{ Auth::user()->username }}</div>
                            @endif
                            @endauth
                            <div class="border-b border-gray-300 my-1 shadow"></div>
                        </li>
                        {{-- <li class="flex">
                            <a class="inline-flex items-center w-full px-2 py-1 text-sm font-semibold transition-colors duration-150 rounded-md hover:bg-gray-100 hover:text-gray-800 dark:hover:bg-gray-800 dark:hover:text-gray-200"
                                href="{{ route('profile.show') }}">
                                <x-icon-user-r class="w-5 h-5 mr-2"/>
                                <span>{{__('Profile') }}</span>
                            </a>
                        </li>
                        @if(auth()->user()->hasAnyPermission(['system.manage_token_expiratio','system.manage_password_expiration','system.manage_file_expiration','system.downloads_amount']))
                        <li class="flex">
                            <a class="inline-flex items-center w-full px-2 py-1 text-sm font-semibold transition-colors duration-150 rounded-md hover:bg-gray-100 hover:text-gray-800 dark:hover:bg-gray-800 dark:hover:text-gray-200"
                                href="{{route('settings.index')}}">
                                <x-icon-cog class="w-5 h-5 mr-2"/>
                                <span>{{__('Settings')}}</span>
                            </a>
                        </li>
                        @endif --}}
                        @endif
                        {{-- <form class="flex" method="POST" action="{{ route('logout') }}">
                            @csrf
                            <a class="inline-flex items-center w-full px-2 py-1 text-sm font-semibold transition-colors duration-150 rounded-md hover:bg-gray-100 hover:text-gray-800 dark:hover:bg-gray-800 dark:hover:text-gray-200"
                            href="{{route('logout')}}"  onclick="event.preventDefault();
                            this.closest('form').submit();">
                                <x-icon-logout class="w-5 h-5 mr-2"/>
                                <span>{{__('Logout')}}</span>
                            </a>
                        </form> --}}
                        <li class="flex flex-wrap">
                            <div class="border-b border-gray-300 mb-2 shadow w-full px-2"></div>
                            <div class="inline-flex items-center px-2 py-1 text-sm font-semibold">
                                <x-icon-globe-americas class="items-center w-5 h-5 my-auto"/>
                            </div>
                           {{--  @foreach(array_values(config('locale.languages')) as $language)
                            <a href="{{ route('changeLang', $language[0]) }}"
                                class="inline-flex items-center w-5/12 px-2 py-1 text-sm font-semibold transition-colors duration-150 rounded-md hover:bg-gray-100 hover:text-gray-800 dark:hover:bg-gray-800 dark:hover:text-gray-200">
                                <span
                                    class="mx-auto @if ($language[0]===App::getLocale()) underline @endif">{{ $language[3] }}</span>
                            </a>
                            @endforeach --}}
                        </li>
                    </ul>
                </template>
            </li>
        </ul>
    </div>
</header>
