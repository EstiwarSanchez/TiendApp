@props(['field', 'index'=>0, 'answer' => ''])
@php
    $name = '_'.Str::replace(['.',',',')','(','/'], '_', Str::ascii(Str::snake(Str::lower($field['label'] ?? '')))).($index>0 ? '_'.$index :
    '');

    $answer[$name] =  isset($answer[$name]) && $answer[$name]!=null ? $answer[$name] : '';

    @endphp
<div
    class="relative mb-4 {{ $field['type'] == 'file' ? 'col-span-full text-center justify-center' : 'w-full flex flex-wrap' }}" x-ref="field_{{$name}}">



    <div class="inline-flex">
        <x-label for="{{ $field['type'] == 'tooltip' ? $name : '' }}" value="{{ __($field['label'] ?? '') }}" class="mb-auto mt-0"
            title="{{ __($field['label'] ?? '') }}" />
        @if ($field['type'] == 'tooltip')
        @php
        $title = '';
        if (isset($field['validation'])) {
        switch ($field['validation']) {
        case 'min':
        $title = ($field['quantity'] ?? 1) > 1 ? __('answer.resource.minimums',['value'=>$field['quantity']]) :
        __('answer.resource.minimum');
        break;
        default:
        $title = $field['label'];
        break;
        }
        }
        @endphp
        <span data-tippy-content="{{$title}}" class="-mt-1 ml-1 text-psi-orange-600 w-5 h-5 rounded-full shadow-sm ">
            <x-icon-exclamation-circle-s class="w-5 h-5 cursor-help rounded-full" /> </span>
        @endif
    </div>
    @if($field['type'] != 'tooltip')
    <div class="w-full flex flex-wrap content-end " x-bind:class="{'invalid':{{ $name }}.errorMessage}">

        @if ($field['type'] == 'select')
        <x-select name="{{ $name }}" id="{{ $name }}" placeholder="" searchable="true"
            data-rules="['required']" data-server-errors='[]' >
            <option value="" {{$answer[$name] == ''  ? 'selected disabled' : ''}} >{{__('global.select.blank') }}</option>
            @isset($field['option'])
            @foreach ($field['option'] as $item)
            <option value="{{ $item['value'] }}" {{$answer[$name] == $item['value'] ? 'selected' : ''}}>{{ $item['text'] }}</option>
            @endforeach
            @endisset
        </x-select>
        @elseif ($field['type'] == 'date')
        <x-datepicker name="{{ $name }}" id="{{ $name }}" x-bind:class="{'invalid':{{ $name }}.errorMessage}"
            data-rules="['required']" data-server-errors='[]' placeholder="{{ __($field['label'] ?? '') }}" :default="$answer[$name]"/>
        @elseif(isset($field['value_type']))
        @if (in_array($field['value_type'],['text','digits']))
        <x-input type="{{ $field['value_type'] == 'text' ? 'text' : 'tel' }}"
            maxlength="{{ $field['maxlength'] ?? 250 }}" class="w-full" id="{{ $name }}" name="{{ $name }}"
            x-bind:class="{'invalid':{{ $name }}.errorMessage}"
            data-rules="['required','maximum:{{ $field['maxlength'] ?? 250 }}', 'minimum:{{ $field['value_type'] == 'text' ? 3 : 1 }}' {{ $field['value_type'] == 'digits' ? `, 'numeric'` : '' }}]"
            data-server-errors='[]' placeholder="{{ __($field['label'] ?? '') }}" value="{{$answer[$name]}}" only="{{ $field['value_type'] ?? ''}}"/>
        @elseif ($field['value_type'] == 'textarea')
        @if (__($field['label'] ?? '') == 'Observaciones')
        <x-textarea maxlength="{{ $field['maxlength'] }}" id="{{ $name }}" name="{{ $name }}" class="w-full max-h"
            cols="10" rows="5" placeholder="Observaciones" data-server-errors='[]' data-rules="[]">{{$answer[$name] != '' ? $answer[$name] : 'Sin observaciones' }}</x-textarea>
        @else
        <x-textarea maxlength="{{ $field['maxlength'] }}" id="{{ $name }}" name="{{ $name }}" class="w-full max-h"
        cols="10" rows="5" placeholder="{{ __($field['label'] ?? '') }}" data-server-errors='[]' data-rules="['required']">{{$answer[$name] ?? '' }}</x-textarea>
        @endif
        @else
        <x-input-file-drop class="mx-auto" type="{{ $field['type'] }}" id="{{ $name }}" name="{{ $name }}" default="{{ $answer[$name]!= '' ? base64_encode(file_get_contents(asset('storage/images/answer_resources/'.$answer[$name]))) : 'null'}}" imageName="{{$answer[$name]!= '' ? $answer[$name] : 'null'}}"/>
        @endif
        @endif
    </div>
        <p class="text-xs text-red-600 font-semibold absolute transition-all" x-bind:style="'top: '+($refs.field_{{$name}}.clientHeight+2)+'px'" x-show.transition.in="{{ $name }}.errorMessage"
        x-text="{{ $name }}.errorMessage"></p>
    @endif

</div>
