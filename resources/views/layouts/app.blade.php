<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ $pageTitle ?? config('blog.site_title') }}</title>
        <meta name="description" content="{{ $pageDescription ?? config('blog.home_description') }}">
        <meta name="author" content="{{ config('blog.author') }}">
        <meta name="robots" content="index,follow">
        <meta property="og:type" content="{{ ($post ?? null) ? 'article' : 'website' }}">
        <meta property="og:site_name" content="{{ config('blog.site_name') }}">
        <meta property="og:title" content="{{ $pageTitle ?? config('blog.site_title') }}">
        <meta property="og:description" content="{{ $pageDescription ?? config('blog.home_description') }}">
        <meta property="og:url" content="{{ $canonicalUrl ?? url('/') }}">
        <meta name="twitter:card" content="summary">
        <meta name="twitter:title" content="{{ $pageTitle ?? config('blog.site_title') }}">
        <meta name="twitter:description" content="{{ $pageDescription ?? config('blog.home_description') }}">
        <link rel="canonical" href="{{ $canonicalUrl ?? url('/') }}">
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
        @stack('head')
    </head>
    <body>
        <div class="page-shell">
            <header class="site-header">
                <h1 class="site-title">
                    <a href="{{ route('home') }}" class="site-title-link">{{ config('blog.site_name') }}.</a>
                </h1>

                <button
                    type="button"
                    class="theme-toggle"
                    data-theme-toggle
                    aria-label="Toggle color theme"
                >
                    <span class="theme-toggle-icon" data-theme-icon aria-hidden="true">🌙</span>
                </button>
            </header>

            @yield('content')
        </div>
    </body>
</html>
