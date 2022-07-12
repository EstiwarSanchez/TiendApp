@props(['maxw' => 'sm:max-w-md'])
<div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-2 bg-app-gradient px-2">
    <div class="">
        {{ $logo }}
    </div>

    <div class="w-full {{$maxw}} mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
        {{ $slot }}
    </div>
    <div class="text-white mt-3 text-sm font-bold">
        &copy; Yonier {{date('Y')}}
    </div>
</div>
