<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=lato:400,400i,700,700i,900,900i|news-cycle:400,700|raleway:700" rel="stylesheet" />

        <!-- Privacy First Analytics -->
        <script src="https://station-to-station-famous.sgdinstitute.org/script.js" data-site="LVDVCGSU" defer></script>

        <!-- Styles -->
        @vite('resources/css/app.css')
        <livewire:styles />

        <livewire:scripts />
        @vite('resources/js/app.js')
        @stack('scripts')
    </head>
    <body class="font-sans antialiased bg-gray-100 dark:bg-gray-900">
        @include('layouts.app.nav')
        <livewire:notifications />

        <main>
            {{ $slot }}
        </main>

        @include('layouts.app.footer')
    </body>
</html>
