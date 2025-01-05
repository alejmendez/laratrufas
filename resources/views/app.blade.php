<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title inertia>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @routes()
        @php
            if (str_contains($page['component'], '::')) {
                $parts = explode('::', $page['component']);
                $componentPath = "Modules/" . $parts[0] . "/Resources/Pages/" . $parts[1] . ".vue";
            } else {
                $componentPath = "resources/js/Pages/{$page['component']}.vue";
            }
        @endphp
        @vite([
            'resources/js/app.js',
            $componentPath
        ])
        @inertiaHead
    </head>
    <body class="font-sans antialiased">
        @inertia
    </body>
</html>
