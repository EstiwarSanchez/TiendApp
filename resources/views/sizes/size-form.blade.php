<form class="p-2" id="{{isset($size) ? 'updateSize' : 'storeSize'}}" x-data="form()" x-init="init()" @focusout="changeInput" @input="changeInput" @change="changeInput"
    @submit.prevent="{{ isset($size) ? 'updateSize($dispatch, `'.$size->id.'`, true)' : 'storeSize($dispatch, '.($ajax ? 'true' : 'false').')' }}; return false;">
    @csrf
    @isset($size)
        @method('PUT')
    @endisset
    <div class="{{ $ajax ? 'flex flex-wrap' : 'grid lg:grid-cols-2 gap-3'}}">
        @if ($ajax)
        <div class="w-full">
            <h4 class="mb-4 font-semibold text-xl text-gray-800 dark:text-gray-300">
                {{isset($size) ? ___('Edit :resource', ['resource' =>__('Size')]) :__('Create :resource', ['resource' => __('Size')])}}
            </h4>
        </div>
        @endif
        <div class="w-full {{ $ajax ? 'mb-3' : ''}}">
            <x-label for="name" :value="__('Name')" />
            <x-input type="text" maxlength="5" class="w-full" id="name" name="name"
                x-bind:class="{'invalid':name.errorMessage}" data-rules="['required','maximum:5', 'minimum:1']" data-server-errors='[]'
                placeholder="{{__('Name')}}" autocomplete="name" value="{{isset($size) ? $size->name : ''}}"/>
            <p class="text-xs text-red-600 font-semibold mt-1" x-show.transition.in="name.errorMessage" x-text="name.errorMessage"></p>
        </div>
        <div class="w-full {{ $ajax ? 'mb-3' : ''}}">
            <x-label for="description" :value="__('Description')" />
            <x-input type="text" maxlength="30" class="w-full" id="description" name="description"
                x-bind:class="{'invalid':description.errorMessage}" data-rules="['required','maximum:30', 'minimum:3']" data-server-errors='[]'
                placeholder="{{__('Description')}}" autocomplete="description" value="{{isset($size) ? $size->description : ''}}"/>
            <p class="text-xs text-red-600 font-semibold mt-1" x-show.transition.in="description.errorMessage" x-text="description.errorMessage"></p>
        </div>
        <div class="w-full {{ $ajax ? 'mb-3' : 'col-span-full'}} text-right">
            <x-button type="button" color="green" @click="submitForm">
                {{__('Save')}}
            </x-button>
            @if ($ajax)
            <x-button type="button" class="ml-2" @click="hideModal('modal-size')">
                {{__('Close')}}
            </x-button>
            @endif
        </div>
    </div>
</form>
