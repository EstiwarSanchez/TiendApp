@props(['template_html_id' => 'template_html', 'template_json_id' => 'template_json', 'json' => null])
@php
$id = randomString(10);
@endphp
<div class="drag-and-drop flex flex-wrap md:flex-nowrap"
    x-data="formBuilder('{{ $template_html_id }}','{{ $template_json_id }}')" id="form_builder"
    x-init='init({!! $json != null ? $json : '' !!})' @format-change.window="setTimeout(()=>{saveFormat();},250)">
    <div class="drag-and-drop__container drag-and-drop__container--from md:max-w-xxs w-full shadow">
        <h3
            class="text-sm font-bold tracking-wide text-left text-gray-700 border-b dark:border-gray-600 bg-gray-50 dark:text-gray-200 dark:bg-gray-600  px-3 py-2">
            Elementos</h3>
        <div class="max-h-xl overflow-y-auto overflow-x-hidden">
            <ul class="drag-and-drop__items" id="form-element" x-on:drop="removing = false"
                x-on:dragover.prevent="removing = true" x-on:dragleave.prevent="removing = false">
                <!-- loop through the items -->
                <li id="item-title" class="drag-and-drop__item dark:bg-gray-700"
                    :class="{ 'drag-and-drop__item--dragging': dragging }"
                    x-on:dragstart.self="dragging = true;event.dataTransfer.effectAllowed='move';event.dataTransfer.setData('text/plain', event.target.id);"
                    x-on:dragend="dragging = false" x-data="{ dragging: false}" draggable="true">
                    <div class="w-full mb-3 relative" data-type="title" x-data="{text: 'Título' , edit: false}">
                        <div x-show="!edit" class="w-full">
                            <h2 class="mb-4 font-semibold text-xl text-gray-800 dark:text-gray-300 w-full"
                                x-text="text">
                            </h2>
                            <hr class="mt-3">
                        </div>
                        <div class=" bg-white dark:bg-gray-700 edit-options hidden" x-show="edit">
                            <input
                                class="mb-4 font-semibold text-xl text-gray-800 dark:text-gray-300 shadow bg-gray-50 rounded w-full pr-8"
                                x-model="text" x-on:keyup.enter="edit=false; $dispatch('format-change');">
                        </div>
                        <x-form-builder-buttons />
                    </div>
                </li>
                <li id="item-subtitle" class="drag-and-drop__item dark:bg-gray-700"
                    :class="{ 'drag-and-drop__item--dragging': dragging }"
                    x-on:dragstart.self="dragging = true;event.dataTransfer.effectAllowed='move';event.dataTransfer.setData('text/plain', event.target.id);"
                    x-on:dragend="dragging = false" x-data="{ dragging: false }" draggable="true">
                    <div class="w-full mb-3 " data-type="subtitle" x-data="{text: 'Subtítulo' , edit: false}">
                        <div x-show="!edit" class="w-full">
                            <h4 class="mb-3 font-semibold text-gray-800 dark:text-gray-300" x-text="text"></h4>
                        </div>
                        <div class=" bg-white dark:bg-gray-700 edit-options hidden" x-show="edit">
                            <input
                                class="mb-3 font-semibold text-gray-800 dark:text-gray-300 shadow bg-gray-50 rounded w-full pr-8"
                                x-model="text" x-on:keyup.enter="edit=false; $dispatch('format-change')">
                        </div>
                        <x-form-builder-buttons />
                    </div>
                </li>
                <li id="item-text" class="drag-and-drop__item dark:bg-gray-700"
                    :class="{ 'drag-and-drop__item--dragging': dragging }"
                    x-on:dragstart.self="dragging = true;event.dataTransfer.effectAllowed='move';event.dataTransfer.setData('text/plain', event.target.id);"
                    x-on:dragend="dragging = false" x-data="{ dragging: false }" draggable="true">
                    <div class="w-full mb-3" data-type="text" x-ref="parent"
                        x-data="{label: 'Texto' , edit: false, required: false, disabled: true, readonly: false, maxlength: '', value: ''}">
                        <div x-show="!edit" class="w-full">
                            <x-label x-text="label" class="input-label"></x-label>
                            <x-input type="text" x-model="value" x-bind:value="value" class="w-full" x-bind:disabled="disabled"
                                x-bind:placeholder="label" x-bind:readonly="readonly"
                                x-bind:data-rules="required ? `['required']` : `[]`"
                                x-bind:data-server-errors='required ? `[]` : `[]`' x-bind:maxlength="maxlength" />
                            <p class="text-xs text-red-600 font-semibold mt-1 validate-msg"></p>
                        </div>
                        <div class=" bg-white dark:bg-gray-700 edit-options hidden" x-show="edit">
                            <input
                                class="block font-medium text-sm text-gray-700 dark:text-gray-300 shadow bg-gray-50 rounded pr-8"
                                x-model="label">
                            <div class="w-full flex flex-wrap mt-4 gap-2">
                                <x-label size="xs" class="flex">
                                    <x-checkbox x-model="required" class="mr-1" ></x-checkbox> Obligatorio
                                </x-label>
                                <x-label size="xs" class="flex">
                                    <x-checkbox x-model="disabled" class="mr-1" ></x-checkbox> Deshabilitado
                                </x-label>
                                <x-label size="xs" class="flex">
                                    <x-checkbox x-model="readonly" class="mr-1" ></x-checkbox> Solo lectura
                                </x-label>
                                <x-label size="xs">
                                    <input
                                        class="only-digits inline-block font-medium text-xs text-gray-700 dark:text-gray-300 shadow bg-gray-50 rounded px-1 w-8"
                                        x-model="maxlength" placeholder="∞" >
                                    N° Caracteres
                                </x-label>
                            </div>
                        </div>
                        <x-form-builder-buttons />
                    </div>
                </li>
                <li id="item-date" class="drag-and-drop__item dark:bg-gray-700"
                    :class="{ 'drag-and-drop__item--dragging': dragging }"
                    x-on:dragstart.self="dragging = true;event.dataTransfer.effectAllowed='move';event.dataTransfer.setData('text/plain', event.target.id);"
                    x-on:dragend="dragging = false" x-data="{ dragging: false }" draggable="true">
                    <div class="w-full mb-3" data-type="date" x-ref="parent"
                        x-data="{label: 'Fecha' , edit: false, required: false, disabled: true, today : false, value: ''}" x-init="flatpickr($refs.input, { minDate: null, enableTime:false, 'locale': '{{app()->getLocale()=='base' || app()->getLocale()=='es' ? 'es' : 'en'}}'})">
                        <div x-show="!edit" class="w-full">
                            <x-label x-text="label" class="input-label"></x-label>
                            <div class="relative" data-wrapper="date">
                                <input id="datepicker_" readonly x-ref="input" x-bind:disabled="disabled"
                                    x-bind:placeholder="label" x-model="value" x-bind:value="value" x-bind:data-rules="required ? `['required']` : `[]`"
                                    x-bind:data-server-errors='required ? `[]` : `[]`'
                                    type="text"
                                    class="w-full focus:ring focus:ring-opacity-50 focus:border-blue-300 focus:ring-blue-200 border-gray-300 dark:border-gray-600 rounded-md py-2 text-sm shadow-sm text-gray-800 dark:text-gray-200">
                                <label class="label-calendar input-label cursor-pointer text-psi-blue-500" for="datepicker_">
                                    <x-icon-calendar class="h-4"/></label>
                            </div>
                            <p class="text-xs text-red-600 font-semibold mt-1 validate-msg"></p>
                        </div>
                        <div class=" bg-white dark:bg-gray-700 edit-options hidden" x-show="edit">
                            <input
                                class="block font-medium text-sm text-gray-700 dark:text-gray-300 shadow bg-gray-50 rounded pr-8"
                                x-model="label">
                            <div class="w-full flex flex-wrap mt-4 gap-2">
                                <x-label size="xs" for="" class="flex">
                                    <x-checkbox x-model="required"  class="mr-1"></x-checkbox> Obligatorio
                                </x-label>
                                <x-label size="xs" class="flex">
                                    <x-checkbox x-model="disabled"  class="mr-1"></x-checkbox> Deshabilitado
                                </x-label>
                                <x-label size="xs" class="flex">
                                    <x-checkbox x-model="today"  x-on:change="$refs.input._flatpickr.set('minDate', (today ? 'today' : null));" class="mr-1"></x-checkbox> Minimo actual
                                </x-label>
                            </div>
                        </div>
                        <x-form-builder-buttons />
                    </div>
                </li>
                <li id="item-digits" class="drag-and-drop__item dark:bg-gray-700"
                    :class="{ 'drag-and-drop__item--dragging': dragging }"
                    x-on:dragstart.self="dragging = true;event.dataTransfer.effectAllowed='move';event.dataTransfer.setData('text/plain', event.target.id);"
                    x-on:dragend="dragging = false" x-data="{ dragging: false }" draggable="true">

                    <div class="w-full mb-3" data-type="digits"
                        x-data="{label: 'Números' , edit: false, required: false, disabled: true, readonly: false, maxlength: ''}">
                        <div x-show="!edit" class="w-full">
                            <x-label x-text="label"></x-label>
                            <x-input type="tel" only="digits" x-bind:value="label" class="w-full"
                                x-bind:disabled="disabled" x-bind:placeholder="label" x-bind:readonly="readonly"
                                x-bind:data-rules="required ? `['required']` : `[]`"
                                x-bind:data-server-errors='required ? `[]` : `[]`' x-bind:maxlength="maxlength" />
                            <p class="text-xs text-red-600 font-semibold mt-1 validate-msg"></p>
                        </div>
                        <div class=" bg-white dark:bg-gray-700 edit-options hidden" x-show="edit">
                            <input
                                class="block font-medium text-sm text-gray-700 dark:text-gray-300 shadow bg-gray-50 rounded pr-8"
                                x-model="label">
                            <div class="w-full flex flex-wrap mt-4 gap-2">
                                <x-label size="xs" class="flex">
                                    <x-checkbox x-model="required" class="mr-1"></x-checkbox> Obligatorio
                                </x-label>
                                <x-label size="xs" class="flex">
                                    <x-checkbox x-model="disabled" class="mr-1"></x-checkbox> Deshabilitado
                                </x-label>
                                <x-label size="xs" class="flex">
                                    <x-checkbox x-model="readonly" class="mr-1"></x-checkbox> Solo lectura
                                </x-label>
                                <x-label size="xs">
                                    <input
                                        class="inline-block only-digits font-medium text-xs text-gray-700 dark:text-gray-300 shadow bg-gray-50 rounded px-1 w-8"
                                        x-model="maxlength" placeholder="∞">
                                    Dígitos
                                </x-label>

                            </div>
                        </div>
                        <x-form-builder-buttons />
                    </div>
                </li>
                <li id="item-select" class="drag-and-drop__item dark:bg-gray-700"
                    :class="{ 'drag-and-drop__item--dragging': dragging }"
                    x-on:dragstart.self="dragging = true;event.dataTransfer.effectAllowed='move';event.dataTransfer.setData('text/plain', event.target.id);"
                    x-on:dragend="dragging = false" x-data="{ dragging: false }" draggable="true">
                    <div class="w-full mb-3" data-type="select" x-ref="parent"
                        x-data="{label: 'Opciones' , edit: false, required: false, disabled: true, readonly: false, options:[], text: '', value: ''}">
                        <div x-show="!edit" class="w-full">
                            <x-label x-text="label" class="input-label"></x-label>
                            <select searchable="true"
                                class="focus:border-blue-300 focus:ring-blue-200 border-gray-300 dark:border-gray-600 focus:ring focus:ring-opacity-50 rounded-md p-2 text-sm shadow-sm text-gray-800 dark:text-gray-200 w-full"
                                x-model="value"
                                x-bind:disabled="disabled" x-bind:readonly="readonly"
                                x-bind:data-rules="required ? `['required']` : `[]`"
                                x-bind:data-server-errors='required ? `[]` : `[]`'>
                                <option value="" x-bind:selected="value==''">Seleccione</option>
                                <template x-for="item in options">
                                    <option x-bind:value="item.value" x-bind:selected="value==item.value" x-text="item.text"></option>
                                </template>
                            </select>
                            <p class="text-xs text-red-600 font-semibold mt-1 validate-msg"></p>
                        </div>
                        <div class=" bg-white dark:bg-gray-700 edit-options hidden" x-show="edit">
                            <input
                                class="block font-medium text-sm text-gray-700 dark:text-gray-300 shadow bg-gray-50 rounded pr-8"
                                x-model="label">
                            <div class="w-full flex flex-wrap mt-4 gap-2">
                                <x-label size="xs" class="flex">
                                    <x-checkbox x-model="required" class="mr-1"  ></x-checkbox> Obligatorio
                                </x-label>
                                <x-label size="xs" class="flex">
                                    <x-checkbox x-model="disabled" class="mr-1"  ></x-checkbox> Deshabilitado
                                </x-label>
                                <x-label size="xs" class="flex">
                                    <x-checkbox x-model="readonly" class="mr-1" ></x-checkbox> Solo lectura
                                </x-label>
                                <div class="w-full relative">
                                    <x-label size="xs">Opciones</x-label>
                                    <div class="gap-2 flex-wrap flex w-full">
                                        <input
                                            class="block font-medium text-xs p-1 text-gray-700 dark:text-gray-300 shadow bg-gray-50 rounded"
                                            x-model="text" placeholder="Opción">
                                        <input
                                            class="block font-medium text-xs p-1 text-gray-700 dark:text-gray-300 shadow bg-gray-50 rounded"
                                            x-model="value" placeholder="Valor">
                                        <x-button class="shadow-md absolute r-0 t-0 mr-1" color="green" size="icon"
                                            rounded="full" x-show="edit"
                                            x-on:click="options.push({text:text, value:value}); text=''; value=''; $dispatch('format-change');">
                                            <x-icon-plus class="h-3"/>
                                        </x-button>
                                    </div>
                                    <template x-for="(item, index) in options">
                                        <div class="inline">
                                            <span class="text-xs" x-text="item.value+ ' - ' +item.text + '. '"></span>
                                            <x-button rounded="full" class="transform scale-50 shado" color="red"
                                                size="icon" x-on:click="options.splice(index, 1);">
                                                <x-icon-times class="h-3"/>
                                            </x-button>
                                        </div>
                                    </template>

                                </div>

                            </div>
                        </div>
                        <x-form-builder-buttons />
                    </div>
                </li>
                <li id="item-textarea" class="drag-and-drop__item dark:bg-gray-700"
                    :class="{ 'drag-and-drop__item--dragging': dragging }"
                    x-on:dragstart.self="dragging = true;event.dataTransfer.effectAllowed='move';event.dataTransfer.setData('text/plain', event.target.id);"
                    x-on:dragend="dragging = false" x-data="{ dragging: false }" draggable="true">
                    <div class="w-full mb-3" data-type="textarea"
                        x-data="{label: 'Texto largo' , edit: false, required: false, disabled: true, readonly: false, maxlength: '', value:''}">
                        <div x-show="!edit" class="w-full">
                            <x-label x-text="label"></x-label>
                            <x-textarea x-model="value" x-bind:value="value" class="w-full" x-bind:disabled="disabled"
                                x-bind:placeholder="label" x-bind:readonly="readonly"
                                x-bind:data-rules="required ? `['required']` : `[]`"
                                x-bind:data-server-errors='required ? `[]` : `[]`' x-bind:maxlength="maxlength">
                            </x-textarea>
                            <p class="text-xs text-red-600 font-semibold mt-1 validate-msg"></p>
                        </div>
                        <div class=" bg-white dark:bg-gray-700 edit-options hidden" x-show="edit">
                            <input
                                class="block font-medium text-sm text-gray-700 dark:text-gray-300 shadow bg-gray-50 rounded pr-8"
                                x-model="label">
                            <div class="w-full flex flex-wrap mt-4 gap-2">
                                <x-label size="xs" class="flex">
                                    <x-checkbox x-model="required" class="mr-1"></x-checkbox> Obligatorio
                                </x-label>
                                <x-label size="xs" class="flex">
                                    <x-checkbox x-model="disabled" class="mr-1"></x-checkbox> Deshabilitado
                                </x-label>
                                <x-label size="xs" class="flex">
                                    <x-checkbox x-model="readonly" class="mr-1"></x-checkbox> Solo lectura
                                </x-label>
                                <x-label size="xs">
                                    <input
                                        class="only-digits inline-block font-medium text-xs text-gray-700 dark:text-gray-300 shadow bg-gray-50 rounded px-1 w-8"
                                        x-model="maxlength" placeholder="∞">
                                    N° Caracteres
                                </x-label>
                            </div>
                        </div>
                        <x-form-builder-buttons />
                    </div>
                </li>
                {{-- <li id="item-file" class="drag-and-drop__item dark:bg-gray-700"
                    :class="{ 'drag-and-drop__item--dragging': dragging }"
                    x-on:dragstart.self="dragging = true;event.dataTransfer.effectAllowed='move';event.dataTransfer.setData('text/plain', event.target.id);"
                    x-on:dragend="dragging = false" x-data="{ dragging: false }" draggable="true">
                    <div class="w-full mb-3" data-type="file"
                        x-data="{label: 'Archivo' , files: null, edit: false, required: false, disabled: true,  multiple: false}">
                        <div x-show="!edit" class="w-full">
                            <x-label x-text="label" class="input-label" for="file_input"></x-label>
                            <label x-bind:class="{'disabled': disabled}" class="focus:ring focus:ring-opacity-50 border truncate cursor-pointer flex rounded-md py-2 text-sm shadow-sm text-gray-800 dark:text-gray-200 input-label" for="file_input">
                                <input x-bind:disabled="disabled" type="file" x-bind:multiple="multiple" class="sr-only"
                                    id="file_input" x-on:change="files = Object.values($event.target.files)" x-bind:data-rules="required ? `['required']` : `[]`"
                                    x-bind:data-server-errors='required ? `[]` : `[]`'>

                                <span class="ml-2 flex ">
                                    <svg fill="currentColor" class="text-psi-blue-600" height="18" viewBox="0 0 24 24" width="18"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path d="M0 0h24v24H0z" fill="none" />
                                        <path d="M9 16h6v-6h4l-7-7-7 7h4zm-4 2h14v2H5z" />
                                    </svg>
                                    <span
                                        x-text="files && files.length > 0 && files!=null ? files.map(file => file.name).join(', ') : 'Seleccione '+(multiple ? 'los archivos' : 'el archivo')+'...'"></span>
                                </span>
                            </label>
                            <p class="text-xs text-red-600 font-semibold mt-1 validate-msg"></p>
                        </div>
                        <div class=" bg-white dark:bg-gray-700 edit-options hidden" x-show="edit">
                            <input
                                class="block font-medium text-sm text-gray-700 dark:text-gray-300 shadow bg-gray-50 rounded pr-8"
                                x-model="label">
                            <div class="w-full flex flex-wrap mt-4 gap-2">
                                <x-label size="xs" class="flex">
                                    <x-checkbox x-model="required" class="mr-1"></x-checkbox> Obligatorio
                                </x-label>
                                <x-label size="xs" class="flex">
                                    <x-checkbox x-model="disabled" class="mr-1"></x-checkbox> Deshabilitado
                                </x-label>
                                <x-label size="xs" class="flex">
                                    <x-checkbox x-model="multiple" class="mr-1"></x-checkbox> Múltiple
                                </x-label>
                            </div>
                        </div>
                        <x-form-builder-buttons />
                    </div>
                </li> --}}
                <li id="item-radio" class="drag-and-drop__item dark:bg-gray-700"
                    :class="{ 'drag-and-drop__item--dragging': dragging }"
                    x-on:dragstart.self="dragging = true;event.dataTransfer.effectAllowed='move';event.dataTransfer.setData('text/plain', event.target.id);"
                    x-on:dragend="dragging = false" x-data="{ dragging: false }" draggable="true">
                    <div class="w-full mb-3" data-type="radio" x-ref="parent"
                        x-data="{label: 'Botón de opción' , edit: false, required: false, disabled: true, readonly: false, options:[], text: '', value: ''}">
                        <div x-show="!edit" class="w-full">
                            <x-label x-text="label"></x-label>
                            <div class="flex flex-wrap gap-3 mt-2">
                                <template x-for="(item,index) in options">
                                    <x-label class="flex">
                                    <x-checkbox type="radio" x-bind:value="item.value" x-model="value" x-bind:checked="item.value==value"  x-bind:disabled="disabled" x-bind:readonly="readonly"
                                    x-bind:data-rules="required ? `['required']` : `[]`" x-bind:id="$refs.parent.id+'_'+index" x-bind:name="$refs.parent.id"
                                    x-bind:data-server-errors='required ? `[]` : `[]`'></x-checkbox>
                                    <span x-text="item.text"></span>
                                    </x-label>
                                </template>
                            </div>
                            <p class="text-xs text-red-600 font-semibold mt-1 validate-msg"></p>
                        </div>
                        <div class=" bg-white dark:bg-gray-700 edit-options hidden" x-show="edit">
                            <input
                                class="block font-medium text-sm text-gray-700 dark:text-gray-300 shadow bg-gray-50 rounded pr-8"
                                x-model="label">
                            <div class="w-full flex flex-wrap mt-4 gap-2">
                                <x-label size="xs" class="flex">
                                    <x-checkbox x-model="required" class="mr-1"></x-checkbox> Obligatorio
                                </x-label>
                                <x-label size="xs" class="flex">
                                    <x-checkbox x-model="disabled" class="mr-1"></x-checkbox> Deshabilitado
                                </x-label>
                                <x-label size="xs" class="flex">
                                    <x-checkbox x-model="readonly" class="mr-1"></x-checkbox> Solo lectura
                                </x-label>
                                <div class="w-full relative">
                                    <x-label size="xs">Opciones</x-label>
                                    <div class="gap-2 flex-wrap flex w-full">
                                        <input
                                            class="block font-medium text-xs p-1 text-gray-700 dark:text-gray-300 shadow bg-gray-50 rounded"
                                            x-model="text" placeholder="Opción">
                                        <input
                                            class="block font-medium text-xs p-1 text-gray-700 dark:text-gray-300 shadow bg-gray-50 rounded"
                                            x-model="value" placeholder="Valor">
                                        <x-button class="shadow-md absolute r-0 t-0 mr-1" color="green" size="icon"
                                            rounded="full" x-show="edit"
                                            x-on:click="options.push({text:text, value:value}); text=''; value=''; $dispatch('format-change');">
                                            <x-icon-plus class="h-3"/>
                                        </x-button>
                                    </div>
                                    <template x-for="(item, index) in options">
                                        <div class="inline">
                                            <span class="text-xs" x-text="item.value+ ' - ' +item.text + '. '"></span>
                                            <x-button rounded="full" class="transform scale-50 shado" color="red"
                                                size="icon" x-on:click="options.splice(index, 1);">
                                                <x-icon-times class="h-3"/>
                                            </x-button>
                                        </div>
                                    </template>

                                </div>

                            </div>
                        </div>
                        <x-form-builder-buttons />
                    </div>
                </li>
            </ul>
        </div>
    </div>
    <div class="drag-and-drop__divider dark:text-gray-200">⇄</div>
    <div class="drag-and-drop__container drag-and-drop__container--to shadow">
        <h3
            class="text-sm font-bold tracking-wide text-left text-gray-700 border-b dark:border-gray-600 bg-gray-50 dark:text-gray-200 dark:bg-gray-600 px-3 py-2 relative">
            Plantilla
            <div class="absolute r-0 t-0 b-0 mt-1 mr-2">
                <x-button class="shadow-md" color="orange" size="icon" rounded="full"
                    x-on:click="resetFormat($dispatch)" title="Reiniciar formato">
                    <x-icon-sync-alt class="h-3"/>
                </x-button>
                <x-button class="shadow-md" color="blue" size="icon" rounded="full"
                    x-on:click="saveFormat();$dispatch('notice', {
                        type: 'success',
                        title: LANG['global.successful'],
                        text: 'Plantilla guardada',
                    });" title='Guardar formato'>
                    <x-icon-save class="h-3"/>
                </x-button>
            </div>
        </h3>
        <div class="drag-and-drop__items p-5 dark:bg-gray-700" id="form-preview"
            :class="{ 'drag-and-drop__items--adding': adding }" x-on:drop="adding = false" x-on:drop.prevent="drop(event,'{{ $id }}')
            " x-on:dragover.prevent="adding = true" x-on:dragleave.prevent="adding = false">
        </div>
    </div>
</div>
