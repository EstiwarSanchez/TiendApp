@props(['type' => 'submit', 'cancel' => 'No', 'confirm' => 'Sí', 'id' => 'modal-reject', 'idForm' => '', 'title' => 'Rechazar', 'width' => 'sm'])

<x-modal :id="$id" maxWidth="{!! $width !!}">
    <h4 class="mb-4 font-semibold text-gray-800 dark:text-gray-300">
        {{ $title }}
    </h4>
    <form class="p-2" id="{{ $idForm }}" x-data="form()" @focusout="changeInput"
        @input="changeInput" @change="changeInput" @submit.prevent="{!! $idForm !!}">
        @csrf
        <div class="w-full text-lg font-semibold mb-4 text-center">
            {{ $slot }}
        </div>
        <div class="text-center">
            <x-button type="button" color="green"  x-on:click="submitForm">{{ $confirm }}
            </x-button>
            <x-button type="button" x-on:click="hideModal('{{ $id }}')">
                {{ $cancel }}</x-button>
        </div>
    </form>

</x-modal>
