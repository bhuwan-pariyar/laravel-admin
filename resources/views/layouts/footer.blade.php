<footer class="fixed bottom-0 bg-slate-900 dark:bg-slate-900 text-white py-3 text-center border-t border-slate-800 z-20">
    <div class="container mx-auto px-4">
        <p class="text-xs text-gray-400">
            &copy; {{ date('Y') }} <span class="font-medium text-gray-300">Bhuwan</span>. All rights reserved.
        </p>
    </div>
</footer>

<style>
    footer {
        left: 11rem;
        right: 0;
        width: calc(100% - 11rem);
        transition: left 0.3s ease, width 0.3s ease;
    }

    .main.collapsed~footer,
    body:has(.main.collapsed) footer {
        left: 4rem;
        width: calc(100% - 4rem);
    }

    .main {
        padding-bottom: 4rem;
    }

    @media (max-width: 768px) {
        footer {
            left: 0;
            width: 100%;
        }
    }
</style>
