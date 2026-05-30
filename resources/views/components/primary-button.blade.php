@props(['type' => 'submit', 'disabled' => false])

<button type="{{ $type }}" {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge([
    'class' =>
        'inline-flex items-center justify-center rounded-lg bg-gradient-to-r from-indigo-500 to-blue-600 px-4 py-2.5 text-xs font-semibold uppercase tracking-wider text-white transition duration-200 ease-in-out hover:from-indigo-600 hover:to-blue-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-50 disabled:cursor-not-allowed hover:shadow-md transform active:scale-[0.98] hover:scale-[1.01]',
]) !!}>
    {{ $slot }}
</button>
