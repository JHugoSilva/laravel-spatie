<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>
        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
            @include('layouts.sidebarUser')

            <!-- Page Heading -->
            @if(isset($header))
                <header class="bg-white dark:bg-gray-800 shadow px-4 sm:px-6 md:px-8 lg:ps-72">
                    <div class="max-w-7xl mx-auto py-6 px-2 sm:px-6 lg:px-4">
                        {{ $header }}
                    </div>
                </header>
            @else
                <header>Ola Mundo</header>
            @endif

            <!-- Page Content -->
            <main>
                @if (session('success'))
                <div class="text-center mt-2 bg-teal-500 text-sm text-white rounded-lg p-4" role="alert" tabindex="-1" aria-labelledby="hs-solid-color-success-label">
                    <span id="hs-solid-color-success-label" class="font-bold">Success</span> {{ session('success') }}
                  </div>
                @endif
                {{ $slot }}
            </main>
        </div>
    </body>
</html>
