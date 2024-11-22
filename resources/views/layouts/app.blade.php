<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"
        integrity="sha512-pHVGpX7F/27yZ0ISY+VVjyULApbDlD0/X0rgGbTqCE7WFW5MezNTWG/dnhtbBuICzsd0WQPgpE4REBLv+UqChw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdn.tiny.cloud/1/rijt5wqvbk2zh0nmfddo2ok8mdk9egeu49wd0ws79fnlieu5/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>
<script>
    tinymce.init({
          selector: 'textarea#description', // Replace this CSS selector to match the placeholder element for TinyMCE
          plugins: 'code table lists',
          toolbar: 'undo redo | blocks | bold italic | alignleft aligncenter alignright | indent outdent | bullist numlist | code | table'
        });
</script>
</head>

<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
        @include('layouts.sidebar')

        <!-- Page Heading -->
        @if (isset($header))
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
                <div class="text-center mt-2 bg-teal-500 text-sm text-white rounded-lg p-4" role="alert"
                    tabindex="-1" aria-labelledby="hs-solid-color-success-label">
                    <span id="hs-solid-color-success-label" class="font-bold">Success</span> {{ session('success') }}
                </div>
            @endif
            {{ $slot }}
        </main>
    </div>

    <script>
        $(document).ready(function() {
            $('#currency').mask('#.##0', { reverse: true})
        })

    </script>
    @stack('scriptjs')
</body>

</html>
