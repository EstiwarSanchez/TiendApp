@props(['disabled' => false, 'color' => null, 'only' => null])

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

$theme .= $only!=null ? ' only-'.$only:'';
@endphp

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => "$theme ".($disabled ? 'disabled' : 'dark:bg-opacity-5 dark:bg-white') ." focus:ring focus:ring-opacity-50 rounded-md py-2 text-sm shadow-sm text-gray-800 dark:text-gray-200"]) !!}>
