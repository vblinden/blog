<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ $pageTitle ?? config('blog.site_title') }}</title>
        <meta name="description" content="{{ $pageDescription ?? config('blog.home_description') }}">
        <meta name="author" content="{{ config('blog.author') }}">
        <meta name="robots" content="index,follow,max-image-preview:large">
        <meta name="theme-color" content="#ffffff" media="(prefers-color-scheme: light)">
        <meta name="theme-color" content="#1a1a1a" media="(prefers-color-scheme: dark)">
        <meta property="og:type" content="{{ ($post ?? null) ? 'article' : 'website' }}">
        <meta property="og:site_name" content="{{ config('blog.site_name') }}">
        <meta property="og:locale" content="{{ config('blog.locale', 'en_US') }}">
        <meta property="og:title" content="{{ $pageTitle ?? config('blog.site_title') }}">
        <meta property="og:description" content="{{ $pageDescription ?? config('blog.home_description') }}">
        <meta property="og:url" content="{{ $canonicalUrl ?? url('/') }}">
        <meta name="twitter:card" content="summary">
        <meta name="twitter:site" content="{{ '@'.config('blog.author_handle', 'vblinden') }}">
        <meta name="twitter:creator" content="{{ '@'.config('blog.author_handle', 'vblinden') }}">
        <meta name="twitter:title" content="{{ $pageTitle ?? config('blog.site_title') }}">
        <meta name="twitter:description" content="{{ $pageDescription ?? config('blog.home_description') }}">
        <link rel="canonical" href="{{ $canonicalUrl ?? url('/') }}">
        <link rel="alternate" type="application/atom+xml" title="{{ config('blog.site_name') }} feed" href="{{ route('feed') }}">
        <link rel="icon" href="/favicon.png" type="image/png">
        <link rel="icon" href="/favicon.svg" type="image/svg+xml">
        <link rel="apple-touch-icon" href="/apple-touch-icon.png">
        <link rel="preconnect" href="https://fonts.bunny.net" crossorigin>
        <link href="https://fonts.bunny.net/css?family=stix-two-text:400,500,600,700,400i,700i&display=swap" rel="stylesheet">
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <script defer src="/pm/stats.js" data-hostname="vblinden.dev" data-endpoint="/pm/i.gif"></script>
        @stack('head')
    </head>
    <body>
        <a class="skip-link" href="#main-content">Skip to content</a>
        <div id="main-content">
            @yield('content')
        </div>
    </body>
</html>
