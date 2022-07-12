<x-app-layout>
    <x-slot name="title">{{__('Brands')}}</x-slot>
    <div class="flex flex-wrap sm:flex-nowrap justify-between mb-2">
        <h1 class="my-6 lg:text-3xl sm:text-xl text-lg text-center sm:text-left font-semibold text-gray-700 dark:text-gray-200">
            {{__('Brands')}}
        </h1>
        <x-button class="my-auto mx-auto sm:mx-0" color="blue" x-on:click="createBrand()">{{__('Create')}}</x-button>
    </div>
    <div id="table-list" class="grid gap-6 mb-8 grid-cols-1">
        <div class="min-w-0 p-4 bg-white rounded-lg shadow dark:bg-gray-800">
            <h4 class="mb-4 font-semibold text-gray-800 dark:text-gray-300">
                {{__('Brand List')}}
            </h4>
            @livewire('brand-list')
        </div>
    </div>
    <x-modal id="modal-brand" static="true"/>
    @push('scripts')
    <script type="text/javascript" src="{{asset('js/brands/index.js')}}?v={{config('app.version')}}" defer></script>
    <script type="text/javascript" src="{{asset('js/brands/create.js')}}?v={{config('app.version')}}" defer></script>
    <script type="text/javascript" src="{{asset('js/brands/edit.js')}}?v={{config('app.version')}}" defer></script>
    @endpush
</x-app-layout>
