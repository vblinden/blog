@extends('layouts.app')

@php
    $social = config('blog.social', []);
    $sameAs = array_values(array_filter([
        $social['github'] ?? null,
        $social['x'] ?? null,
    ]));

    $favorites = $posts->take(6);

    $jsonLd = [
        [
            '@context' => 'https://schema.org',
            '@type' => 'WebSite',
            'name' => config('blog.site_name'),
            'description' => config('blog.home_description'),
            'url' => $canonicalUrl,
            'inLanguage' => 'en',
            'author' => [
                '@type' => 'Person',
                'name' => config('blog.author'),
                'url' => $canonicalUrl,
            ],
            'potentialAction' => [
                '@type' => 'ReadAction',
                'target' => $canonicalUrl,
            ],
        ],
        [
            '@context' => 'https://schema.org',
            '@type' => 'Blog',
            'name' => config('blog.site_name'),
            'description' => config('blog.home_description'),
            'url' => $canonicalUrl,
            'inLanguage' => 'en',
            'author' => [
                '@type' => 'Person',
                'name' => config('blog.author'),
                'url' => $canonicalUrl,
                'sameAs' => $sameAs,
            ],
            'blogPost' => $posts->take(10)->map(fn ($post) => [
                '@type' => 'BlogPosting',
                'headline' => $post->title,
                'url' => $post->url(),
                'datePublished' => $post->publishedAtIso8601,
                'description' => $post->description,
            ])->values()->all(),
        ],
        [
            '@context' => 'https://schema.org',
            '@type' => 'Person',
            'name' => config('blog.author'),
            'alternateName' => config('blog.author_handle'),
            'url' => $canonicalUrl,
            'jobTitle' => 'Software engineer',
            'sameAs' => $sameAs,
        ],
    ];

    if (! empty($social['email'])) {
        $jsonLd[2]['email'] = $social['email'];
    }
@endphp

@push('head')
    <script type="application/ld+json">{!! json_encode($jsonLd, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}</script>
@endpush

@section('content')
    <main>
        <h1 class="page-title">{{ config('blog.site_name') }}</h1>

        <div class="prose-block">
            <p>
                I work as a software engineer at
                <a href="https://team.blue" target="_blank" rel="noreferrer">team.blue</a>.
                Online you can find me as
                <a href="{{ $social['github'] ?? 'https://github.com/vblinden' }}" target="_blank" rel="noreferrer">{{ '@'.config('blog.author_handle') }}</a>
                on GitHub and elsewhere.
                This is my little corner of the web for stuff I’ve found important, handy, or just wanted to write down and save.
            </p>

            <p class="prose-note">
                Opinions here are my own and do not represent my employer.
            </p>

            <p class="latest-posts-label">Latest posts:</p>

            <ul class="link-list">
                @foreach ($favorites as $post)
                    <li>
                        <a href="{{ $post->url() }}">{{ $post->title }}</a>
                    </li>
                @endforeach
            </ul>

            <p>
                I’ve also built
                @foreach ($projects as $index => $project)<a href="{{ $project['url'] }}" target="_blank" rel="noreferrer">{{ $project['name'] }}</a>{{ $index === count($projects) - 1 ? '.' : ($index === count($projects) - 2 ? ', and ' : ', ') }}@endforeach
            </p>

            <p>
                You can
                <a href="{{ route('posts') }}">read my posts</a>
                or
                <a href="{{ $social['github'] ?? 'https://github.com/vblinden' }}" target="_blank" rel="noreferrer">code</a>,
                or follow me on
                <a href="{{ $social['x'] ?? 'https://x.com/vblinden' }}" target="_blank" rel="noreferrer">X</a>.
                Need help with any of my products? Reach out via
                <a href="mailto:{{ $social['email'] ?? 'support@vblinden.dev' }}">{{ $social['email'] ?? 'support@vblinden.dev' }}</a>
                or the
                <a href="{{ route('feed') }}">RSS feed</a>.
            </p>
        </div>
    </main>
@endsection
