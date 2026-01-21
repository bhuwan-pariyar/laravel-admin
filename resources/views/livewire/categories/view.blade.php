<div class="p-6">
    <!-- Category Header -->
    <div class="flex items-center gap-4 pb-4 border-b border-slate-200">
        @if ($category->image)
            <img src="{{ asset('storage/' . $category->image) }}" alt="Category Image"
                class="w-16 h-16 rounded-lg shadow-lg object-cover">
        @else
            <div class="w-16 h-16 rounded-lg bg-slate-200 flex items-center justify-center shadow-lg">
                <svg class="w-8 h-8 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
            </div>
        @endif
        <div class="flex-1">
            <h3 class="text-xl font-bold text-slate-900">{{ $category->name }}</h3>
            <p class="text-sm text-slate-500">{{ $category->slug }}</p>
        </div>
        <div>
            @php
                $statusColors = [
                    'active' => 'bg-green-100 text-green-800 border-green-200',
                    'inactive' => 'bg-slate-100 text-slate-800 border-slate-200',
                ];
                $status = $category->status == '1' ? 'active' : 'inactive';
            @endphp
            <span class="px-3 py-0.5 text-xs font-semibold rounded-full border {{ $statusColors[$status] }}">
                {{ ucfirst($status) }}
            </span>
        </div>
    </div>

    <!-- Category Details -->
    <div class="mt-6 space-y-4">
        <!-- ID -->
        <div class="flex items-center justify-between py-3 border-b border-slate-100">
            <div class="flex items-center gap-2">
                <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14" />
                </svg>
                <span class="text-sm font-medium text-slate-600">Category ID</span>
            </div>
            <span class="text-sm font-semibold text-slate-900">#{{ $category->id }}</span>
        </div>

        <!-- Name -->
        <div class="flex items-center justify-between py-3 border-b border-slate-100">
            <div class="flex items-center gap-2">
                <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                </svg>
                <span class="text-sm font-medium text-slate-600">Name</span>
            </div>
            <span class="text-sm text-slate-900">{{ $category->name }}</span>
        </div>

        <!-- Slug -->
        <div class="flex items-center justify-between py-3 border-b border-slate-100">
            <div class="flex items-center gap-2">
                <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" />
                </svg>
                <span class="text-sm font-medium text-slate-600">Slug</span>
            </div>
            <span class="text-sm text-slate-900 font-mono bg-slate-50 px-2 py-1 rounded">{{ $category->slug }}</span>
        </div>

        <!-- Parent Category -->
        <div class="flex items-center justify-between py-3 border-b border-slate-100">
            <div class="flex items-center gap-2">
                <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z" />
                </svg>
                <span class="text-sm font-medium text-slate-600">Parent Category</span>
            </div>
            @if ($category->parent)
                <span class="text-sm text-slate-900">{{ $category->parent->name }}</span>
            @else
                <span class="text-xs text-slate-400">Root Category</span>
            @endif
        </div>

        <!-- Description -->
        @if ($category->description)
            <div class="py-3 border-b border-slate-100">
                <div class="flex items-center gap-2 mb-2">
                    <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h7" />
                    </svg>
                    <span class="text-sm font-medium text-slate-600">Description</span>
                </div>
                <p class="text-sm text-slate-700 ml-7">{{ $category->description }}</p>
            </div>
        @endif

        <!-- Created At -->
        <div class="flex items-center justify-between py-3 border-b border-slate-100">
            <div class="flex items-center gap-2">
                <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                <span class="text-sm font-medium text-slate-600">Created At</span>
            </div>
            <div class="text-right">
                <p class="text-sm font-medium text-slate-900">{{ $category->created_at->format('M d, Y') }}</p>
                <p class="text-xs text-slate-500">{{ $category->created_at->format('h:i A') }}</p>
            </div>
        </div>

        <!-- Last Updated -->
        <div class="flex items-center justify-between py-3 border-b border-slate-100">
            <div class="flex items-center gap-2">
                <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                </svg>
                <span class="text-sm font-medium text-slate-600">Last Updated</span>
            </div>
            <div class="text-right">
                <p class="text-sm font-medium text-slate-900">{{ $category->updated_at->format('M d, Y') }}</p>
                <p class="text-xs text-slate-500">{{ $category->updated_at->format('h:i A') }}</p>
            </div>
        </div>

        <!-- Children Categories -->
        @if ($category->children->count() > 0)
            <div class="py-3">
                <div class="flex items-center gap-2 mb-3">
                    <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                    </svg>
                    <span class="text-sm font-medium text-slate-600">Subcategories
                        ({{ $category->children->count() }})</span>
                </div>
                <div class="ml-7 flex flex-wrap gap-2">
                    @foreach ($category->children as $child)
                        <a href="{{ route('categories.show', $child->id) }}"
                            class="inline-flex items-center px-3 py-1 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-full text-xs font-medium transition-colors">
                            {{ $child->name }}
                        </a>
                    @endforeach
                </div>
            </div>
        @endif
    </div>

    <!-- Actions -->
    <div class="flex items-center justify-end gap-3 mt-6 pt-4 border-t border-slate-200">
        <a href="{{ route('categories.list') }}"
            class="px-4 py-1 bg-slate-200 text-slate-700 rounded-sm text-sm font-medium hover:bg-slate-300 transition-colors">
            <i class="fa-solid fa-arrow-left"></i>&nbsp;
            Back
        </a>
    </div>
</div>
