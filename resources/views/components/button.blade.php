@props(['color' => null, 'size' => 'sm', 'link'=>'', 'rounded' => 'md', 'title' => '', 'loading' => true, 'textClass' => ''])

@php
$ref = 'btn-'.randomString(15);

switch ($color) {
case 'blue':
$theme = 'focus:border-psi-blue-300 focus:ring focus:ring-psi-blue-200 bg-psi-blue-600 text-white hover:bg-psi-blue-500
active:bg-psi-blue-700 focus:ring-opacity-50';
break;
case 'green':
$theme = 'focus:border-psi-green-300 focus:ring focus:ring-psi-green-200 bg-psi-green-600 text-white
hover:bg-psi-green-500 active:bg-psi-green-700 focus:ring-opacity-50';
break;
case 'orange':
$theme = 'focus:border-psi-orange-300 focus:ring focus:ring-psi-orange-200 bg-psi-orange-600 text-white
hover:bg-psi-orange-500 active:bg-psi-orange-700 focus:ring-opacity-50';
break;
case 'red':
$theme = 'focus:border-red-300 focus:ring focus:ring-red-200 bg-red-500 text-white hover:bg-red-400 active:bg-red-600
focus:ring-opacity-50';
break;
case 'purple':
$theme = 'focus:border-purple-300 focus:ring focus:ring-purple-200 bg-purple-500 text-white
hover:bg-purple-400 active:bg-purple-600 focus:ring-opacity-50';
break;
case 'teal':
$theme = 'focus:border-teal-300 focus:ring focus:ring-teal-200 bg-teal-500 text-white
hover:bg-teal-400 active:bg-teal-600 focus:ring-opacity-50';
break;
case 'pink':
$theme = 'focus:border-pink-300 focus:ring focus:ring-pink-200 bg-pink-500 text-white
hover:bg-pink-400 active:bg-pink-600 focus:ring-opacity-50';
break;

default:
$theme = 'focus:border-gray-300 focus:ring focus:ring-gray-200 bg-gray-600 text-white hover:bg-gray-500
active:bg-gray-700 focus:ring-opacity-50';
break;
}
switch ($size) {
case 'md':
$btn = $rounded == 'full' ? 'w-10 h-10 flex justify-center content-center items-center' : 'px-5 py-3';
break;
case 'sm':
$btn = $rounded == 'full' ? 'w-8 h-8 flex justify-center content-center items-center' : 'px-4 py-2 text-sm';
break;
case 'xs':
$btn = $rounded == 'full' ? 'w-6 h-6 flex justify-center content-center items-center' : 'px-2 py-1 text-xs';
break;
case 'icon':
$btn = 'w-6 h-6 flex justify-center content-center items-center text-xs';
break;

default:
$btn = $rounded == 'full' ? 'w-8 h-8 flex justify-center content-center items-center' : 'px-4 py-2 text-sm';
break;
}

$btn .= $loading ? ' btn-loading':'';
@endphp
@if ($link!='')
<a
    {!!trim($title)!='' ? "data-tippy-content='$title'" : '' !!}
    href="{!!$link!!}" x-ref="{{$ref}}" wire:loading.attr="disabled" wire:loading.class="pointer-events-none disabled"
    {{ $attributes->merge(['type' => 'submit', 'class' => "$theme $btn shadow-sm inline-flex items-center focus:outline-none border border-transparent rounded-$rounded font-semibold tracking-widest disabled:opacity-25 transition"]) }}>
    <span class="hidden" wire:loading.inline>
        <x-icon-spinner class="h-3"/>
    </span>
    <span class="hidden button-loading transition-all">
        <x-icon-spinner class="h-3"/>
    </span>
    <span wire:loading.remove class="button-text transition-all {{$textClass}}">{{ $slot }}</span>
</a>
@else
<button
    {!!trim($title)!='' ? "data-tippy-content='$title'" : '' !!}
    x-ref="{{$ref}}" wire:loading.attr="disabled" wire:loading.class="pointer-events-none disabled"
    {{ $attributes->merge(['type' => 'submit', 'class' => "$theme $btn shadow-sm inline-flex items-center focus:outline-none border border-transparent rounded-$rounded font-semibold tracking-widest disabled:opacity-25 transition"]) }}>
    <span class="hidden" wire:loading.inline>
        <x-icon-spinner class="h-3"/>
    </span>
    <span class="hidden button-loading transition-all">
        <x-icon-spinner class="h-3"/>
    </span>
    <span wire:loading.remove class="button-text transition-all {{$textClass}}">{{ $slot }}</span>
</button>
@endif
