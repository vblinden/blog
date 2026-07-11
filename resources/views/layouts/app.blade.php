<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ $pageTitle ?? config('blog.site_title') }}</title>
        <meta name="description" content="{{ $pageDescription ?? config('blog.home_description') }}">
        <meta name="author" content="{{ config('blog.author') }}">
        <meta name="robots" content="index,follow,max-image-preview:large">
        <meta name="theme-color" content="#fffdf8" media="(prefers-color-scheme: light)">
        <meta name="theme-color" content="#020617" media="(prefers-color-scheme: dark)">
        <meta property="og:type" content="{{ ($post ?? null) ? 'article' : 'website' }}">
        <meta property="og:site_name" content="{{ config('blog.site_name') }}">
        <meta property="og:locale" content="{{ config('blog.locale', 'en_US') }}">
        <meta property="og:title" content="{{ $pageTitle ?? config('blog.site_title') }}">
        <meta property="og:description" content="{{ $pageDescription ?? config('blog.home_description') }}">
        <meta property="og:url" content="{{ $canonicalUrl ?? url('/') }}">
        <meta name="twitter:card" content="summary">
        <meta name="twitter:site" content="@{{ config('blog.author_handle', 'vblinden') }}">
        <meta name="twitter:creator" content="@{{ config('blog.author_handle', 'vblinden') }}">
        <meta name="twitter:title" content="{{ $pageTitle ?? config('blog.site_title') }}">
        <meta name="twitter:description" content="{{ $pageDescription ?? config('blog.home_description') }}">
        <link rel="canonical" href="{{ $canonicalUrl ?? url('/') }}">
        <link rel="alternate" type="application/atom+xml" title="{{ config('blog.site_name') }} feed" href="{{ route('feed') }}">
        <link rel="icon" href="/favicon.svg" type="image/svg+xml">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Instrument+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
        <script>
            (() => {
                const storedTheme = localStorage.getItem('theme');
                const theme = storedTheme === 'light' || storedTheme === 'dark'
                    ? storedTheme
                    : window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';

                document.documentElement.classList.toggle('dark', theme === 'dark');
                document.documentElement.dataset.theme = theme;
            })();
        </script>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <script defer src="/pm/stats.js" data-hostname="vblinden.dev" data-endpoint="/pm/i.gif"></script>
        @stack('head')
    </head>
    <body>
        <a class="skip-link" href="#main-content">Skip to content</a>

        <div class="page-shell">
            <header class="site-header">
                @if ($useSiteTitleHeading ?? false)
                    <h1 class="site-title">
                        <a href="{{ route('home') }}" class="site-title-link">{{ config('blog.site_name') }}.</a>
                    </h1>
                @else
                    <p class="site-title">
                        <a href="{{ route('home') }}" class="site-title-link">{{ config('blog.site_name') }}.</a>
                    </p>
                @endif

                <button
                    type="button"
                    class="theme-toggle"
                    data-theme-toggle
                    aria-label="Toggle color theme"
                >
                    <span class="theme-toggle-icon theme-toggle-icon-moon" data-theme-icon-moon aria-hidden="true">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M21 14.5A8.5 8.5 0 1 1 9.5 3 7 7 0 0 0 21 14.5z"></path>
                        </svg>
                    </span>
                    <span class="theme-toggle-icon theme-toggle-icon-sun" data-theme-icon-sun aria-hidden="true">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="4"></circle>
                            <path d="M12 2v2M12 20v2M4.93 4.93l1.41 1.41M17.66 17.66l1.41 1.41M2 12h2M20 12h2M4.93 19.07l1.41-1.41M17.66 6.34l1.41-1.41"></path>
                        </svg>
                    </span>
                </button>
            </header>

            <div id="main-content">
                @yield('content')
            </div>
        </div>
    </body>
</html>
