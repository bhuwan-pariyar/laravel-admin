<button
    {{ $attributes->merge(['type' => 'button', 'class' => 'inline-flex items-center justify-center px-4 py-2.5 bg-slate-100 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-lg font-semibold text-xs text-slate-700 dark:text-slate-200 uppercase tracking-widest shadow-sm hover:bg-slate-200 dark:hover:bg-slate-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-slate-900 disabled:opacity-50 transition ease-in-out duration-200 transform active:scale-[0.98] hover:scale-[1.01]']) }}>
    {{ $slot }}
</button>
