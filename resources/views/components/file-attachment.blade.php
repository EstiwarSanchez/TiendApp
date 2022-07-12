@props(['invalid' => false, 'accept'=> '.zip,zip,application/zip,application/x-zip,application/x-zip-compressed' , 'name' => ''])
<div>
    <div
        x-data="drop_file_component()"
        @scan-result.window="proccessScan($event.detail,$dispatch)"
        @upload-result.window="proccessResult($event.detail,$dispatch)">
        <label
            class="dark:bg-opacity-5 {{$invalid ? 'invalid' : ''}} dark:bg-white transition-colors focus:ring focus:ring-opacity-50 border truncate cursor-pointer flex rounded-md py-2 text-sm shadow-sm text-gray-800 dark:text-gray-200 input-files"
            for="file" x-bind:class="dropingFile ? 'bg-gray-100 border-gray-500' : ''"
            x-on:drop="dropingFile = false"
            x-on:drop.prevent="
                handleFileDrop($event, $dispatch)
            "
            x-on:dragover.prevent="dropingFile = true"
            x-on:dragleave.prevent="dropingFile = false">
            <input id="file" x-ref="file" type="file" accept="{{$accept}}" name="{{$name}}" class="sr-only w-full"
                x-on:change="handleFileDrop($event, $dispatch);" wire:ignore>

            <span class="ml-2 flex">
                <svg fill="currentColor" class="text-psi-blue-600" height="18" viewBox="0 0 24 24" width="18"
                    xmlns="http://www.w3.org/2000/svg">
                    <path d="M0 0h24v24H0z" fill="none" />
                    <path d="M9 16h6v-6h4l-7-7-7 7h4zm-4 2h14v2H5z" />
                </svg>
                <span x-text="fileName ? fileName.map(file => file.name).join(', ') : 'Seleccione el archivo...'"></span>
            </span>
        </label>
        <div x-show.transition.700ms="isUploading" class="rounded h-4 shadow bg-gray-50 my-1 relative w-full">
            <div x-bind:style="'width:'+progress+'%'"
                class="to-psi-green-500 text-center from-psi-green-700 bg-gradient-to-r text-white h-full rounded text-xs font-semibold transition-all"
                x-text="'&nbsp;'+progress"></div>
        </div>
    </div>

    <script>
        window.drop_file_component = ()=> {
            return {
                files: null,
                fileName: null,
                isUploading: false,
                progress: 0,
                dropingFile: false,
                disabledForm(disabled = true){
                    document.getElementById('storeUpload').querySelectorAll('select, input, textarea, button').forEach(el=>{
                        el.disabled = disabled
                        if(el.tagName == 'SELECT'){
                            updateSelect(el.id,null,disabled)
                        }
                    })
                },
                handleFileDrop(e, $dispatch) {
                    var target = e.type == 'change' ? e.target : e.dataTransfer;
                    this.files = e.type == 'change' ? target.files : target.files;
                    this.fileName = Object.values(this.files);
                    var error = validateFile( target, [true, /\.(zip)$/i], [true, 600]);
                    if (error) {
                        $dispatch('notice', {
                            type: 'error',
                            title: LANG['Validation error'],
                            text: LANG['The file must be in .zip format and must not exceed 600MB (614400 kilobytes).']
                        })
                        this.$refs.file.value = ''
                        this.fileName = null
                    }else{

                        if (this.files.length > 0) {
                            this.isUploading = true;
                            @this.upload('file', this.files[0],
                                (uploadedFilename) => {
                                    console.log(uploadedFilename);
                                    window.Livewire.emit('scanFile');
                                    setTimeout(()=>{
                                        this.progress= 0;
                                    },310)
                                    this.disabledForm();
                                }, (error) => {
                                    console.log(error);
                                    this.isUploading = false;
                                    this.progress= 0;
                                    this.fileName= null;
                                    this.disabledForm(false)
                                }, (event) => {
                                    this.progress = event.detail.progress;
                                    if (this.progress==100) {
                                        scan = true;
                                        setTimeout(()=>{
                                            this.isUploading = false;
                                        },300)
                                    }
                                }
                            )
                        }else{
                            if (this.fileName != null || this.$refs.file.value != '') {
                                window.Livewire.emit('resetErrors');
                            }
                            this.$refs.file.value = ''
                            this.fileName = null
                        }
                    }
                },
                proccessScan(e, $dispatch){
                    scan = false;
                    this.disabledForm(false);
                    if (e.status) {
                        hasFile = true;
                        $dispatch('notice', {
                            type: 'success',
                            title: e.result,
                            text: e.message
                        });
                    }else{
                        this.$refs.file.value = ''
                        this.fileName = null
                        hasFile = false;
                        $dispatch('notice', {
                            type: 'error',
                            title: e.result,
                            text: e.message
                        });
                    }
                },
                proccessResult(e, $dispatch){
                    if (e.status) {
                        $dispatch('notice', {
                            type: 'success',
                            title: LANG['Successful process'],
                            text: e.message
                        });
                        resetForm('storeUpload')

                        setTimeout(() => {
                            var pass = e.pass;
                            var token = e.token || 0;
                            showModal('modal-file-pass')
                            document.getElementById('pass').innerHTML = `${pass}`;

                            setTimeout(() => {
                                if (token==1) {
                                    setTimeout(() => {
                                        checkTokenExpired()
                                    }, 180000);
                                }else{
                                    window.Livewire.emit('table-updated');
                                }
                                hideModal('modal-upload')
                            }, 100);
                        }, 400);
                    }else{
                        this.$refs.file.value = ''
                        this.fileName = null
                        $dispatch('notice', {
                            type: 'error',
                            title: e.message,
                            text: e.errors
                        });
                    }
                    this.disabledForm(false);
                }
            };
        }
    </script>
</div>
