<x-app-layout>
    <x-slot name="title">{{__('Products')}}</x-slot>
    <div class="flex flex-wrap sm:flex-nowrap justify-between mb-2">
        <h1 class="my-6 lg:text-3xl sm:text-xl text-lg text-center sm:text-left font-semibold text-gray-700 dark:text-gray-200">
            {{__('Products')}}
        </h1>
        <x-button class="my-auto mx-auto sm:mx-0" color="blue" x-on:click="createProduct()">{{__('Create')}}</x-button>
    </div>
    <div id="table-list" class="grid gap-6 mb-8 grid-cols-1">
        <div class="min-w-0 p-4 bg-white rounded-lg shadow dark:bg-gray-800">
            <h4 class="mb-4 font-semibold text-gray-800 dark:text-gray-300">
                {{__('Product List')}}
            </h4>
            @livewire('product-list')
        </div>
    </div>
    <x-modal id="modal-product" static="true"/>
    @push('scripts')
    <script type="text/javascript" src="{{asset('js/products/index.js')}}?v={{config('app.version')}}" defer></script>
    <script type="text/javascript" src="{{asset('js/products/create.js')}}?v={{config('app.version')}}" defer></script>
    <script type="text/javascript" src="{{asset('js/products/edit.js')}}?v={{config('app.version')}}" defer></script>
    @endpush
</x-app-layout>
