@props(['disabled' => false, 'label' => ''])

<div class="relative">
    <select {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge([
        'class' =>
            'peer w-full rounded-sm border border-gray-300 bg-transparent px-3 py-1 text-sm text-gray-900 outline-none transition-all duration-200 appearance-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500/50 disabled:bg-gray-100 disabled:text-gray-400 disabled:cursor-not-allowed dark:border-gray-600 dark:text-gray-900 dark:focus:border-blue-400 dark:focus:ring-blue-400/50 dark:disabled:bg-gray-800',
    ]) !!}>
        {{ $slot }}
    </select>

    <label for="{{ $attributes->get('id') }}"
        class="absolute left-2.5 top-0 -translate-y-1/2 bg-white dark:bg-gray-900 px-1.5 text-xs text-gray-500 dark:text-gray-400 transition-all duration-200 pointer-events-none origin-left peer-focus:text-blue-500 dark:peer-focus:text-blue-400">
        {{ $label }}
    </label>
</div>
