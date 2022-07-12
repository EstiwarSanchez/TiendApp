<form class="p-2" id="{{isset($product) ? 'updateProduct' : 'storeProduct'}}" x-data="form()" x-init="init()" @focusout="changeInput" @input="changeInput" @change="changeInput"
    @submit.prevent="{{ isset($product) ? 'updateProduct($dispatch, `'.$product->id.'`, true)' : 'storeProduct($dispatch, '.($ajax ? 'true' : 'false').')' }}; return false;">
    @csrf
    @isset($product)
        @method('PUT')
    @endisset
    <div class="{{ $ajax ? 'flex flex-wrap' : 'grid lg:grid-cols-2 gap-3'}}">
        @if ($ajax)
        <div class="w-full">
            <h4 class="mb-4 font-semibold text-xl text-gray-800 dark:text-gray-300">
                {{isset($product) ? ___('Edit :resource', ['resource' =>__('Product')]) :__('Create :resource', ['resource' => __('Product')])}}
            </h4>
        </div>
        @endif
        <div class="w-full {{ $ajax ? 'mb-3' : ''}}">
            <x-label for="name" :value="__('Name')" />
            <x-input type="text" maxlength="200" class="w-full" id="name" name="name"
                x-bind:class="{'invalid':name.errorMessage}" data-rules="['required','maximum:200', 'minimum:3']" data-server-errors='[]'
                placeholder="{{__('Name')}}" autocomplete="name" value="{{isset($product) ? $product->name : ''}}"/>
            <p class="text-xs text-red-600 font-semibold mt-1" x-show.transition.in="name.errorMessage" x-text="name.errorMessage"></p>
        </div>
        <div class="w-full mb-3" x-bind:class="{'invalid':size_id.errorMessage}">
            <x-label for="size_id" :value="__('Size')" />
            <x-select name="size_id" id="size_id" searchable="true" class="w-full"
                x-bind:class="{'invalid':size_id.errorMessage}" data-rules="['required']" data-server-errors='[]'>
                @forelse ($sizes as $key => $size)
                    <option value="{{ $size->id }}" {{ isset($product) ? ($product->size_id == $size->id ? 'selected' : '') : '' }}>{{ $size->name }}</option>
                @empty
                @endforelse
            </x-select>
            <p class="text-xs text-red-600 font-semibold mt-1" x-show.transition.in="size_id.errorMessage"
                x-text="size_id.errorMessage"></p>
        </div>
        <div class="w-full mb-3" x-bind:class="{'invalid':brand_id.errorMessage}">
            <x-label for="brand_id" :value="__('Brand')" />
            <x-select name="brand_id" id="brand_id" searchable="true" class="w-full"
                x-bind:class="{'invalid':brand_id.errorMessage}" data-rules="['required']" data-server-errors='[]'>
                @forelse ($brands as $key => $brand)
                    <option value="{{ $brand->id }}" {{ isset($product) ? ($product->brand_id == $brand->id ? 'selected' : '') : '' }} >{{ $brand->name }}</option>
                @empty
                @endforelse
            </x-select>
            <p class="text-xs text-red-600 font-semibold mt-1" x-show.transition.in="brand_id.errorMessage"
                x-text="brand_id.errorMessage"></p>
        </div>
        <div class="w-full {{ $ajax ? 'mb-3' : ''}}">
            <x-label for="observations" :value="__('Observations')" />
            <x-input type="text" maxlength="200" class="w-full" id="observations" name="observations"
                x-bind:class="{'invalid':observations.errorMessage}" data-rules="['required','maximum:200', 'minimum:3']" data-server-errors='[]'
                placeholder="{{__('Observations')}}" autocomplete="observations" value="{{isset($product) ? $product->observations : ''}}"/>
            <p class="text-xs text-red-600 font-semibold mt-1" x-show.transition.in="observations.errorMessage" x-text="observations.errorMessage"></p>
        </div>
        <div class="w-full mb-3" x-bind:class="{'invalid':inventory_quantity.errorMessage}">
            <x-label for="inventory_quantity" :value="__('Number of Inventory')" />
            <x-input type="tel" class="w-full" id="inventory_quantity" name="inventory_quantity" only="digits"
                x-bind:class="{'invalid':inventory_quantity.errorMessage}" data-rules="['required','minimum:1','maximum:5','min:0' ]" data-server-errors='[]'
                placeholder="{{ __('Number of Inventory') }}" value="{{isset($product) ? $product->inventory_quantity : ''}}"/>
            <p class="text-xs text-red-600 font-semibold mt-1" x-show.transition.in="inventory_quantity.errorMessage"
                x-text="inventory_quantity.errorMessage"></p>
        </div>
        <div class="w-full mb-3" x-bind:class="{'invalid':boarding_date.errorMessage}">
            <x-label for="boarding_date" :value="__('Boarding of date')" />
            <x-datepicker class="w-full" id="boarding_date" name="boarding_date"
                x-bind:class="{'invalid':boarding_date.errorMessage}" data-rules="['required']"
                data-server-errors='[]' placeholder="{{ __('Boarding of date') }}" value="{{isset($product) ? $product->boarding_date : ''}}">
            </x-datepicker>
            <p class="text-xs text-red-600 font-semibold mt-1" x-show.transition.in="boarding_date.errorMessage"
                x-text="boarding_date.errorMessage"></p>
        </div>
        <div class="w-full {{ $ajax ? 'mb-3' : 'col-span-full'}} text-right">
            <x-button type="button" color="green" @click="submitForm">
                {{__('Save')}}
            </x-button>
            @if ($ajax)
            <x-button type="button" class="ml-2" @click="hideModal('modal-product')">
                {{__('Close')}}
            </x-button>
            @endif
        </div>
    </div>
</form>
