@props(['checked' => false, 'type' => 'checkbox'])
<input type="{{$type}}" {{$checked ? 'checked' :''}} {!! $attributes->merge(['class' => ($type=='checkbox' ? 'rounded' : 'rounded-full').' border-gray-300 dark:border-gray-600 dark:bg-gray-600  text-psi-green-600 shadow-sm focus:border-psi-green-300 focus:ring focus:ring-psi-green-200 focus:ring-opacity-50']) !!}>
