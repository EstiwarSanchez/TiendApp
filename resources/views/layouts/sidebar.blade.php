@php
    $links = collect(json_decode(json_encode([
        ['route' => 'sizes.index', 'icon' => 'task', 'title' => __('Tallas')],
        ['route' => 'brands.index', 'icon' => 'boxes', 'title' => __('Marcas')],
        ['route' => 'products.index', 'icon' => 'clipboard-list', 'title' => __('Productos')]
    ])));
@endphp
    <div x-show="mobile" style="display: none;">
        <div x-show="isSideMenuOpen" x-transition:enter="transition ease-in-out duration-150"
            x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in-out duration-150" x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed inset-0 z-30 flex items-end bg-black bg-opacity-50 sm:items-center sm:justify-center"
            style="display: none;">
        </div>
    </div>
    <aside
        :class="{
            'fixed inset-y-0 z-40 flex-shrink-0 w-64 mt-17 h-full max-h-full min-h-full bg-white dark:bg-gray-800': mobile,
            'z-40 hidden w-64 h-full min-h-full max-h-full bg-white dark:bg-gray-800 md:block flex-shrink-0': !mobile
        }"
        x-show="mobile ? isSideMenuOpen : true" x-transition:enter="transition ease-in-out duration-150"
        x-transition:enter-start="opacity-0 transform -translate-x-20" x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in-out duration-150" x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0 transform -translate-x-20" @click.away="closeSideMenu"
        class="fixed inset-y-0 z-40 flex-shrink-0 w-64 mt-17 h-full max-h-full min-h-full bg-white dark:bg-gray-800 transition-colors">
        <div class="pt-4 h-full max-h-full text-gray-500 dark:text-gray-400 relative"
            :class="{ 'sidebar-mobile': mobile }">
            <a class="ml-4 text-lg font-bold text-psi-gray dark:text-gray-200 inline-flex mx-auto" href="/">
                <x-logo-core class="w-16 pr-2 dark:current" />
            </a>
            <div class="sidebar-menu" :class="{ 'sidebar-menu-mobile': mobile }">
                <ul>
                    @foreach ($links as $item)
                        @isset($item->can)
                            @if (is_array($item->can))
                                @canany($item->can)
                                    <x-sidebar-menu-item :item="$item" />
                                @endcanany
                            @else
                                @can($item->can)
                                    <x-sidebar-menu-item :item="$item" />
                                @endcan
                            @endif
                        @else
                            <x-sidebar-menu-item :item="$item" />
                        @endisset
                    @endforeach
                </ul>
            </div>
        </div>
    </aside>
