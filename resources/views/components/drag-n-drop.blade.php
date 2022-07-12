@props(['previewFile' => null])
<div>
    @if ($previewFile)
    <div class="flex flex-wrap">
        <div class="w-16 mr-4 flex-shrink-0 shadow-xs rounded-lg">
            @if(collect(['jpg', 'png', 'jpeg', 'webp'])->contains(getExtension($previewFile)))
                <div class="relative pb-16 w-full overflow-hidden rounded-lg border border-gray-100">
                    <img src="{{ asset('storage/'.$previewFile) }}" class="w-full h-full absolute object-cover rounded-lg">
                </div>
            @else
                <div class="w-16 h-16 bg-gray-100 text-blue-500 flex items-center justify-center rounded-lg border border-gray-100">
                    <svg class="h-12 w-12" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
            @endif
        </div>
        <div class="truncate">
            <div class="text-sm font-medium truncate w-28 xxs:w-52 md:w-40">{{ basename($previewFile) }}</div>
            <div class="flex items-center space-x-1">
                <div class="text-xs text-gray-500">{{ bytesToHuman(Storage::size('public/'.$previewFile)) }}</div>
                <div class="text-gray-400 text-xs">&bull;</div>
                <div class="text-xs text-gray-500 uppercase">{{ getExtension($previewFile) }}</div>
            </div>
            <div class="text-xs font-medium truncate w-28 xxs:w-52 md:w-40">{{str(__('validation.attributes.'.$attributes->get('id')))->ucFirst() }}</div>
        </div>
    </div>
    @else
    <div wire:ignore x-data="{
        isUploading:false,
        progressPercent:0,
    }"  x-init="() => {
        const post = FilePond.create($refs.{{ $attributes->get('ref') ?? 'input' }});
        post.setOptions({
            allowMultiple: {{ $attributes->has('multiple') ? 'true' : 'false' }},
            server: {
                process:(fieldName, file, metadata, load, error, progress, abort, transfer, options) => {
                    isUploading=true;
                    progressPercent=0;
                    @this.upload('{{ $attributes->wire('model')->value }}', file, (fileName)=>{
                        load(fileName)
                        isUploading=false;
                    }, ()=>{
                        error('oh no');
                        isUploading=false;
                    }, (e)=>{
                        progress(e.lengthComputable, e.loaded, e.total);
                        progressPercent = e.detail.progress || 0;
                    })
                },
                revert: (filename, load) => {
                    @this.removeUpload('{{ $attributes->wire('model')->value }}', filename, load)
                },
            },
            allowImagePreview: {{ $attributes->has('allowImagePreview') ? 'true' : 'false' }},
            imagePreviewMaxHeight: {{ $attributes->has('imagePreviewMaxHeight') ? $attributes->get('imagePreviewMaxHeight') : '256' }},
            allowFileTypeValidation: {{ $attributes->has('allowFileTypeValidation') ? 'true' : 'false' }},
            acceptedFileTypes: {!! $attributes->get('acceptedFileTypes') ?? 'null' !!},
            allowFileSizeValidation: {{ $attributes->has('allowFileSizeValidation') ? 'true' : 'false' }},
            maxFileSize: {!! $attributes->has('maxFileSize') ? "'".$attributes->get('maxFileSize')."'" : 'null' !!}
        });
    }">
        <input type="file" x-ref="{{ $attributes->get('ref') ?? 'input' }}" />
        <div x-show="isUploading" class="relative w-full px-4"
            x-transition.opacity.duration.300ms>
            <div class="w-full overflow-hidden rounded-b-xl bg-app-blue-50 dark:bg-app-gray-blue-900 shadow h-3.5">
                <div class="shadow-inner w-full">
                    <div class="bg-emerald-600 text-center text-white font-medium text-xxs h-full shadow-inner" x-bind:style="{'width':`${progressPercent}%`}" x-text="`${progressPercent}%`"></div>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
@push('styles')
    @once
        <link href="{{ asset('css/filepond.css') }}" rel="stylesheet">
    @endonce
@endpush

@push('scripts')
    @once
        <script src="{{ asset('js/filepond.js')}}"></script>
    @endonce
@endpush
