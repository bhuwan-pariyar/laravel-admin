@props(['disabled' => false, 'checked' => false, 'id' => 'switch'])

<label class="flex items-center cursor-pointer">
    <input type="checkbox" id="{{ $id }}" {{ $checked ? 'checked' : '' }} {{ $disabled ? 'disabled' : '' }}
        {!! $attributes->merge([
            'class' => 'sr-only peer',
        ]) !!} />
    <div
        class="relative w-9 h-5 bg-slate-200 peer-focus:outline-none peer-focus:ring-1 peer-focus:ring-slate-400 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-slate-600 {{ $disabled ? 'opacity-50 cursor-not-allowed' : '' }}">
    </div>
    {{ $slot }}
</label>
