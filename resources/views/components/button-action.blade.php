@php
$route = '';
if(isset($action['link'])){
if (isset($action['link']['params'])) {
$params = [];
foreach ($action['link']['params'] as $param) {
$params[$param[0]] = isset($item[$param[1]]) ?  (string)$item[$param[1]] : (string)$param[1];

}
$route = route($action['link']['route'], $params);
}else{
$route = route($action['link']['route']);
}
}
@endphp
<x-button class="btn-table-action" wire:key="{{ randomString(30) }}" link="{{$route}}" size="icon" title="{{$action['title'] ?? ''}}" aria-label="{{$action['title'] ?? ''}}" color="{{$action['color']}}"
    x-on:click="{{isset($action['function'][0]) ? $action['function'][0] : ''}}{{isset($action['function'][1]) && $action['function'][1]!=null ? '('.getParamsValues($item,$action['function'][1]).')' : ''}}">
    <x-dynamic-component class="m-auto h-3" :component="'icon-'.($action['icon'] ?? 'circle')" />
</x-button>
