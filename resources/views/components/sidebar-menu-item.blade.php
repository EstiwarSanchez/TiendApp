@props(['item'])
@if ($item->route!==false)
<li class="relative px-6 py-3">
    @if (activeRoute($item->route))
    <span class="absolute inset-y-0 left-0 w-1 bg-psi-green-600 rounded-tr-lg rounded-br-lg" aria-hidden="true"></span>
    @endif
    <a class="{{activeRoute($item->route) ? 'text-gray-800 dark:text-gray-100 cursor-default pointer-events-none' : ''}} mb-2 inline-flex items-center justify-between w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200 "
        href="{{ activeRoute($item->route) ? '' : route($item->route)}}">
        <span class="inline-flex items-center">
        @if (isset($item->icon) && $item->icon!='' && viewExists('components.icon-'.$item->icon))
        <x-dynamic-component :component="'icon-'.$item->icon" class="w-5 h-5 {{activeRoute($item->route) ? 'text-psi-green-600' : ''}}" />
        @endif
        <span class="ml-4">{{$item->title}}</span>
        </span>
        @isset($item->badge)
        @if ($item->badge[1]>0)
        <span class="w-5 h-5 flex bg-{{ $item->badge[0] }} text-white rounded-xl shadow-sm transform scale-75"><span class="m-auto text-xs font-semibold">{{$item->badge[1]}}</span></span>
        @endif
        @endisset
    </a>
</li>
@else
<li class="relative px-6 py-2" x-data="{isOpen: {{ activeRoute($item) ? 'true' : 'false' }} }">
    @if (activeRoute($item))
    <span class="absolute inset-y-0 left-0 w-1 bg-psi-green-600 rounded-tr-lg rounded-br-lg" aria-hidden="true"></span>
    @endif
    <button
        class="inline-flex focus:outline-none items-center mb-2 justify-between w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200"
        @click="isOpen = !isOpen" aria-haspopup="true">
        <span class="inline-flex items-center" x-bind:class="{'text-gray-700 dark:text-gray-50' : isOpen}">
            @if (isset($item->icon) && $item->icon!='' && viewExists('components.icon-'.$item->icon))
            <x-dynamic-component :component="'icon-'.$item->icon" class="w-5 h-5 {{activeRoute($item) ? 'text-psi-green-600' : ''}}" />
            @endif
            <span class="ml-4">{{$item->title}}</span>
        </span>
        <x-icon-caret-down class="w-4 h-4 transition-transform" x-bind:class="{'fa-rotate-180 text-gray-700 dark:text-gray-50' : isOpen}" />
    </button>
    <template x-if="isOpen">
            <ul x-transition:enter="transition-all ease-in-out duration-300" x-transition:enter-start="opacity-25 max-h-0"
                x-transition:enter-end="opacity-100 max-h-xl" x-transition:leave="transition-all ease-in-out duration-300"
                x-transition:leave-start="opacity-100 max-h-xl" x-transition:leave-end="opacity-0 max-h-0"
                class="overflow-hidden text-xs font-medium text-gray-500 rounded-md shadow-inner dark:text-gray-400"
                aria-label="submenu">
                @if (isset($item->sublinks) && count($item->sublinks))
                @foreach($item->sublinks as $subitem)
                @isset($subitem->can)
                @if (is_array($subitem->can))
                @canany($subitem->can)
                <x-sidebar-submenu-item :item="$subitem"/>
                @endcanany
                @else
                @can($subitem->can)
                <x-sidebar-submenu-item :item="$subitem"/>
                @endcan
                @endif
                @else
                <x-sidebar-submenu-item :item="$subitem"/>
                @endisset
                @endforeach
                @endif
            </ul>
        </div>
    </template>
</li>
@endif
