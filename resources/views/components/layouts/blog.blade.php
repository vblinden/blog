<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @php
            $seo = $seo ?? [];
            $title = $seo['title'] ?? ($title ?? 'vblinden');
            $description = $seo['description'] ?? ($description ?? 'I am currently working at team.blue as a senior software engineer. This is my little corner of the web for stuff I have found important, handy, or just wanted to save.');
            $canonical = $seo['canonical'] ?? url()->current();
            $ogType = $seo['ogType'] ?? 'website';
            $publishedTime = $seo['publishedTime'] ?? null;
            $jsonLd = $seo['jsonLd'] ?? [];
        @endphp

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ $title }}</title>
        <meta name="description" content="{{ $description }}">
        <meta name="author" content="Vincent van der Linden">
        <meta name="robots" content="index, follow">
        <link rel="canonical" href="{{ $canonical }}">

        <meta property="og:site_name" content="vblinden">
        <meta property="og:type" content="{{ $ogType }}">
        <meta property="og:title" content="{{ $title }}">
        <meta property="og:description" content="{{ $description }}">
        <meta property="og:url" content="{{ $canonical }}">

        <meta name="twitter:card" content="summary">
        <meta name="twitter:title" content="{{ $title }}">
        <meta name="twitter:description" content="{{ $description }}">

        @if ($publishedTime !== null)
            <meta property="article:published_time" content="{{ $publishedTime }}">
        @endif

        <link rel="icon" href="data:image/x-icon;," type="image/x-icon">
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet">
        <script>
            (() => {
                const storageKey = 'theme';
                const storedTheme = localStorage.getItem(storageKey);
                const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
                const activeTheme = storedTheme ?? (prefersDark ? 'dark' : 'light');

                document.documentElement.classList.toggle('dark', activeTheme === 'dark');
                document.documentElement.style.colorScheme = activeTheme;
            })();
        </script>

        @foreach ($jsonLd as $schema)
            <script type="application/ld+json">{!! json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}</script>
        @endforeach

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body>
        <div class="page-shell">
            <header class="site-header">
                <h1 class="site-title">
                    <a href="{{ route('home') }}" class="no-underline">
                        vblinden.
                    </a>
                </h1>

                <button
                    type="button"
                    class="theme-toggle"
                    data-theme-toggle
                    aria-label="Switch to dark mode"
                    aria-pressed="false"
                >
                    <span class="theme-toggle-icon" data-theme-toggle-icon aria-hidden="true">☀️</span>
                    <span class="sr-only" data-theme-toggle-label>Dark mode</span>
                </button>
            </header>

            {{ $slot }}
        </div>
    </body>
</html>
