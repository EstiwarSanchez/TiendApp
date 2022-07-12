@props(['type' => 'submit' , 'cancel' => 'No', 'confirm' => 'Sí', 'id' => 'modal-confirm', 'action' => '', 'title' => null, 'confirmColor' => 'green'])

<x-modal :id="$id" maxWidth="sm">
    @if ($title!=null)
    <div class="w-full text-lg font-semibold mb-4 text-center">
        {{__($title)}}
    </div>
    @endif
    <div class="w-full text-sm font-medium mb-4 text-center">
        {{ $slot }}
    </div>
    <div class="text-center">
        <x-button type="{{$type}}" color="{{$confirmColor}}"
            x-on:click="hideModal('{{$id}}'){{trim($action)!='' ? ',' : ''}}{!!$action!!}">{{ $confirm }}
        </x-button>
        <x-button type="button" x-on:click="hideModal('{{$id}}')">
            {{ $cancel }}</x-button>
    </div>
</x-modal>
