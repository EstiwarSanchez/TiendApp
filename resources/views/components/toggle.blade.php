@props(['active'=>false,'name'=>'', 'id'=>'', 'theme'=>false])
<label  class="block toggle border border-gray-300 dark:border-gray-700 cursor-pointer" x-data="{active:{{$theme ? 'dark' : ($active ? 'true': 'false')}}}" :class="{'active':active}">
    <input {{$attributes->filter(fn ($value, $key) => !in_array($key,['id','name']))}} type="checkbox" name="{{$name}}" id="{{$id}}" x-bind:value="active ? 'true' : 'false'" x-model="active" aria-hidden="sr-only" class="hidden">
</label>
