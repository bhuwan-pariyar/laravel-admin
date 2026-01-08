{{-- resources/views/components/file-upload.blade.php --}}
@props([
    'name' => 'files',
    'multiple' => true,
    'accept' => 'image/*',
    'maxSize' => 5, // MB
    'existingFiles' => [],
    'label' => 'Upload Files',
])

<div x-data="fileUpload({
    multiple: {{ $multiple ? 'true' : 'false' }},
    maxSize: {{ $maxSize }},
    existingFiles: @js($existingFiles)
})" class="w-full">

    @if ($label)
        <label class="block text-base font-semibold text-slate-800 mb-3">
            {{ $label }}
        </label>
    @endif

    <!-- Beautiful Dropzone with Images Inside -->
    <div @dragover.prevent="dragOver = true" @dragleave.prevent="dragOver = false" @drop.prevent="handleDrop($event)"
        @click="$refs.fileInput.click()"
        :class="dragOver ? 'border-blue-500 bg-gradient-to-br from-blue-50 to-indigo-50' :
            'border-slate-300 hover:border-blue-400 hover:bg-gradient-to-br hover:from-slate-50 hover:to-blue-50'"
        class="relative border-2 border-dashed rounded-2xl p-8 cursor-pointer transition-all duration-300 min-h-[280px] bg-white">
        <input x-ref="fileInput" type="file" :multiple="multiple" accept="{{ $accept }}"
            @change="handleFileSelect($event)" class="hidden">

        <!-- Image Grid Inside Dropzone -->
        <div x-show="files.length > 0" class="mb-6">
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-3">
                <template x-for="(file, index) in files" :key="file.id">
                    <div class="relative group">
                        <!-- Image Preview -->
                        <div
                            class="aspect-square rounded-xl overflow-hidden bg-slate-100 border-2 border-slate-200 shadow-sm hover:shadow-md transition-all">
                            <img :src="file.preview" :alt="file.name" class="w-full h-full object-cover">
                        </div>

                        <!-- Hover Overlay -->
                        <div
                            class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-all rounded-xl flex flex-col justify-end p-2">
                            <p class="text-white text-xs font-medium truncate" x-text="file.name"></p>
                            <p class="text-white/80 text-xs" x-text="formatFileSize(file.size)"></p>
                        </div>

                        <!-- Remove Button -->
                        <button @click.stop.prevent="removeFile(index)" type="button"
                            class="absolute -top-2 -right-2 w-7 h-7 bg-red-500 hover:bg-red-600 text-white rounded-full flex items-center justify-center shadow-lg transform hover:scale-110 transition-all z-10">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>

                        <!-- Hidden input for form submission -->
                        <input type="hidden" :name="`${multiple ? '{{ $name }}[]' : '{{ $name }}'}`"
                            :value="file.base64">
                    </div>
                </template>
            </div>

            <!-- Divider Line -->
            <div class="mt-6 mb-4 border-t-2 border-dashed border-slate-200"></div>
        </div>

        <!-- Upload Icon and Text -->
        <div class="text-center" :class="files.length > 0 ? '' : 'py-12'">
            <!-- Cloud Upload Icon -->
            <div class="mb-4 flex justify-center">
                <div :class="dragOver ? 'bg-gradient-to-br from-blue-500 to-indigo-600 scale-110' :
                    'bg-gradient-to-br from-slate-400 to-slate-500'"
                    class="w-20 h-20 rounded-full flex items-center justify-center transform transition-all duration-300 shadow-lg">
                    <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                    </svg>
                </div>
            </div>

            <div class="space-y-2">
                <h3 class="text-xl font-bold text-slate-800">
                    <span x-show="!dragOver">Drop your images here</span>
                    <span x-show="dragOver" class="text-blue-600">Release to upload</span>
                </h3>
                <p class="text-slate-600 font-medium">
                    or <span class="text-blue-600 hover:text-blue-700 font-semibold">browse</span> from your device
                </p>
                <p class="text-sm text-slate-500">
                    Supports: JPG, PNG, GIF • Max {{ $maxSize }}MB per file
                </p>
            </div>

            <!-- File Count Badge -->
            <div x-show="files.length > 0"
                class="mt-6 inline-flex items-center gap-2 bg-gradient-to-r from-blue-500 to-indigo-600 text-white px-4 py-2 rounded-full shadow-md">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span class="font-semibold" x-text="files.length"></span>
                <span x-text="files.length === 1 ? 'file selected' : 'files selected'"></span>
            </div>
        </div>
    </div>

    <!-- Action Buttons -->
    <div x-show="files.length > 0" class="mt-4 flex items-center gap-3">
        <button @click.prevent="$refs.fileInput.click()" type="button"
            class="px-5 py-2.5 bg-white border-2 border-slate-300 text-slate-700 rounded-xl font-medium hover:border-blue-500 hover:text-blue-600 hover:bg-blue-50 transition-all shadow-sm hover:shadow">
            <span class="flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Add More
            </span>
        </button>

        <button @click.prevent="clearAll()" type="button"
            class="px-5 py-2.5 bg-white border-2 border-red-200 text-red-600 rounded-xl font-medium hover:bg-red-50 hover:border-red-300 transition-all shadow-sm hover:shadow">
            <span class="flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                </svg>
                Clear All
            </span>
        </button>

        <div class="ml-auto text-sm text-slate-600 font-medium">
            Total: <span class="text-slate-800 font-semibold" x-text="getTotalSize()"></span>
        </div>
    </div>

    <!-- Error Messages -->
    <div x-show="error" x-transition class="mt-4 p-4 bg-red-50 border-l-4 border-red-500 rounded-lg">
        <div class="flex items-start gap-3">
            <svg class="w-5 h-5 text-red-500 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <p class="text-sm text-red-700 font-medium" x-text="error"></p>
        </div>
    </div>
</div>

@once
    @push('scripts')
        <script>
            function fileUpload(config) {
                return {
                    files: [],
                    dragOver: false,
                    error: '',
                    multiple: config.multiple,
                    maxSize: config.maxSize * 1024 * 1024,

                    init() {
                        if (config.existingFiles && config.existingFiles.length > 0) {
                            this.files = config.existingFiles.map((file, index) => ({
                                id: `existing-${index}`,
                                name: file.name || `Image ${index + 1}`,
                                preview: file.url,
                                size: file.size || 0,
                                existing: true,
                                base64: file.url
                            }));
                        }
                    },

                    handleDrop(e) {
                        this.dragOver = false;
                        const droppedFiles = Array.from(e.dataTransfer.files);
                        this.processFiles(droppedFiles);
                    },

                    handleFileSelect(e) {
                        const selectedFiles = Array.from(e.target.files);
                        this.processFiles(selectedFiles);
                    },

                    async processFiles(newFiles) {
                        this.error = '';

                        for (const file of newFiles) {
                            if (file.size > this.maxSize) {
                                this.error = `File "${file.name}" exceeds maximum size of ${config.maxSize}MB`;
                                return;
                            }
                        }

                        if (!this.multiple) {
                            this.files = [];
                        }

                        for (const file of newFiles) {
                            try {
                                const base64 = await this.fileToBase64(file);
                                const preview = await this.createPreview(file);

                                this.files.push({
                                    id: Math.random().toString(36).substr(2, 9),
                                    name: file.name,
                                    size: file.size,
                                    preview: preview,
                                    base64: base64,
                                    existing: false
                                });
                            } catch (err) {
                                this.error = `Error processing file "${file.name}"`;
                            }
                        }
                    },

                    fileToBase64(file) {
                        return new Promise((resolve, reject) => {
                            const reader = new FileReader();
                            reader.readAsDataURL(file);
                            reader.onload = () => resolve(reader.result);
                            reader.onerror = error => reject(error);
                        });
                    },

                    createPreview(file) {
                        return new Promise((resolve, reject) => {
                            if (file.type.startsWith('image/')) {
                                const reader = new FileReader();
                                reader.readAsDataURL(file);
                                reader.onload = () => resolve(reader.result);
                                reader.onerror = error => reject(error);
                            } else {
                                resolve('/placeholder-icon.png');
                            }
                        });
                    },

                    removeFile(index) {
                        this.files.splice(index, 1);
                        this.error = '';
                    },

                    clearAll() {
                        this.files = [];
                        this.error = '';
                        this.$refs.fileInput.value = '';
                    },

                    formatFileSize(bytes) {
                        if (bytes === 0) return '0 B';
                        const k = 1024;
                        const sizes = ['B', 'KB', 'MB', 'GB'];
                        const i = Math.floor(Math.log(bytes) / Math.log(k));
                        return Math.round((bytes / Math.pow(k, i)) * 100) / 100 + ' ' + sizes[i];
                    },

                    getTotalSize() {
                        const total = this.files.reduce((sum, file) => sum + file.size, 0);
                        return this.formatFileSize(total);
                    }
                }
            }
        </script>
    @endpush
@endonce
