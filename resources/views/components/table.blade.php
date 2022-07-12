
<div class="w-full px-1 flex flex-wrap">
        @if ($enableSearch)
        <div class="inline-block mr-auto ml-0 mb-3">
            <x-label for="search-table" value="{{ __('Search') }}" />
            <x-input wire:model.debounce.700ms="search" id="search-table" class="block mt-1 w-full max-w-xs mb-4"
                type="search" />
        </div>
        @if ($items->isNotEmpty())
        @yield('slot')
        @isset($perPage)
        <div class="inline-block ml-auto mr-0 mb-3" id="per-page-table" wire:ignore>
            <x-label for="per-page" value="{{ __('Per Page') }}" />
            <x-select wire:model="perPage" placeholder="" class="block mt-1 w-full max-w-xs mb-4">
                <option value="3" {{$perPage == 3 ? 'selected': ''}}>3</option>
                <option value="5" {{$perPage == 5 ? 'selected': ''}}>5</option>
                <option value="10" {{$perPage == 10 ? 'selected': ''}}>10</option>
                <option value="15" {{$perPage == 15 ? 'selected': ''}}>15</option>
                <option value="25" {{$perPage == 25 ? 'selected': ''}}>25</option>
                <option value="35" {{$perPage == 35 ? 'selected': ''}}>35</option>
                <option value="50" {{$perPage == 50 ? 'selected': ''}}>50</option>
            </x-select>
        </div>
        @endisset
        @endif
        @endif
</div>
@if ($items->isNotEmpty())
<div class="w-full overflow-hidden rounded-lg shadow-sm">
    <div>
        <div class="w-full bg-gray-50
                    dark:bg-gray-700 rounded-t-lg pt-2">
        </div>
        <div class="w-full overflow-x-auto" x-data="{id:null}">
            <table class="w-full whitespace-no-wrap table" style="min-width: {{ $width ?? '1100'}}px; width: {{ $width ?? '1100'}}">
                <thead>
                    <tr
                        id="tr-table" class="text-sm font-bold tracking-wide text-left text-gray-700 border-b dark:border-gray-700 bg-gray-50 dark:text-gray-200 dark:bg-gray-700">

                        @foreach ($columns as $header)
                        <th class="px-3 pb-2 whitespace-nowrap text-{{ $header['align'] ?? '' }}">
                            {{$header['title']}}
                            @if (isset($header['filter']) && $header['filter'] && $filter)
                            @php
                            if (is_array($header['name'])) {
                                if (is_array($header['name'][1])) {
                                    $header['name'] = $header['name'][0].'._.'.$header['name'][1][0].'._.'.$header['name'][1][1];
                                }else{
                                    $header['name'] = $header['name'][0].'._.'.$header['name'][1];
                                }

                            }
                            @endphp
                            <span class="cursor-pointer" wire:click="filterBy('{{$header['name']}}')">
                                @if ($by==$header['name'])
                                @if ($order=='DESC')
                                <x-sort-down />
                                @else
                                <x-sort-up />
                                @endif
                                @else
                                <x-sort />
                                @endif
                            </span>
                            @endif
                        </th>
                        @endforeach
                        @if (count($actions)>0)
                        <th class="px-3 pb-2 text-right" id="table-options">Opciones</th>
                        @endif
                    </tr>
                </thead>
                <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                    @forelse ($items as $item)
                    <tr class="text-gray-800 dark:text-gray-300">
                        @foreach ($columns as $column)
                        @switch($column['type'])
                        @case(1)
                        <td class="px-3 py-2 text-sm text-{{ $column['align'] ?? '' }}">
                            {{ __(getValueTable($column['name'], $item)) }}
                        </td>
                        @break
                        @case(2)
                        <td class="px-3 py-2 text-{{ $column['align'] ?? '' }}">
                            @php
                            $val = getValueTable($column['name'], $item);
                            $name = is_array($column['name']) ? $column['name'][1] : $column['name'];
                            @endphp
                            <span
                                class="px-2 py-1 font-semibold text-xs shadow-sm whitespace-nowrap  leading-tight text-{{getStatusColor($val)}}-800 bg-{{getStatusColor($val)}}-100 rounded-full dark:bg-{{getStatusColor($val)}}-700 dark:text-{{getStatusColor($val)}}-50">
                                @if ($name=='status'|| Str::contains(($name),'.status'))
                                {{$item->status_string ?? $item->status}}
                                @else
                                {{  __($val) }}
                                @endif
                            </span>
                        </td>
                        @break
                        @case(3)
                        <td class="px-3 py-2 text-sm text-{{ $column['align'] ?? '' }}">
                            {{ dateToHuman(getValueTable($column['name'], $item))}}
                        </td>
                        @break
                        @case(4)
                        <td class="px-3 py-2 text-sm text-{{ $column['align'] ?? '' }}">
                            <div class="relative pt-1">
                                <div class="flex items-center justify-between">
                                    <div>
                                    </div>
                                    <div class="text-right">
                                        <span class="text-xs font-semibold inline-block text-psi-blue-600">
                                            {{decimals(getValueTable($column['name'], $item,0),2)}}%
                                        </span>
                                    </div>
                                </div>
                                <div class="overflow-hidden h-2 text-xs flex rounded bg-psi-blue-200">
                                    <div style="width:{{decimals(getValueTable($column['name'], $item,0),2)}}%"
                                        class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-psi-blue-600">
                                    </div>
                                </div>
                            </div>
                        </td>
                        @break
                        @case(5)
                        <td class="px-3 py-2 text-sm text-{{ $column['align'] ?? '' }}">
                            <span class='w-4 h-4 shadow inline-block mr-1 rounded-full align-bottom' aria-hidden='true' style='background-color:{{getValueTable($column['color'], $item)}}; color:{{getValueTable($column['color'], $item)}};'></span>
                            {{  getValueTable($column['name'], $item) }}
                        </td>
                        @break
                        @case(6)
                        <td class="px-3 py-2 text-sm text-{{ $column['align'] ?? '' }}">
                            {{-- <x- class='w-4 h-4 shadow inline-block mr-1 align-text-top' aria-hidden='true'></span> --}}
                            @if (getValueTable($column['icon'], $item) != null && getValueTable($column['icon'], $item) != '')
                                <x-dynamic-component :component="'icon-'.getValueTable($column['icon'], $item)" class="w-5 h-5 inline-block mr-1 align-text-top" />
                            @endif
                            {{  getValueTable($column['name'], $item) }}
                        </td>
                        @break
                        @case(7)
                        <td class="px-3 py-2 text-sm text-{{ $column['align'] ?? '' }}">
                            <div class='diamond shadow-md m-auto'  style='background-color:{{getValueTable($column['color'], $item)}}; color:{{getValueTable($column['color'], $item)}};'>
                                 {{-- {{  getValueTable($column['name'], $item) }} --}}
                            </div>
                        </td>
                        @break
                        @case(8)
                        <td class="px-3 py-2 text-sm text-{{ $column['align'] ?? '' }}">
                            {{ formatSizeUnits(getValueTable($column['name'], $item)) }}
                        </td>
                        @break
                        @case(9)
                        <td class="px-3 py-2 text-sm text-{{ $column['align'] ?? '' }}">
                            @switch($column['template'])
                            @case(1)
                            @if (is_array($column['key']))
                            @if (is_array($column['key'][1]))
                            {{ (is_array($column['var']) ? (isset($column['var'][$item[$column['key'][1][0]][$column['key'][1][1]]]) ? $column['var'][$item[$column['key'][1][0]][$column['key'][1][1]]] : null) : $column['var']) ?? 'N/A' }}
                            @else
                            {{ (is_array($column['var']) ? (isset($column['var'][$item[$column['key'][0]][$column['key'][1]]]) ? $column['var'][$item[$column['key'][0]][$column['key'][1]]] : null) : $column['var']) ?? 'N/A' }}
                            @endif
                            @else
                            {{ (is_array($column['var']) ? (isset($column['var'][$item[$column['key']]]) ? $column['var'][$item[$column['key']]] : null) : $column['var']) ?? 'N/A' }}
                            @endif
                            @break
                            @case(2)
                            <div class="relative pt-1">
                                <div class="flex items-center justify-between">
                                    <div>
                                    </div>
                                    <div class="text-right">
                                        <span class="text-xs font-semibold inline-block text-psi-blue-600">
                                            @if (is_array($column['key']))
                                            {{ decimals(((is_array($column['var']) ? (isset($column['var'][$item[$column['key'][0]][$column['key'][1]]]) ? $column['var'][$item[$column['key'][0]][$column['key'][1]]] : null) : $column['var']) ?? 0),2)}}%
                                            @else
                                            {{ decimals(((is_array($column['var']) ? (isset($column['var'][$item[$column['key']]]) ? $column['var'][$item[$column['key']]] : null) : $column['var']) ?? 0),2) }}%
                                            @endif

                                        </span>
                                    </div>
                                </div>
                                <div class="overflow-hidden h-2 text-xs flex rounded bg-psi-blue-200">
                                    <div style="width:{{is_array($column['key']) ? decimals(((is_array($column['var']) ? (isset($column['var'][$item[$column['key'][0]][$column['key'][1]]]) ? $column['var'][$item[$column['key'][0]][$column['key'][1]]] : null) : $column['var']) ?? 0),2) : decimals(((is_array($column['var']) ? (isset($column['var'][$item[$column['key']]]) ? $column['var'][$item[$column['key']]] : null) : $column['var']) ?? 0),2)}}%"
                                        class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-psi-blue-600">
                                    </div>
                                </div>
                            </div>
                            @break
                            @default
                            {{  is_array($column['var']) ?  $column['var'][$item[$column['key']]] : $column['var'] }}
                            @break
                            @endswitch
                        </td>
                        @break
                        @default

                        @endswitch
                        @endforeach
                        @if (count($actions)>0)
                        <td class="px-3 py-2" style="min-width: {{(count($actions)*28)+24}}px; max-width: {{(count($actions)*28)+24}}px; width: {{(count($actions)*28)+24}}px;">
                            @include('components.table-actions')
                        </td>
                        @endif
                    </tr>
                    @empty
                    <tr>
                        <td colspan="{{(count($columns)+1)}}" class="py-6 font-semibold text-lg text-center">Aún no se
                            han creado registros.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if ($enableSearch)
    {!! $items->onEachSide(1)->links() !!}
    @endif
</div>
@else
<p class="py-6 font-semibold text-center dark:text-gray-200">{{__('No records found')}}</p>
@endif
