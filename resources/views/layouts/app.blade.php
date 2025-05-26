<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        
        <script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.4/raphael-min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/justgage/1.6.1/justgage.js" integrity="sha512-tWxvieYDBICxbDkkAlYex1Qu6dzMfPBzpzdYd+eu9IuBYSeUSpGn8W6AUQvbBfoaiFcDxXFl6qURZxFcJVFIRg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/justgage/1.6.1/justgage.min.js" integrity="sha512-QeISJM4NCnUgZl5++o/2d4FwppF+Hh62RbNeA9paupnQvq5KAVvf2ZN3KD99EDoqcSHi1kbG13JMyRXDKBQBSw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.3/dist/chart.umd.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-date-fns/dist/chartjs-adapter-date-fns.bundle.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-annotation@3.0.1/dist/chartjs-plugin-annotation.min.js"></script>

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/sass/app.scss', 'resources/js/app.js', 'resources/js/chart-custom.js', 'resources/js/just-gage-custom.js'])
    </head>
    <body class="font-sans antialiased" 
        x-data="{ darkMode: localStorage.getItem('dark') === 'true' }"
        x-init="$watch('darkMode', val => localStorage.setItem('dark', val))"
        x-bind:class="{'dark': darkMode}"
    > 
        <!-- {{ session('theme', 'theme-light') }} -->
        <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="shadow dark:bg-gray-800"> <!--dark:bg-gray-800 -->
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 dark:bg-gray-800">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main class="main">
                {{ $slot }}
            </main>
        </div>
        <!-- <script>
            function darkMode() {
                const myBody   = document.querySelector("#myBody")
                const myHeader = document.querySelector("#myHeader")
                const main     = document.querySelector(".main")
                const top      = document.querySelector("#top")
                const darkNav  = document.querySelector("#darkNav")
                const titleH2  = document.querySelectorAll("h2")
                const divBgW   = document.querySelector(".bg-white")
                myHeader.classList.toggle("dark-mode")
                myHeader.classList.toggle("bg-white")
                // myBody.classList.toggle("dark-mode")
                // main.classList.toggle("dark-mode")
                top.classList.toggle("dark-mode")
                darkNav.classList.toggle("dark-mode")
                // titleH2.classList.toggle("text-gray-800")
                // titleH2.classList.remove("text-gray-800")
                // divBgW.classList.toggle("bg-white")
            } 
        </script> -->
        
        <!-- Page Footer -->
        @isset($footer)
            <footer class="shadow dark:bg-gray-800"> <!--dark:bg-gray-800 -->
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 dark:bg-gray-800">
                        {{ $footer }}
                    </div>
            </footer>
        @endif
    </body>
</html>
