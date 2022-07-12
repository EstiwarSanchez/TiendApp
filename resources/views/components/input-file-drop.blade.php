@props(['name' => '', 'id'=>'', 'default' => 'null' , 'imageName' => 'null'])
<div {{ $attributes->merge(['class' => 'p-3 max-w-xs w-full square']) }} x-data='{imageName: {{$imageName!= 'null' ? "`$imageName`" : 'null'}}, error: 0, imagePreview: {{$default!= 'null' ? "`data:image/".pathinfo($imageName, PATHINFO_EXTENSION).";base64,$default`" : 'null'}}, drag: false}'
    x-on:saved.window="
        imagePreview=null;
        imageName=null;
        drag=false;
        $refs['{{$id}}'].value = ''" x-init="updateSqueare()">
    <div :class="{ 'hover:bg-psi-blue-600 dark:hover:bg-psi-blue-600 dark:hover:border-gray-100 hover:border-gray-100 hover:text-white bg-opacity-25 dark:bg-opacity-50': !imagePreview&&!drag, 'gradient border-gray-100 text-white': drag, 'bg-gray-100 dark:bg-gray-600 border-psi-orange-600 dark:border-psi-orange-300 text-gray-400': !drag  }"
        class="relative truncate transition-all block duration-200 cursor-pointer border-dashed  min-h-full appearance-none border-2 rounded w-full  leading-tight focus:shadow-sm focus:outline-none"
        x-on:dragenter="drag=true" x-on:dragover="drag=true" x-on:dragleave="drag=false">
        <span class="absolute right-0 top-0 mr-1 mt-1 z-10" x-show="imagePreview">
            <span
                class="fa fa-times-circle cancel-img transition-all duration-200 shadow-lg rounded-full text-psi-blue-300 hover:text-white text-xl"
                x-on:click="
                    imagePreview=null;
                    imageName=null;
                    drag=false;
                    $refs['{{$id}}'].value = ''">
            </span>
        </span>
        <div
            class="h-full w-full flex absolute cursor-pointer left-0 right-0 top-0 bottom-0 break-words text-center p-4 whitespace-pre-wrap">
            <span class="m-auto lg:text-2xl sm:text-xl text-lg" x-show="!imagePreview">Seleccione una imagen</span>
            <div x-show="imagePreview" class="h-full w-full flex">
                <span wire:loading.flex wire:target="image" class="m-auto"><span
                        class="fa fa-spinner fa-spin text-4xl "></span></span>
                <div wire:loading.remove wire:target="image" class="w-full h-full m-auto shadow flex">
                    <span class="block rounded w-full h-full m-auto shadow"
                        x-bind:style="'background-size: cover; background-repeat: no-repeat; background-position: center center; background-image: url(\'' + imagePreview + '\');'">
                    </span>
                </div>
            </div>
        </div>
        <input type="file" id="{{$id}}" x-show="!imagePreview"
            class="opacity-0 absolute w-full cursor-pointer left-0 right-0 top-0 bottom-0" accept=".png,.jpeg,.jpg"
            name="{{$name}}" x-ref="{{$id}}" x-on:change="
                imageName = typeof($refs['{{$id}}'].files[0]) === 'undefined' ? null : $refs['{{$id}}'].files[0].name;
                if(imageName!=null){
                    error=validateFile($refs['{{$id}}']);
                    if(!error){
                        const reader = new FileReader();
                        reader.onload = (e) => {
                            imagePreview = e.target.result;
                            drag = true;
                        };
                        reader.readAsDataURL($refs['{{$id}}'].files[0]);
                    }else{
                        $dispatch('notice', {type: 'error', text: '{{__('The image must be in jpeg, jpg or png format and must not be larger than 2048 kilobytes.')}}'})
                        imagePreview=null;
                        imageName=null;
                        drag=false;
                        $refs['{{$id}}'].value = ''
                    }
                }else{
                    imagePreview=null;
                    imageName=null;
                    drag=false;
                    $refs['{{$id}}'].value = ''
                }
            " />
    </div>
    <div x-show="imagePreview" class="text-xs leading-tight text-gray-400 dark:text-gray-500 text-center">
        La imagen original no se recortará, esto es solo una vista previa.
    </div>
</div>

