<div class="text-right">
    @foreach ($actions as $action)
    @if (isset($action['can']))
    @if (is_array($action['can']))
    @canany($action['can'])
        @include('components.action-conditions')
    @endcanany
    @else
    @can($action['can'])
    @include('components.action-conditions')
    @endcan
    @endif
    @else
        @include('components.action-conditions')
    @endif

    @endforeach
</div>
