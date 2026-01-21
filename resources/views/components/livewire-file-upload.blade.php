@props([
    'wire:model' => null,
    'column' => '',
    'label' => 'Upload Files',
    'multiple' => false,
    'accept' => 'image/*',
    'required' => false,
    'hint' => 'Drag & drop files here or click to browse',
    'existing' => null,
])

@php
    $inputId = 'file_' . uniqid();
    $wireModel = $attributes->wire('model')->value();
@endphp

<div class="mb-4" wire:ignore>
    <label class="font-medium mb-1 block">{{ $label }}</label>
    <div class="drag-drop-area border-2 border-dashed border-gray-300 rounded-lg p-6 text-gray-400 text-center cursor-pointer relative hover:border-blue-400 transition-all duration-300"
        data-input="{{ $inputId }}" data-wire-model="{{ $wireModel }}" style="min-height: 200px;">

        <div class="dropzone-placeholder" @if ($existing) style="display: none;" @endif>
            <i class="fa fa-cloud-upload fa-3x mb-3 text-gray-400"></i>
            <p class="mb-1 font-semibold text-gray-600">{{ $hint }}</p>
            <small class="text-gray-500">Supported: {{ $accept ?? 'All files' }}</small>
        </div>

        @if ($existing)
            <div class="existing-image-preview">
                <div class="relative group inline-block">
                    <img src="{{ asset('storage/' . $existing) }}"
                        class="w-36 h-36 object-cover rounded-lg border-2 border-gray-200">
                </div>
            </div>
        @endif

        <div class="file-preview-grid grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3 mt-3" style="display: none;">
        </div>

        <input type="file" id="{{ $inputId }}" wire:model="{{ $column }}" class="hidden"
            {{ $multiple ? 'multiple' : '' }} {{ $required ? 'required' : '' }} accept="{{ $accept }}">
    </div>

    {{-- Validation errors --}}
    @error($wireModel)
        <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
    @enderror
    @if ($multiple)
        @error($wireModel . '.*')
            <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
        @enderror
    @endif
</div>

@once
    @push('custom-scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                initializeFileUpload()
            })

            document.addEventListener('livewire:navigated', function() {
                initializeFileUpload()
            })

            function initializeFileUpload() {
                document.querySelectorAll('.drag-drop-area').forEach(area => {
                    if (area.dataset.initialized) return
                    area.dataset.initialized = 'true'

                    const input = document.getElementById(area.dataset.input)
                    const wireModel = area.dataset.wireModel
                    const preview = area.querySelector('.file-preview-grid')
                    const placeholder = area.querySelector('.dropzone-placeholder')
                    const existingPreview = area.querySelector('.existing-image-preview')
                    const isMultiple = input.hasAttribute('multiple')
                    let filesArray = []

                    // Click to select
                    area.addEventListener('click', e => {
                        if (!e.target.closest('.remove-file')) {
                            input.click()
                        }
                    })

                    // Drag over / leave
                    area.addEventListener('dragover', e => {
                        e.preventDefault()
                        area.classList.add('border-blue-500', 'bg-blue-50')
                    })
                    area.addEventListener('dragleave', () => {
                        area.classList.remove('border-blue-500', 'bg-blue-50')
                    })

                    // Drop files
                    area.addEventListener('drop', e => {
                        e.preventDefault()
                        area.classList.remove('border-blue-500', 'bg-blue-50')
                        addFiles(e.dataTransfer.files)
                    })

                    // Input change
                    input.addEventListener('change', () => {
                        addFiles(input.files)
                    })

                    // Add files
                    function addFiles(newFiles) {
                        if (isMultiple) {
                            Array.from(newFiles).forEach(file => {
                                if (!filesArray.some(f => f.name === file.name && f.size === file.size)) {
                                    filesArray.push(file)
                                }
                            })
                        } else {
                            filesArray = Array.from(newFiles).slice(0, 1)
                        }
                        updateLivewire()
                        renderFiles()
                    }

                    // Update Livewire property
                    function updateLivewire() {
                        if (!wireModel) return

                        const componentEl = area.closest('[wire\\:id]')
                        const component = componentEl ? Livewire.find(componentEl.getAttribute('wire:id')) : null
                        if (!component) return

                        if (isMultiple) {
                            component.upload(wireModel, filesArray, () => {
                                // Upload finished
                            }, () => {
                                // Upload errored
                            }, (event) => {
                                // Progress callback (optional)
                            })
                        } else if (filesArray.length > 0) {
                            component.upload(wireModel, filesArray[0], () => {
                                // Upload finished
                            }, () => {
                                // Upload errored
                            })
                        }
                    }

                    // Render previews
                    function renderFiles() {
                        preview.innerHTML = ''
                        if (filesArray.length) {
                            placeholder.style.display = 'none'
                            if (existingPreview) existingPreview.style.display = 'none'
                            preview.style.display = 'grid'
                            filesArray.forEach((file, index) => {
                                const col = document.createElement('div')
                                const isImage = file.type.startsWith('image/')
                                if (isImage) {
                                    const reader = new FileReader()
                                    reader.onload = e => {
                                        col.innerHTML = `
                                <div class="relative group">
                                    <img src="${e.target.result}" class="w-full h-36 object-cover rounded-lg border-2 border-gray-200">
                                    <button type="button" class="absolute top-1 right-1 bg-red-500 hover:bg-red-600 text-white rounded-full w-6 h-6 flex items-center justify-center text-xs remove-file transition-all" data-index="${index}">
                                        <i class="fa fa-times"></i>
                                    </button>
                                    <div class="truncate text-xs mt-1 px-1 text-gray-600">${file.name}</div>
                                </div>`
                                        attachRemoveListener(col.querySelector('.remove-file'))
                                    }
                                    reader.readAsDataURL(file)
                                } else {
                                    col.innerHTML = `
                            <div class="relative border-2 border-gray-200 rounded-lg p-3 text-center h-36 flex flex-col justify-center items-center group">
                                <i class="fa fa-file fa-3x text-gray-400 mb-2"></i>
                                <button type="button" class="absolute top-1 right-1 bg-red-500 hover:bg-red-600 text-white rounded-full w-6 h-6 flex items-center justify-center text-xs remove-file transition-all" data-index="${index}">
                                    <i class="fa fa-times"></i>
                                </button>
                                <div class="truncate text-xs mt-1 text-gray-600 max-w-full">${file.name}</div>
                            </div>`
                                    attachRemoveListener(col.querySelector('.remove-file'))
                                }
                                preview.appendChild(col)
                            })
                        } else {
                            if (existingPreview) {
                                existingPreview.style.display = 'block'
                            } else {
                                placeholder.style.display = 'block'
                            }
                            preview.style.display = 'none'
                        }
                    }

                    function attachRemoveListener(btn) {
                        btn.addEventListener('click', e => {
                            e.stopPropagation()
                            filesArray.splice(parseInt(btn.dataset.index), 1)
                            updateLivewire()
                            renderFiles()
                        })
                    }
                })
            }
        </script>
    @endpush
@endonce
