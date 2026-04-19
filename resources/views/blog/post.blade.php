@extends('layouts.app')

@php
    $jsonLd = [
        '@context' => 'https://schema.org',
        '@type' => 'BlogPosting',
        'headline' => $post->title,
        'description' => $post->description,
        'author' => [
            '@type' => 'Person',
            'name' => config('blog.author'),
        ],
        'publisher' => [
            '@type' => 'Person',
            'name' => config('blog.author'),
        ],
        'mainEntityOfPage' => $canonicalUrl,
        'url' => $canonicalUrl,
    ];

    if ($post->publishedAtIso8601) {
        $jsonLd['datePublished'] = $post->publishedAtIso8601;
        $jsonLd['dateModified'] = $post->publishedAtIso8601;
    }
@endphp

@push('head')
    @if ($post->publishedAtIso8601)
        <meta property="article:published_time" content="{{ $post->publishedAtIso8601 }}">
    @endif

    <script type="application/ld+json">{!! json_encode($jsonLd, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}</script>
@endpush

@section('content')
    <article class="article">
        <header class="article-header">
            @if ($post->date !== '')
                <time class="article-date">{{ $post->date }}</time>
            @endif

            <h1 class="article-title">{{ $post->title }}</h1>
            <p class="article-meta">{{ $post->readingTime }} min read</p>
        </header>

        <div class="markdown">
            {!! app(\App\Support\Blog\MarkdownRenderer::class)->render($post->content ?? '') !!}
        </div>

        <footer class="article-footer">
            <a href="{{ route('home') }}">Back to home</a>
        </footer>
    </article>
@endsection
