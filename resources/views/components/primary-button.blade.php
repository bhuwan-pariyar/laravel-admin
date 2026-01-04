@props(['type' => 'submit', 'disabled' => false])

<button type="{{ $type }}" {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge([
    'class' =>
        'inline-block rounded-sm bg-primary px-4 pb-2 pt-2 text-xs font-medium uppercase leading-normal text-white transition duration-150 ease-in-out hover:bg-primary-accent-300 hover:shadow-primary-2 focus:bg-primary-accent-300 focus:shadow-primary-2 focus:outline-none focus:ring-0 active:bg-primary-600 active:shadow-primary-2 dark:shadow-black/30 dark:hover:shadow-dark-strong dark:focus:shadow-dark-strong dark:active:shadow-dark-strong',
    'data-twe-ripple-init' => 'true',
    'data-twe-ripple-color' => 'light',
]) !!}>
    {{ $slot }}
</button>
