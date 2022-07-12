<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="Core SIGESA - PSICOl">
    <title>{{ $title }} - {{config('app.name')}}</title>

    {{-- favicon --}}
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png')}}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32x32.png')}}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon-16x16.png')}}">
    <link rel="manifest" href="{{ asset('site.webmanifest')}}">
    <link rel="mask-icon" href="{{ asset('safari-pinned-tab.svg')}}" color="#e4891f">
    <meta name="msapplication-TileColor" content="#03a8d5">
    <meta name="theme-color" content="#ffffff">

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="preload"
        onload="this.rel='stylesheet'" as="style" />
    <style>
        * {
            font-display: optional
        }
    </style>
    <link rel="preload" onload="this.rel='stylesheet'" as="style" href="{{ asset('css/loading.css') }}" />
    <link rel="preload" onload="this.rel='stylesheet'" as="style" href="{{ asset('css/app.css') }}" />
    <noscript>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap"
            rel="stylesheet" />
        <link rel="stylesheet" href="{{ asset('css/loading.css') }}" />
        <link rel="stylesheet" href="{{ asset('css/app.css') }}" />
    </noscript>

    @livewireStyles
    @livewireScripts
    <script>
        window.Laravel = {csrfToken: '{{ csrf_token() }}'}
    </script>
    @auth
    <script src="{{ asset('js/config.js')}}?v={{config('app.version')}}"></script>
    <script src="{{ asset('js/app.js')}}?v={{config('app.version')}}" defer></script>
    @endauth
    <script src="{{ asset('js/alpine.js')}}?v={{config('app.version')}}" defer></script>
    <script src="{{ asset('js/init-alpine.js')}}?v={{config('app.version')}}" defer></script>
    @auth
    <script src="{{ asset('js/utils.js')}}?v={{config('app.version')}}" defer></script>
    @endauth
    <script src="{{ asset('js/guest.js')}}?v={{config('app.version')}}"></script>
    <script src="https://www.google.com/recaptcha/api.js?render={{config('services.recaptcha.sitekey')}}"></script>
</head>

<body>
    <div class="absolute r-0 mt-2 mr-2 flex gap-4">
        @foreach(array_values(config('locale.languages')) as $language)
        <a href="{{ route('changeLang', $language[0]) }}"
            class="inline-flex items-center w-full text-white text-opacity-70 font-semibold text-sm hover:text-opacity-100 transition-colors">
            <span class="mx-auto @if ($language[0]===App::getLocale()) underline @endif">{{ $language[3] }}</span>
        </a>
        @endforeach
        @auth
        <form method="POST" action="{{ route('logout') }}" class="flex">
            @csrf
            <a class="inline-flex items-center w-full w-32 text-white text-opacity-70 font-semibold text-sm hover:text-opacity-100 transition-colors"
                href="{{route('logout')}}" onclick="event.preventDefault();
        this.closest('form').submit();">
                <x-icon-logout class="w-5 h-5 mr-2" />
                <span>{{__('Logout')}}</span>
            </a>
        </form>
        @endauth
    </div>
    <div class="font-sans text-gray-900 antialiased bg-app-gradient">
        {{ $slot }}

    </div>
    @guest
    <script>
        grecaptcha.ready(function() {
             grecaptcha.execute('{{ config('services.recaptcha.sitekey') }}', {action: 'submit'}).then(function(token) {
                if (token) {
                  document.getElementById('recaptcha').value = token;
                }
             });
         });
    </script>
    @endguest
    <x-toast />
    @stack('scripts')
</body>

</html>
