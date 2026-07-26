<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title inertia>{{ config('app.name', 'Laravel') }}</title>

        {{-- Apply the saved colour theme before first paint to avoid a flash.
             The storefront is dark-first (Loaded-style) unless the visitor opts into light. --}}
        <script>
            (function () {
                try {
                    var t = localStorage.getItem('theme');
                    if (t !== 'light') {
                        document.documentElement.classList.add('dark');
                    }
                } catch (e) {
                    document.documentElement.classList.add('dark');
                }
            })();
        </script>

        <!-- Fonts -->
        @php
            $appearance = \App\Services\Appearance::all();
            $font = $appearance['font'] ?? 'Poppins';
            $fontSlug = strtolower(str_replace(' ', '-', $font));
            // hex -> "r g b" for rgb(var()) usage
            $rgb = function ($hex) {
                $hex = ltrim((string) $hex, '#');
                if (strlen($hex) === 3) { $hex = $hex[0].$hex[0].$hex[1].$hex[1].$hex[2].$hex[2]; }
                return implode(' ', [hexdec(substr($hex,0,2)), hexdec(substr($hex,2,2)), hexdec(substr($hex,4,2))]);
            };
        @endphp
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family={{ $fontSlug }}:400,500,600,700,800&display=swap" rel="stylesheet" />
        <style>
            :root {
                --font-sans: '{{ $font }}';
                --c-primary: {{ $rgb($appearance['color_primary'] ?? '#4f46e5') }};
                --c-buy: {{ $rgb($appearance['color_buy'] ?? '#2fbf71') }};
            }
        </style>

        <!-- Scripts -->
        @routes
        @vite(['resources/js/app.js', "resources/js/Pages/{$page['component']}.vue"])
        @inertiaHead
    </head>
    <body class="font-sans antialiased bg-gray-50 text-gray-900 dark:bg-navy-900 dark:text-gray-100">
        @inertia
    </body>
</html>
