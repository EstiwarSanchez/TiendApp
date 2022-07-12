@php
    $percent = isset($formats_inspections_percents[$format->id]) ? $formats_inspections_percents[$format->id] : 0;
@endphp
@if ($paginator->hasPages())
@if ($paginator->lastPage() === $paginator->currentPage() && $announcement_detail->percent<100) <p
    class="py-6 font-semibold text-center text-red-600 text-sm">{{ __('answer.resource.no_completed') }}</p>
    @endif
    <nav role="navigation" aria-label="Pagination Navigation"
        class="flex justify-between px-2 py-3 text-xs font-semibold tracking-wide text-gray-700 dark:text-gray-300">
        <span class="mb-2">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
            <span aria-disabled="true" aria-label="{{ __('pagination.previous') }}">
                <x-button :loading="false" class="mr-0.5 btn-page" disabled aria-hidden="true">
                    <span class="lg:block hidden">{!! __('pagination.previous') !!}</span>
                    <span class="block lg:hidden">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                                clip-rule="evenodd" />
                        </svg>
                    </span>
                </x-button>
            </span>
            @else
            <x-button :loading="false" link="{{ $paginator->previousPageUrl() }}" dusk="previousPage.after" rel="prev"
                class="mr-0.5 btn-page" aria-label="{{ __('pagination.previous') }}">
                <span class="lg:block hidden">{!! __('pagination.previous') !!}</span>
                <span class="block lg:hidden">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                            clip-rule="evenodd" />
                    </svg>
                </span>
            </x-button>
            @endif
        </span>
        <div class="text-center">
            <x-button type="button" color="green" class="sm:mx-2 mb-2" @click="showModal('modal-confirm')">
                {{ __('global.button.save') }}
            </x-button>
            <x-button type="button" color="blue" class="sm:mx-2 mb-2 hidden sm:inline-block" :disabled="$percent < 100"
                x-on:click="createProposalActionPlan('{{ $announcement_detail->id }}','{{ $format->id }}')">
                {{ __('global.button.answer.proposal_action_plan') }}
            </x-button>
        </div>
        <span class="mb-2">
            {{-- Next Page Link --}}
            @if ($paginator->currentPage() < $paginator->lastPage())
                @if ($paginator->hasMorePages())
                <x-button :loading="false" class="ml-0.5 btn-page" link="{{ $paginator->nextPageUrl() }}"
                    dusk="nextPage.after" rel="next" aria-label="{{ __('pagination.next') }}">
                    <span class="lg:block hidden">{!! __('pagination.next') !!}</span>
                    <span class="block lg:hidden">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                clip-rule="evenodd" />
                        </svg>
                    </span>
                </x-button>
                @else
                <x-button :loading="false" class="ml-0.5 btn-page" disabled rel="next" aria-disabled="true"
                    aria-label="{{ __('pagination.next') }}">
                    <span class="lg:block hidden">{!! __('pagination.next') !!}</span>
                    <span class="block lg:hidden">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                clip-rule="evenodd" />
                        </svg>
                    </span>
                </x-button>
                @endif
                @else
                @if ($announcement_detail->percent==100)
                <x-button type="button" color="green" class="sm:mx-2 mb-2" @click="showModal('modal-comment')"
                    aria-label="{!! __('global.button.finish') !!}">
                    <span class="lg:block hidden">{!! __('global.button.finish') !!}</span>
                    <span class="block lg:hidden">
                        <x-icon-check class="h-4 w-4" />
                    </span>
                </x-button>
                @else
                <x-button :loading="false" class="ml-0.5 btn-page" disabled rel="next" aria-disabled="true"
                    aria-label="{!! __('global.button.finish') !!}">
                    <span class="lg:block hidden">{!! __('global.button.finish') !!}</span>
                    <span class="block lg:hidden">
                        <x-icon-check class="h-4 w-4" />
                    </span>
                </x-button>
                @endif
                @endif
        </span>
    </nav>
    <div class="sm:hidden text-center">
        <x-button type="button" color="blue" class="sm:mx-2 mb-2" :disabled="$percent < 100"
            x-on:click="createProposalActionPlan('{{ $announcement_detail->id }}','{{ $format->id }}')">
            {{ __('global.button.answer.proposal_action_plan') }}
        </x-button>
    </div>
    @else
    @if ($paginator->lastPage() === $paginator->currentPage() && $announcement_detail->percent<100) <p
    class="py-6 font-semibold text-center text-red-600 text-sm">{{ __('answer.resource.no_completed') }}</p>
    @endif
    <nav role="navigation" aria-label="Pagination Navigation"
        class="flex justify-between px-2 py-3 text-xs font-semibold tracking-wide text-gray-700 dark:text-gray-300">
        <div class="text-center mx-auto">
            <x-button type="button" color="green" class="sm:mx-2 mb-2" @click="showModal('modal-confirm')">
                {{ __('global.button.save') }}
            </x-button>
            <x-button type="button" color="blue" class="sm:mx-2 mb-2 hidden sm:inline-block" :disabled="$percent < 100"
                x-on:click="createProposalActionPlan('{{ $announcement_detail->id }}','{{ $format->id }}')">
                {{ __('global.button.answer.proposal_action_plan') }}
            </x-button>
            @if ($announcement_detail->percent==100)
                <x-button type="button" color="green" class="sm:mx-2 mb-2" @click="showModal('modal-comment')"
                    aria-label="{!! __('global.button.finish') !!}">
                    <span class="lg:block hidden">{!! __('global.button.finish') !!}</span>
                    <span class="block lg:hidden">
                        <x-icon-check class="h-4 w-4" />
                    </span>
                </x-button>
                @else
                <x-button :loading="false" class="ml-0.5 btn-page" disabled rel="next" aria-disabled="true"
                    aria-label="{!! __('global.button.finish') !!}">
                    <span class="lg:block hidden">{!! __('global.button.finish') !!}</span>
                    <span class="block lg:hidden">
                        <x-icon-check class="h-4 w-4" />
                    </span>
                </x-button>
                @endif
        </div>
    </nav>
    <div class="sm:hidden text-center">
        <x-button type="button" color="blue" class="sm:mx-2 mb-2" :disabled="$percent < 100"
            x-on:click="createProposalActionPlan('{{ $announcement_detail->id }}','{{ $format->id }}')">
            {{ __('global.button.answer.proposal_action_plan') }}
        </x-button>
    </div>
    @endif
