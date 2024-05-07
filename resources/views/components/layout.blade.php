<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta property="og:site_name" content="vblinden">
    <meta property="og:title" content="vblinden." />
    <meta property="og:description"
        content="Hey friends, my name is Vincent van der Linden and you can find me online as @vblinden. I am currently working at team.blue as a software engineer. On this website you can find some things that I thought were important or useful enough to put online. Please enjoy.">
    <meta property="og:image" content="https://www.vblinden.dev/images/social.png" />
    <meta property="og:type" content="website" />
    <meta property="og:url" content="https://www.vblinden.dev" />
    <meta property="og:locale" content="en_US" />
    <meta property="og:locale:alternate" content="en_US" />

    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:description"
        content="Hey friends, my name is Vincent van der Linden and you can find me online as @vblinden. I am currently working at team.blue as a software engineer. On this website you can find some things that I thought were important or useful enough to put online. Please enjoy.">
    <meta name="twitter:title" content="vblinden">
    <meta name="twitter:site" content="@vblinden" />
    <meta name="twitter:creator" content="@vblinden" />
    <meta name="twitter:image" content="https://www.vblinden.dev/images/social.png" />

    <title>
        @if (isset($title))
            {{ $title }} &mdash; {{ config('app.name') }}
        @else
            {{ config('app.name') }}
        @endif
    </title>

    <link rel="shortcut icon" href="data:image/x-icon;," type="image/x-icon" />

    @vite(['resources/css/app.css'])
</head>

<body class="dark:bg-zinc-900 dark:text-zinc-400 bg-gray-50 text-lg antialiased">
    <div class="container mx-auto mb-8">
        <div class="mx-3">
            <div class="my-8">
                <h1 class="text-3xl font-bold mb-3 font-sans">
                    <a href="/"
                        class="hover:text-blue-600 dark:text-white dark:hover:text-slate-100 text-4xl font-display">
                        vblinden.
                    </a>
                </h1>
            </div>

            {{ $slot }}

            @if (isset($torchlight))
                <footer class="mt-8 mb-4 text-sm text-slate-500 dark:text-zinc-600">
                    Code highlighting provided by <a href="https://torchlight.dev/" target="_blank">torchlight.dev</a>
                </footer>
            @endif
        </div>
    </div>

    <script async defer src="https://scripts.simpleanalyticscdn.com/latest.js"></script>
    <noscript><img src="https://queue.simpleanalyticscdn.com/noscript.gif" alt=""
            referrerpolicy="no-referrer-when-downgrade" /></noscript>
</body>

</html>
