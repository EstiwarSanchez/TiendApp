@props(['color'=> '#ffffff'])
<div
    x-data="{ color: '{{$color}}' }"
    x-init="
    $refs.button.style.backgroundColor = color
        picker = new Picker({
            color: color,
            parent: $refs.button,
            popup: 'bottom'
        });
        picker.onDone = rawColor => {
            color = rawColor.hex;
        }
        picker.onChange = rawColor => {
            $refs.button.style.backgroundColor = rawColor.hex;
            color = rawColor.hex;
        }
    "
    wire:ignore
>
    <button x-ref="button" class="focus:border-blue-300 focus:ring-blue-200 border border-gray-300 dark:border-gray-600 focus:ring focus:ring-opacity-50 rounded-md py-2 text-sm shadow-sm text-gray-800 dark:text-gray-200 px-4 w-full"><span x-text="color" class="text-contrast"></span></button>
    <input type="hidden" x-model="color" readonly {{ $attributes }}>
</div>
