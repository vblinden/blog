@extends('layouts.app')

@php
    $jsonLd = [
        [
            '@context' => 'https://schema.org',
            '@type' => 'WebSite',
            'name' => config('blog.site_name'),
            'description' => config('blog.home_description'),
            'url' => $canonicalUrl,
        ],
        [
            '@context' => 'https://schema.org',
            '@type' => 'Blog',
            'name' => config('blog.site_name'),
            'description' => config('blog.home_description'),
            'author' => [
                '@type' => 'Person',
                'name' => config('blog.author'),
            ],
            'url' => $canonicalUrl,
        ],
    ];
@endphp

@push('head')
    <script type="application/ld+json">{!! json_encode($jsonLd, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}</script>
@endpush

@section('content')
    <main class="content-stack">
        <section class="intro">
            <p class="lede">
                Hey friends, my name is Vincent van der Linden and you can find me online as
                <a href="https://github.com/vblinden" target="_blank" rel="noreferrer">@vblinden</a>.
                I am currently working at
                <a href="https://team.blue" target="_blank" rel="noreferrer">team.blue</a>
                as a senior software engineer. This is my little corner of the web for stuff I've found important,
                handy, or just wanted to save. Hope you find something interesting! The opinions expressed herein are
                my own personal opinions and do not represent my employer's view in any way.
            </p>
        </section>

        <section>
            <h2 class="section-title">Posts.</h2>

            <ul class="post-list">
                @foreach ($posts as $post)
                    <li>
                        <a href="{{ $post->url() }}">{{ $post->title }}</a>
                    </li>
                @endforeach
            </ul>
        </section>

        <section>
            <h2 class="section-title">Projects.</h2>

            <dl class="project-list">
                @foreach ($projects as $project)
                    <dt>
                        <a href="{{ $project['url'] }}" target="_blank" rel="noreferrer">{{ $project['name'] }}</a>
                    </dt>
                    <dd>{!! $project['description'] !!}</dd>
                @endforeach
            </dl>
        </section>
    </main>
@endsection
