@props(['disabled' => false, 'error' => false, 'id' => '', 'color' => null, 'default'=> null, 'min'=>false, 'time' => false ])
@php
switch ($color) {
    case 'green':
        $theme = 'focus:border-green-300 focus:ring-green-200 border-gray-300 dark:border-gray-600';
        break;
    case 'yellow':
        $theme = 'focus:border-amber-300 focus:ring-amber-200 border-gray-300 dark:border-gray-600';
        break;
    case 'red':
        $theme = 'focus:border-red-300 focus:ring-red-200 border-gray-300 dark:border-gray-600';
        break;
    case 'error':
        $theme = 'focus:border-red-300 focus:ring-red-200 border-red-300 dark:border-gray-600';
        break;

    default:
        $theme = 'focus:border-blue-300 focus:ring-blue-200 border-gray-300 dark:border-gray-600';
        break;

}
@endphp
<div class="relative">
    <input {{ $disabled ? 'disabled' : '' }} id="{{$id}}" readonly x-data x-ref="input"
    x-init="flatpickr($refs.input, { {{$min ? "minDate: 'today',":''}} enableTime:{{$time ? 'true': 'false'}}, 'locale': '{{app()->getLocale()=='base' || app()->getLocale()=='es' ? 'es' : 'en'}}', {{$default != null ? 'defaultDate:'. json_encode($default) : ''}}})" type="text" {!! $attributes->merge(['class' => "$theme ".($disabled ? 'disabled' : 'dark:bg-opacity-5 dark:bg-white') ." focus:ring focus:ring-opacity-50 rounded-md py-2 text-sm shadow-sm text-gray-800 dark:text-gray-200"]) !!}>
    <label class="label-calendar cursor-pointer {{($error!=false ? 'text-red-500' : 'text-psi-blue-500')}}" for="{{$id}}"><x-icon-calendar class="h-4"/></label>
</div>
