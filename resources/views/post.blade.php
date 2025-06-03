<x-layout title="{{ $title }}">
    <x-slot name="meta">
        <meta property="og:title" content="{{ $title }}" />
        <meta property="og:description" content="{{ Str::of(strip_tags($content))->limit(256, '...') }}">
        <meta property="og:type" content="website" />
        <meta property="og:url" content="{{ url()->current() }}" />
        <meta property="og:locale" content="en_US" />
        <meta property="og:locale:alternate" content="en_US" />

        <meta name="twitter:card" content="summary" />
        <meta name="twitter:description" content="{{ Str::of(strip_tags($content))->limit(256, '...') }}">
        <meta name="twitter:title" content="{{ $title }}">
        <meta name="twitter:site" content="@vblinden" />
        <meta name="twitter:creator" content="@vblinden" />
    </x-slot>

    <header class="flex flex-col mb-6">
        <h1 class="mt-6 text-2xl font-bold tracking-tight break-all text-zinc-800 dark:text-zinc-100">
            {{ $title }}
        </h1>
        <time class="order-first flex items-center text-base text-zinc-400 dark:text-zinc-500">
            <strong>Posted on&nbsp;</strong> {{ $date }}
        </time>

        <p class="order-first flex items-center text-base text-zinc-400 dark:text-zinc-500">
            <strong>Reading time&nbsp;</strong> is {{ $readingTime }} minute(s)
        </p>
    </header>

    <div class="markdown">
        {!! $content !!}
    </div>
</x-layout>
