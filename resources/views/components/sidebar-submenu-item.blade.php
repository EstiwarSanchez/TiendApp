@props(['item'])
@if ($item->route!==false)
<li class="px-2 pt-3 transition-colors duration-150 {{activeRoute($item->route) ? 'text-gray-800 dark:text-gray-200 font-semibold' : 'hover:text-gray-800 dark:hover:text-gray-200'}} ">
    <a class="w-full{{ activeRoute($item->route) ? ' pointer-events-none' : '' }}" href="{{ route($item->route) }}">
        <span class="inline-flex items-center">
            <x-icon-circle class="w-2 h-2 {{activeRoute($item->route) ? 'text-psi-green-600' : ''}}" />
            <span class="ml-4">{{$item->title}}</span>
        </span>
    </a>
</li>
@else
<li class="px-2 pt-3 transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200" x-data="{isOpen: {{ activeRoute($item) ? 'true' : 'false' }}  }">
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
            <li class="px-2 pt-3 transition-colors duration-150 {{activeRoute($subitem->route) ? 'text-gray-800 dark:text-gray-200 font-semibold' : 'hover:text-gray-800 dark:hover:text-gray-200'}}">
                <a class="w-full{{ activeRoute($subitem->route) ? ' pointer-events-none' : '' }}" href="{{ route($subitem->route) }}">
                    <span class="inline-flex items-center">
                        <x-icon-circle class="w-2 h-2 {{activeRoute($subitem->route) ? 'text-psi-green-600' : ''}}" />
                        <span class="ml-4">{{$subitem->title}}</span>
                    </span>
                </a>
            </li>
            @endcanany
            @else
            @can($subitem->can)
            <li class="px-2 pt-3 transition-colors duration-150 {{activeRoute($subitem->route) ? 'text-gray-800 dark:text-gray-200 font-semibold' : 'hover:text-gray-800 dark:hover:text-gray-200'}}">
                <a class="w-full{{ activeRoute($subitem->route) ? ' pointer-events-none' : '' }}" href="{{ route($subitem->route) }}">
                    <span class="inline-flex items-center">
                        <x-icon-circle class="w-2 h-2 {{activeRoute($subitem->route) ? 'text-psi-green-600' : ''}}" />
                        <span class="ml-4">{{$subitem->title}}</span>
                    </span>
                </a>
            </li>
            @endcan
            @endif

            @else
            <li class="px-3 pt-3 transition-colors duration-150 {{activeRoute($subitem->route) ? 'text-gray-800 dark:text-gray-200 font-semibold' : 'hover:text-gray-800 dark:hover:text-gray-200'}}">
                <a class="w-full{{ activeRoute($subitem->route) ? ' pointer-events-none' : '' }}" href="{{ route($subitem->route) }}">
                    <span class="inline-flex items-center">
                        <x-icon-circle class="w-2 h-2 {{activeRoute($subitem->route) ? 'text-psi-green-600' : ''}}" />
                        <span class="ml-4">{{$subitem->title}}</span>
                    </span>
                </a>
            </li>
            @endisset
            @endforeach
            @endif
        </ul>
    </template>
</li>
@endif
