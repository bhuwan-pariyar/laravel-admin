<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <link rel="icon" type="image/x-icon" href="/assets/images/favicon/favicon.ico">
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>

    <body class="font-sans antialiased">
        <!-- Fullscreen Preloader -->
        <div id="preloader">
            <div class="flex flex-col items-center justify-center space-y-4">
                <div class="loader-ring">
                    <div></div><div></div><div></div>
                </div>
                <div class="text-slate-500 font-medium tracking-wide animate-pulse">Loading Portal...</div>
            </div>
        </div>

        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0">
            {{ $slot }}
        </div>
        
        <script type="text/javascript">
            document.addEventListener('DOMContentLoaded', function () {
                const preloader = document.getElementById('preloader');
                if (preloader) {
                    preloader.classList.add('fade-out');
                    setTimeout(() => {
                        preloader.remove();
                    }, 400);
                }
            });
        </script>
        @stack('custom-scripts')
    </body>

</html>
