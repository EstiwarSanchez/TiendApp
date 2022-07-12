<x-app-layout>
    <x-slot name="title">{{__('Size')}}</x-slot>
    <div class="flex flex-wrap sm:flex-nowrap justify-between mb-2">
        <h1 class="my-6 lg:text-3xl sm:text-xl text-lg text-center sm:text-left font-semibold text-gray-700 dark:text-gray-200">
            {{__('Sizes')}}
        </h1>
        <x-button class="my-auto mx-auto sm:mx-0" color="blue" x-on:click="createSize()">{{__('Create')}}</x-button>
    </div>
    <div id="table-list" class="grid gap-6 mb-8 grid-cols-1">
        <div class="min-w-0 p-4 bg-white rounded-lg shadow dark:bg-gray-800">
            <h4 class="mb-4 font-semibold text-gray-800 dark:text-gray-300">
                {{__('Size List')}}
            </h4>
            @livewire('size-list')
        </div>
    </div>
    <x-modal id="modal-size" static="true"/>
    @push('scripts')
    <script type="text/javascript" src="{{asset('js/sizes/index.js')}}?v={{config('app.version')}}" defer></script>
    <script type="text/javascript" src="{{asset('js/sizes/create.js')}}?v={{config('app.version')}}" defer></script>
    <script type="text/javascript" src="{{asset('js/sizes/edit.js')}}?v={{config('app.version')}}" defer></script>
    @endpush
</x-app-layout>
