@extends('layouts.app')

@php
    $social = config('blog.social', []);
    $sameAs = array_values(array_filter([
        $social['github'] ?? null,
        $social['x'] ?? null,
    ]));

    $jsonLd = [
        [
            '@context' => 'https://schema.org',
            '@type' => 'BlogPosting',
            'headline' => $post->title,
            'description' => $post->description,
            'author' => [
                '@type' => 'Person',
                'name' => config('blog.author'),
                'url' => url('/'),
                'sameAs' => $sameAs,
            ],
            'publisher' => [
                '@type' => 'Person',
                'name' => config('blog.author'),
                'url' => url('/'),
            ],
            'mainEntityOfPage' => [
                '@type' => 'WebPage',
                '@id' => $canonicalUrl,
            ],
            'url' => $canonicalUrl,
            'inLanguage' => 'en',
            'wordCount' => str_word_count(strip_tags($post->content ?? '')),
            'timeRequired' => 'PT'.$post->readingTime.'M',
            'isPartOf' => [
                '@type' => 'Blog',
                'name' => config('blog.site_name'),
                'url' => url('/'),
            ],
        ],
        [
            '@context' => 'https://schema.org',
            '@type' => 'BreadcrumbList',
            'itemListElement' => [
                [
                    '@type' => 'ListItem',
                    'position' => 1,
                    'name' => 'Home',
                    'item' => url('/'),
                ],
                [
                    '@type' => 'ListItem',
                    'position' => 2,
                    'name' => $post->title,
                    'item' => $canonicalUrl,
                ],
            ],
        ],
    ];

    if ($post->publishedAtIso8601) {
        $jsonLd[0]['datePublished'] = $post->publishedAtIso8601;
        $jsonLd[0]['dateModified'] = $post->publishedAtIso8601;
    }
@endphp

@push('head')
    @if ($post->publishedAtIso8601)
        <meta property="article:published_time" content="{{ $post->publishedAtIso8601 }}">
        <meta property="article:modified_time" content="{{ $post->publishedAtIso8601 }}">
    @endif
    <meta property="article:author" content="{{ config('blog.author') }}">
    <meta property="article:section" content="Software engineering">

    @if ($olderPost)
        <link rel="prev" href="{{ $olderPost->url() }}">
    @endif
    @if ($newerPost)
        <link rel="next" href="{{ $newerPost->url() }}">
    @endif

    <script type="application/ld+json">{!! json_encode($jsonLd, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}</script>
@endpush

@section('content')
    <article class="article">
        <header class="article-header">
            @if ($post->date !== '')
                <time class="article-date" datetime="{{ $post->publishedAtIso8601 }}">{{ $post->date }}</time>
            @endif

            <h1 class="article-title">{{ $post->title }}</h1>
            <p class="article-meta">{{ $post->readingTime }} min read</p>
        </header>

        <div class="markdown">
            {!! app(\App\Support\Blog\MarkdownRenderer::class)->render($post->content ?? '') !!}
        </div>

        <nav class="article-nav" aria-label="Post navigation">
            <div class="article-nav-item">
                @if ($olderPost)
                    <span class="article-nav-label">Older</span>
                    <a href="{{ $olderPost->url() }}">{{ $olderPost->title }}</a>
                @endif
            </div>
            <div class="article-nav-item article-nav-item-end">
                @if ($newerPost)
                    <span class="article-nav-label">Newer</span>
                    <a href="{{ $newerPost->url() }}">{{ $newerPost->title }}</a>
                @endif
            </div>
        </nav>

        <footer class="article-footer">
            <a href="{{ route('home') }}">Back to home</a>
        </footer>
    </article>
@endsection
