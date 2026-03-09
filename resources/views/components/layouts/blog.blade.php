<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ $title ?? 'vblinden' }}</title>
        <meta name="description" content="{{ $description ?? 'I am currently working at team.blue as a senior software engineer. This is my little corner of the web for stuff I have found important, handy, or just wanted to save.' }}">

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
