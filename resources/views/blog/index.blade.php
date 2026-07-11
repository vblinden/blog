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
    <main class="content-stack">
        <section class="intro">
            <p class="lede">
                Hey friends, my name is Vincent van der Linden and you can find me online as
                <a href="{{ $social['github'] ?? 'https://github.com/vblinden' }}" target="_blank" rel="noreferrer">@{{ config('blog.author_handle') }}</a>.
                I am currently working at
                <a href="https://team.blue" target="_blank" rel="noreferrer">team.blue</a>
                as a senior software engineer. This is my little corner of the web for stuff I've found important,
                handy, or just wanted to save. Hope you find something interesting!
            </p>
            <p class="intro-disclaimer">
                Opinions here are my own and do not represent my employer.
            </p>
        </section>

        <section aria-labelledby="posts-heading">
            <h2 id="posts-heading" class="section-title">Posts.</h2>

            <ul class="post-list">
                @foreach ($posts as $post)
                    <li class="post-list-item">
                        <a class="post-list-link" href="{{ $post->url() }}">{{ $post->title }}</a>
                        <p class="post-list-meta">
                            @if ($post->date !== '')
                                <time datetime="{{ $post->publishedAtIso8601 }}">{{ $post->date }}</time>
                                <span aria-hidden="true">·</span>
                            @endif
                            <span>{{ $post->readingTime }} min read</span>
                        </p>
                    </li>
                @endforeach
            </ul>
        </section>

        <section aria-labelledby="projects-heading">
            <h2 id="projects-heading" class="section-title">Projects.</h2>

            <ul class="project-list">
                @foreach ($projects as $project)
                    <li class="project-list-item">
                        <a class="project-list-link" href="{{ $project['url'] }}" target="_blank" rel="noreferrer">{{ $project['name'] }}</a>
                        <p class="project-list-description">{{ $project['description'] }}</p>
                    </li>
                @endforeach
            </ul>
        </section>

        <footer class="site-footer">
            <p>
                Need help with any of my products? Reach me on
                <a href="{{ $social['x'] ?? 'https://x.com/vblinden' }}" target="_blank" rel="noreferrer">X</a>
                or email
                <a href="mailto:{{ $social['email'] ?? 'support@vblinden.dev' }}">{{ $social['email'] ?? 'support@vblinden.dev' }}</a>.
            </p>
            <p class="site-footer-meta">
                <a href="{{ route('feed') }}">RSS feed</a>
            </p>
        </footer>
    </main>
@endsection
