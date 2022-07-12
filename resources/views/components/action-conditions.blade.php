@if (isset($action['condition']))
@php
    $c = $action['condition'];
@endphp

@if (is_array($c) )
@php
    $mc = 'no';
@endphp
@for ($i = 0; $i < count($c); $i++)
@if ($c[$i]==='==')

@if ($item[$action['to_check'][$i]]==$action['value'][$i])
@php $mc = true @endphp
@else
@php $mc = false @endphp
@endif

@elseif ($c[$i]==='===')

@if ($item[$action['to_check'][$i]]==$action['value'][$i])
@php $mc = true @endphp
@else
@php $mc = false @endphp
@endif

@elseif ($c[$i]==='!=')

@if ($item[$action['to_check'][$i]]!=$action['value'][$i])
@php $mc = true @endphp
@else
@php $mc = false @endphp
@endif

@elseif ($c[$i]==='!==')

@if ($item[$action['to_check'][$i]]!==$action['value'][$i])
@php $mc = true @endphp
@else
@php $mc = false @endphp
@endif

@elseif ($c[$i]==='<')

@if ($item[$action['to_check'][$i]]<$action['value'][$i])
@php $mc = true @endphp
@else
@php $mc = false @endphp
@endif

@elseif ($c[$i]==='>')

@if ($item[$action['to_check'][$i]]>$action['value'][$i])
@php $mc = true @endphp
@else
@php $mc = false @endphp
@endif

@elseif ($c[$i]==='>=')
@if ($item[$action['to_check'][$i]]>=$action['value'][$i])
@php $mc = true @endphp
@else
@php $mc = false @endphp
@endif

@elseif ($c[$i]==='<=')

@if ($item[$action['to_check'][$i]]<=$action['value'][$i])
@php $mc = true @endphp
@else
@php $mc = false @endphp
@endif
@endif
@if ($mc != 'no' && $mc === false)
    @break
@endif
@endfor
@if ($mc)
@include('components.button-action')
@endif
@else

@if ($c==='==')

@if ($item[$action['to_check']]==$action['value'])
@include('components.button-action')
@endif

@elseif ($c==='===')

@if ($item[$action['to_check']]==$action['value'])
@include('components.button-action')
@endif

@elseif ($c==='!=')

@if ($item[$action['to_check']]!=$action['value'])
@include('components.button-action')
@endif

@elseif ($c==='!==')

@if ($item[$action['to_check']]!==$action['value'])
@include('components.button-action')
@endif

@elseif ($c==='<')

@if ($item[$action['to_check']]<$action['value'])
@include('components.button-action')
@endif

@elseif ($c==='>')

@if ($item[$action['to_check']]>$action['value'])
@include('components.button-action')
@endif

@elseif ($c==='>=')
@if ($item[$action['to_check']]>=$action['value'])
@include('components.button-action')
@endif

@elseif ($c==='<=')

@if ($item[$action['to_check']]<=$action['value'])
@include('components.button-action')
@endif
@else
@include('components.button-action')
@endif
@endif
@else
@include('components.button-action')
@endif
