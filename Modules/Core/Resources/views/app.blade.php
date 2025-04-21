<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title inertia>{{ config('app.name', 'Laravel') }}</title>

        <link rel="icon" href="{{ asset('assets/img/icon/favicon.ico') }}" type="image/x-icon">
        <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets/img/icon/apple-touch-icon.png') }}">
        <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('assets/img/icon/favicon-32x32.png') }}">
        <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/img/icon/favicon-16x16.png') }}">
        <link rel="manifest" href="{{ asset('assets/img/icon/site.webmanifest') }}">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

        <!-- Scripts -->
        @routes()
        @vite([
            'resources/css/app.css',
            'resources/js/app.js'
        ])
        @inertiaHead
    </head>
    <body class="font-sans antialiased">
        @inertia
    </body>
</html>
