<form class="p-2" id="{{isset($brand) ? 'updateBrand' : 'storeBrand'}}" x-data="form()" x-init="init()" @focusout="changeInput" @input="changeInput" @change="changeInput"
    @submit.prevent="{{ isset($brand) ? 'updateBrand($dispatch, `'.$brand->id.'`, true)' : 'storeBrand($dispatch, '.($ajax ? 'true' : 'false').')' }}; return false;">
    @csrf
    @isset($brand)
        @method('PUT')
    @endisset
    <div class="{{ $ajax ? 'flex flex-wrap' : 'grid lg:grid-cols-2 gap-3'}}">
        @if ($ajax)
        <div class="w-full">
            <h4 class="mb-4 font-semibold text-xl text-gray-800 dark:text-gray-300">
                {{isset($brand) ? ___('Edit :resource', ['resource' =>__('Brand')]) :__('Create :resource', ['resource' => __('Brand')])}}
            </h4>
        </div>
        @endif
        <div class="w-full {{ $ajax ? 'mb-3' : ''}}">
            <x-label for="name" :value="__('Name')" />
            <x-input type="text" maxlength="50" class="w-full" id="name" name="name"
                x-bind:class="{'invalid':name.errorMessage}" data-rules="['required','maximum:50', 'minimum:3']" data-server-errors='[]'
                placeholder="{{__('Name')}}" autocomplete="name" value="{{isset($brand) ? $brand->name : ''}}"/>
            <p class="text-xs text-red-600 font-semibold mt-1" x-show.transition.in="name.errorMessage" x-text="name.errorMessage"></p>
        </div>
        <div class="w-full {{ $ajax ? 'mb-3' : ''}}">
            <x-label for="reference" :value="__('Reference')" />
            <x-input type="text" maxlength="150" class="w-full" id="reference" name="reference"
                x-bind:class="{'invalid':reference.errorMessage}" data-rules="['required','maximum:150', 'minimum:3']" data-server-errors='[]'
                placeholder="{{__('Reference')}}" autocomplete="reference" value="{{isset($brand) ? $brand->reference : ''}}"/>
            <p class="text-xs text-red-600 font-semibold mt-1" x-show.transition.in="reference.errorMessage" x-text="reference.errorMessage"></p>
        </div>
        <div class="w-full {{ $ajax ? 'mb-3' : 'col-span-full'}} text-right">
            <x-button type="button" color="green" @click="submitForm">
                {{__('Save')}}
            </x-button>
            @if ($ajax)
            <x-button type="button" class="ml-2" @click="hideModal('modal-brand')">
                {{__('Close')}}
            </x-button>
            @endif
        </div>
    </div>
</form>
