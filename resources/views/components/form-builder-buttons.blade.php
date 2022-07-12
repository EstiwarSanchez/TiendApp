<div class="absolute r-0 t-0 mr-1 actions-buttons hidden">
    <x-button class="shadow-md" color="blue" size="icon" rounded="full" x-show="!edit"
        x-on:click="edit=true">
        <x-icon-edit class="h-3"/>
    </x-button>
    <x-button class="shadow-md" color="green" size="icon" rounded="full" x-show="edit"
        x-on:click="edit=false; setTimeout(()=>{$dispatch('format-change');},100);">
        <x-icon-check class="h-3"/>
    </x-button>
    <x-button class="shadow-md" color="red" size="icon" rounded="full" x-show="!edit"
        x-on:click="$dispatch('format-change');setTimeout(()=>{$el.remove();},100);">
        <x-icon-times class="h-3"/>
    </x-button>
</div>
