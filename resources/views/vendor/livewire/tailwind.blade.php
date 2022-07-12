<div class="sm:hidden">
    @if ($paginator->hasPages())
        <nav role="navigation" aria-label="Pagination Navigation" class="flex justify-between px-2 py-3 text-xs font-semibold tracking-wide text-gray-700 border-t dark:border-gray-700 bg-gray-50 dark:text-gray-300 dark:bg-gray-700">
            <span>
                {{-- Previous Page Link --}}
                @if ($paginator->onFirstPage())
                <span aria-disabled="true" aria-label="{{ __('pagination.previous') }}">
                    <x-button :loading="false" class="mr-0.5 btn-page" disabled size="xs" aria-hidden="true">
                        {!! __('pagination.previous') !!}
                    </x-button>
                </span>
                @else
                <x-button :loading="false" wire:click="previousPage" dusk="previousPage.after" rel="prev" class="mr-0.5 btn-page"
                    aria-label="{{ __('pagination.previous') }}" size="xs">
                    {!! __('pagination.previous') !!}
                </x-button>
                @endif
            </span>

            <span>
                {{-- Next Page Link --}}
                @if ($paginator->hasMorePages())
                <x-button :loading="false" class="ml-0.5 btn-page" wire:click="nextPage" size="xs" dusk="nextPage.after" rel="next"
                    aria-label="{{ __('pagination.next') }}">
                    {!! __('pagination.next') !!}
                </x-button>
                @else
                <x-button :loading="false" class="ml-0.5 btn-page" disabled rel="next" size="xs" aria-disabled="true"
                    aria-label="{{ __('pagination.next') }}">
                    {!! __('pagination.next') !!}
                </x-button>
                @endif
            </span>
        </nav>
    @endif
</div>
<div class="hidden sm:block">
    @if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination Navigation"
        class="flex flex-wrap sm:flex-nowrap px-4 py-3 text-xs font-semibold tracking-wide text-gray-700 border-t dark:border-gray-700 bg-gray-50 dark:text-gray-300 dark:bg-gray-700">
        <div class="flex items-center w-40 mx-auto sm:ml-0 sm:mr-auto">
            <span class="ml-auto sm:ml-0 mr-auto">Mostrando {{$paginator->firstItem()}} a {{ $paginator->lastItem() }}
                de {{ $paginator->total() }}</span>
        </div>

        <span class="flex mt-4 sm:mr-0 sm:ml-auto mx-auto overflow-x-auto sm:mt-2 justify-end">
            <div aria-label="Table navigation" class="flex" style="min-width: 302px;">
                <ul class="inline-flex items-center ml-auto mr-auto sm:mr-0">
                    <li>
                        <span>
                            {{-- Previous Page Link --}}
                            @if ($paginator->onFirstPage())
                            <span aria-disabled="true" aria-label="{{ __('pagination.previous') }}">
                                <x-button :loading="false" class="mr-0.5 btn-page" disabled size="icon" aria-hidden="true">
                                    <svg aria-hidden="true" class="w-4 h-4 m-auto fill-current" viewBox="0 0 20 20">
                                        <path
                                            d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                                            clip-rule="evenodd" fill-rule="evenodd"></path>
                                    </svg>
                                </x-button>
                            </span>
                            @else
                            <x-button :loading="false" wire:click="previousPage" dusk="previousPage.after" rel="prev" class="mr-0.5 btn-page"
                                aria-label="{{ __('pagination.previous') }}" size="icon">
                                <svg aria-hidden="true" class="w-4 h-4 m-auto fill-current" viewBox="0 0 20 20">
                                    <path
                                        d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                                        clip-rule="evenodd" fill-rule="evenodd"></path>
                                </svg>
                            </x-button>
                            @endif
                        </span>
                    </li>
                    {{-- Pagination Elements --}}
                    @foreach ($elements as $element)
                    {{-- "Three Dots" Separator --}}
                    @if (is_string($element))
                    <li>
                        <span aria-disabled="true">
                            <x-button :loading="false" size="icon" class="mx-0.5" disabled>{{ $element }}</x-button>
                        </span>
                    </li>
                    @endif

                    {{-- Array Of Links --}}
                    @if (is_array($element))
                    @foreach ($element as $page => $url)
                    <li>
                        <span wire:key="paginator-page{{ $page }}">
                            @if ($page == $paginator->currentPage())
                            <span aria-current="page">
                                <x-button :loading="false" class="mx-0.5 btn-page" disabled size="icon">
                                    <span class="m-auto">{{ $page }}</span>
                                </x-button>
                            </span>

                            @else
                            <x-button :loading="false" class="mx-0.5 btn-page" wire:click="gotoPage({{ $page }})" size="icon" color="orange"
                                aria-label="{{ __('Go to page :page', ['page' => $page]) }}">
                                <span class="m-auto">{{ $page }}</span>
                            </x-button>
                            @endif
                        </span>
                    </li>
                    @endforeach
                    @endif
                    @endforeach

                    <li>
                        <span>
                            {{-- Next Page Link --}}
                            @if ($paginator->hasMorePages())
                            <x-button :loading="false" class="ml-0.5 btn-page" wire:click="nextPage" size="icon" dusk="nextPage.after" rel="next"
                                aria-label="{{ __('pagination.next') }}">
                                <svg class="w-4 h-4 m-auto fill-current" aria-hidden="true" viewBox="0 0 20 20">
                                    <path
                                        d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                        clip-rule="evenodd" fill-rule="evenodd"></path>
                                </svg>
                            </x-button>
                            @else
                            <x-button :loading="false" class="ml-0.5 btn-page" disabled rel="next" size="icon" aria-disabled="true"
                                aria-label="{{ __('pagination.next') }}">
                                <svg class="w-4 h-4 m-auto fill-current" aria-hidden="true" viewBox="0 0 20 20">
                                    <path
                                        d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                        clip-rule="evenodd" fill-rule="evenodd"></path>
                                </svg>
                            </x-button>
                            @endif
                        </span>
                    </li>
                </ul>
            </div>
        </span>
    </nav>
    @endif
</div>
