@props(['value', 'title' => '', 'size' => 'sm'])

<label {{ $attributes->merge(['class' => 'block font-medium text-'.$size.' text-gray-700 dark:text-gray-300']) }} >
    {{ $value ?? $slot }}
</label>
