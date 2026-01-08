@props([
    'type' => 'button',
    'variant' => 'primary', // primary, secondary, danger, success, warning, outline
    'size' => 'md', // sm, md, lg
    'disabled' => false,
    'loading' => false,
    'icon' => null,
    'iconPosition' => 'left', // left, right
    'fullWidth' => false,
    'href' => null,
])

@php
    $baseClasses =
        'inline-flex items-center justify-center font-medium rounded-sm transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 disabled:opacity-50 disabled:cursor-not-allowed';

    // Size variations
    $sizeClasses = [
        'sm' => 'px-3 py-1 text-sm',
        'md' => 'px-4 py-1.5 text-base',
        'lg' => 'px-6 py-3 text-lg',
    ];

    // Variant styles
    $variantClasses = [
        'primary' => 'bg-blue-400 text-white hover:bg-blue-500 focus:ring-blue-500 active:bg-blue-600',
        'secondary' => 'bg-gray-400 text-white hover:bg-gray-500 focus:ring-gray-500 active:bg-gray-600',
        'danger' => 'bg-red-400 text-white hover:bg-red-500 focus:ring-red-500 active:bg-red-600',
        'success' => 'bg-green-400 text-white hover:bg-green-500 focus:ring-green-500 active:bg-green-600',
        'warning' => 'bg-yellow-400 text-white hover:bg-yellow-600 focus:ring-yellow-400 active:bg-yellow-600',
        'slate' => 'bg-slate-700 text-white hover:bg-slate-800 focus:ring-slate-800 active:bg-slate-900',
        'outline' =>
            'bg-transparent border-2 border-blue-400 text-blue-400 hover:bg-blue-50 focus:ring-blue-500 active:bg-blue-100',
    ];

    $classes = implode(' ', [
        $baseClasses,
        $sizeClasses[$size] ?? $sizeClasses['md'],
        $variantClasses[$variant] ?? $variantClasses['primary'],
        $fullWidth ? 'w-full' : '',
    ]);
@endphp

@if ($href)
    {{-- Link button --}}
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>
        @if ($loading)
            <svg class="animate-spin -ml-1 mr-2 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none"
                viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4">
                </circle>
                <path class="opacity-75" fill="currentColor"
                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                </path>
            </svg>
        @elseif($icon && $iconPosition === 'left')
            <span class="mr-2">{!! $icon !!}</span>
        @endif

        {{ $slot }}

        @if ($icon && $iconPosition === 'right')
            <span class="ml-2">{!! $icon !!}</span>
        @endif
    </a>
@else
    {{-- Regular button --}}
    <button type="{{ $type }}" {{ $disabled || $loading ? 'disabled' : '' }}
        {{ $attributes->merge(['class' => $classes]) }}>
        @if ($loading)
            <svg class="animate-spin -ml-1 mr-2 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none"
                viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4">
                </circle>
                <path class="opacity-75" fill="currentColor"
                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                </path>
            </svg>
        @elseif($icon && $iconPosition === 'left')
            <span class="mr-2">{!! $icon !!}</span>
        @endif

        {{ $slot }}

        @if ($icon && $iconPosition === 'right')
            <span class="ml-2">{!! $icon !!}</span>
        @endif
    </button>
@endif
