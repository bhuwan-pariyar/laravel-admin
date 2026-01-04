@props(['disabled' => false, 'type' => 'text'])

<div class="relative">
    <input type="{{ $type }}" {{ $disabled ? 'disabled' : '' }} placeholder=" " {!! $attributes->merge([
        'class' =>
            'peer w-full rounded-sm border border-gray-300 bg-transparent px-3 py-1 text-sm text-gray-900 outline-none transition-all duration-200 placeholder:text-transparent focus:border-blue-500 focus:ring-1 focus:ring-blue-500/50 disabled:bg-gray-100 disabled:text-gray-400 disabled:cursor-not-allowed dark:border-gray-600 dark:text-gray-100 dark:focus:border-blue-400 dark:focus:ring-blue-400/50 dark:disabled:bg-gray-800',
    ]) !!}>

    <label for="{{ $attributes->get('id') }}"
        class="absolute left-2.5 top-0 -translate-y-1/2 bg-gray-100 dark:bg-gray-900 px-1.5 text-xs text-gray-500 dark:text-gray-400 transition-all duration-200 pointer-events-none origin-left peer-placeholder-shown:top-1/2 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:text-sm peer-placeholder-shown:bg-transparent peer-focus:top-0 peer-focus:-translate-y-1/2 peer-focus:text-xs peer-focus:bg-gray-100 peer-focus:text-blue-500 dark:peer-focus:bg-gray-900 dark:peer-focus:text-blue-400 dark:peer-placeholder-shown:bg-transparent">
        {{ $slot }}
    </label>
</div>
