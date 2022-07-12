@props(['disabled' => false, 'color' => null, 'placeholder'=> __('Select an option'), 'ajax'=>null, 'searchable' =>
'false', 'server' => 'false', 'title' => '' , 'addInit' => '', 'id' => randomString(30), 'selectAll' => 'false'])

@php
$searchable = $ajax!=null ? true : $searchable;
switch ($color) {
case 'green':
$theme = 'focus:border-green-300 focus:ring-green-200 border-gray-300 dark:border-gray-600';
break;
case 'yellow':
$theme = 'focus:border-amber-300 focus:ring-amber-200 border-gray-300 dark:border-gray-600';
break;
case 'red':
$theme = 'focus:border-red-300 focus:ring-red-200 border-gray-300 dark:border-gray-600';
break;
case 'error':
$theme = 'focus:border-red-300 focus:ring-red-200 border-red-300 dark:border-gray-600';
break;

default:
$theme = 'focus:border-blue-300 focus:ring-blue-200 border-gray-300 dark:border-gray-600';
break;

}
@endphp
<div class="text-gray-800 dark:text-gray-200 w-full" wire:ignore wire:key="{{$id}}"
    x-data="{disabled:{!!$disabled ? 'true' : 'false'!!}, select: null}" x-ref="select_wrapper_{{$id}}"
    x-init="select = new PBSelect({selector: `#${$refs.select_{{$id}}.id}`, width: '100%', searchbox: {!!$searchable!!} , server: {!! $server !!}, selectAll: {!! $selectAll !!}, placeholder: '{{$placeholder}}', search_placeholder: '{{__('Search')}}...'}) {{trim($title)!='' ? ', tippy($refs["select_wrapper_'.$id.'"],{content: "'.$title.'", animation: "scale-subtle"})' : '' }}">
    <select id="{{$id}}" x-ref="select_{{$id}}" {{$disabled ? 'disabled' : ''}} :disabled="disabled" {!! $attributes->merge(['class'
        => "$theme ".($disabled ? 'disabled' : 'dark:bg-opacity-5 dark:bg-white') ." focus:ring focus:ring-opacity-50 rounded-md py-2 text-sm shadow-sm text-gray-800 dark:text-gray-200"]) !!}
        x-bind:class="{'disabled dark:border-gray-600' : disabled,
        'dark:bg-opacity-5 dark:bg-white' : !disabled}">
        @if (trim($placeholder)!='')
        <option value="" {{$slot->__toString()!='' ? 'disabled selected' : 'selected'}} >{{ $placeholder }}</option>
        @endif
        {{$slot}}
    </select>
</div>
