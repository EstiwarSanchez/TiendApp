<!DOCTYPE html>
<html :class="{ 'dark': dark }" x-data="data()" lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="TiendApp">
    <title> {{ $title }} - {{config('app.name')}}</title>


    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png')}}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32x32.png')}}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon-16x16.png')}}">
    <link rel="manifest" href="{{ asset('site.webmanifest')}}">
    <link rel="mask-icon" href="{{ asset('safari-pinned-tab.svg')}}" color="#e4891f">
    <meta name="msapplication-TileColor" content="#03a8d5">
    <meta name="theme-color" content="#ffffff">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap"
        rel="preload" onload="this.rel='stylesheet'" as="style" />
    <style>
        *{
            font-display: optional
        }
    </style>
    <link rel="preload" onload="this.rel='stylesheet'" as="style" href="{{ asset('css/loading.css') }}?v={{config('app.version')}}" />
    <link rel="preload" onload="this.rel='stylesheet'" as="style" href="{{ asset('css/app.css') }}?v={{config('app.version')}}" />
    <link rel="preload" onload="this.rel='stylesheet'" as="style" href="{{ asset('css/flatpickr.min.css') }}?v={{config('app.version')}}">
    <link rel="preload" onload="this.rel='stylesheet'" as="style" href="{{ asset('css/main.css') }}?v={{config('app.version')}}" />
    <noscript>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap"
        rel="stylesheet" />
        <link rel="stylesheet" href="{{ asset('css/loading.css') }}?v={{config('app.version')}}" />
        <link rel="stylesheet" href="{{ asset('css/app.css') }}?v={{config('app.version')}}" />
        <link rel="stylesheet" href="{{ asset('css/flatpickr.min.css') }}?v={{config('app.version')}}">
        <link rel="stylesheet" href="{{ asset('css/main.css') }}?v={{config('app.version')}}" />
    </noscript>
    <script>
        /*! loadCSS. [c]2017 Filament Group, Inc. MIT License */
        !function(a){"use strict";var b=function(b,c,d){function e(a){return h.body?a():void setTimeout(function(){e(a)})}function f(){i.addEventListener&&i.removeEventListener("load",f),i.media=d||"all"}var g,h=a.document,i=h.createElement("link");if(c)g=c;else{var j=(h.body||h.getElementsByTagName("head")[0]).childNodes;g=j[j.length-1]}var k=h.styleSheets;i.rel="stylesheet",i.href=b,i.media="only x",e(function(){g.parentNode.insertBefore(i,c?g:g.nextSibling)});var l=function(a){for(var b=i.href,c=k.length;c--;)if(k[c].href===b)return a();setTimeout(function(){l(a)})};return i.addEventListener&&i.addEventListener("load",f),i.onloadcssdefined=l,l(f),i};"undefined"!=typeof exports?exports.loadCSS=b:a.loadCSS=b}("undefined"!=typeof global?global:this);
         /*! loadCSS rel=preload polyfill. [c]2017 Filament Group, Inc. MIT License */
         !function(a){if(a.loadCSS){var b=loadCSS.relpreload={};if(b.support=function(){try{return a.document.createElement("link").relList.supports("preload")}catch(b){return!1}},b.poly=function(){for(var b=a.document.getElementsByTagName("link"),c=0;c<b.length;c++){var d=b[c];"preload"===d.rel&&"style"===d.getAttribute("as")&&(a.loadCSS(d.href,d,d.getAttribute("media")),d.rel=null)}},!b.support()){b.poly();var c=a.setInterval(b.poly,300);a.addEventListener&&a.addEventListener("load",function(){b.poly(),a.clearInterval(c)}),a.attachEvent&&a.attachEvent("onload",function(){a.clearInterval(c)})}}}(this);
        </script>

    @livewireStyles
    @livewireScripts
    <script>window.Laravel = {csrfToken: '{{ csrf_token() }}'}</script>
    <script src="{{ asset('js/config.js')}}?v={{config('app.version')}}"></script>
    <script src="{{ asset('js/alpine.js') }}?v={{config('app.version')}}" defer></script>
    <script src="{{ asset('js/app.js') }}?v={{config('app.version')}}" defer></script>
    <script src="{{ asset('js/flatpickr.min.js') }}?v={{config('app.version')}}" defer></script>
    <script src="{{ asset('js/flatpickr_es.min.js') }}?v={{config('app.version')}}" defer></script>
    <script src="{{ asset('js/init-alpine.js') }}?v={{config('app.version')}}" defer></script>
    <script src="{{ asset('js/nice-select.min.js') }}?v={{config('app.version')}}" defer></script>
    <script src="{{ asset('js/utils.js') }}?v={{config('app.version')}}" defer></script>
    <script src="{{ asset('js/shepherd.js') }}?v={{config('app.version')}}" defer></script>
    @stack('styles')
</head>

<body x-ref="body" @resize.window="setMobile" @keydown.escape="closeSideMenu">
    <div class="flex h-screen bg-gray-50 dark:bg-gray-900 transition-colors" :class="{ 'overflow-hidden': isSideMenuOpen }">
        <!-- Desktop sidebar -->
        <x-loading/>

        @include('layouts.sidebar')


        <div class="flex flex-col flex-1 w-full">
            @include('layouts.navbar')
            <main id="root" class="h-full overflow-y-auto shadow-inner pt-16 sm:pt-0">
                <div class="container px-6 mx-auto grid pt-2">
                    {{ $slot }}
                </div>
            </main>
        </div>
    </div>
    <x-modal id="modal-modules" maxWidth="6xl"/>
    @include('layouts.footer')
    <x-toast />
    @stack('scripts')
</body>

</html>
