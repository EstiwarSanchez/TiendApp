@props(['multiple' => false, 'id' => randomString(30), 'disabled' => false, 'color' => null, 'only' => null, 'filesVar' => 'files'])

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

$theme .= $only != null ? ' only-' . $only : '';
@endphp
<label {!! $attributes->merge([
    'class' =>
        "$theme " .
        ($disabled ? 'disabled' : 'dark:bg-opacity-5 dark:bg-white') .
        "focus:ring focus:ring-opacity-50 border truncate cursor-pointer flex rounded-md py-2 text-sm shadow-sm text-gray-800 dark:text-gray-200 input-files",])->filter(fn ($value, $key) => $key != 'name') !!} for="{{ $id }}">
    <input {{ $disabled ? 'disabled' : '' }} {{$attributes->filter(fn ($value, $key) => $key != 'class')}} type="file"
        {{ $multiple ? 'multiple="true"' : '' }} class="sr-only w-full" id="{{ $id }}"
        x-on:change="{!! $filesVar !!} = Object.values($event.target.files)">

    <span class="ml-2 flex ">
        <svg fill="currentColor" class="text-psi-blue-600" height="18" viewBox="0 0 24 24" width="18"
            xmlns="http://www.w3.org/2000/svg">
            <path d="M0 0h24v24H0z" fill="none" />
            <path d="M9 16h6v-6h4l-7-7-7 7h4zm-4 2h14v2H5z" />
        </svg>
        <span
            x-text="{!! $filesVar !!} ? {!! $filesVar !!}.map(file => file.name).join(', ') : 'Seleccione {{ $multiple ? 'los archivos' : 'el archivo' }}...'"></span>
    </span>
</label>
