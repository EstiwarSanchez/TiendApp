@if (!$ajax)
<x-app-layout>
    <x-slot name="title">{{___('Create :resource', ['resource' => __('Brand')], true)}}</x-slot>
    <div class="flex flex-wrap sm:flex-nowrap justify-between mb-2">
        <h1 class="my-6 lg:text-3xl sm:text-xl text-lg text-center sm:text-left font-semibold text-gray-700 dark:text-gray-200">
            {{___('Create :resource', ['resource' => __('Brand')], true)}}
        </h1>
        @can('brands.index')
        <x-button link="{{ route('brands.index') }}" class="my-auto mx-auto sm:mx-0" color="blue">{{__('Brand List')}}</x-button>
        @endcan
    </div>
    <div class="grid gap-6 mb-8 grid-cols-1">
        <div class="min-w-0 p-4 bg-white rounded-lg shadow dark:bg-gray-800">
            <h4 class="mb-4 font-semibold text-gray-800 dark:text-gray-300">
                {{___('Form :resource', ['resource' => __('Brand')], true)}}
            </h4>
            @include('brands.brand-form')
        </div>
    </div>
    @push('scripts')
        <script type="text/javascript" src="{{asset('js/brands/create.js')}}?v={{config('app.version')}}" defer></script>
    @endpush
</x-app-layout>
@else
    @include('brands.brand-form')
@endif
