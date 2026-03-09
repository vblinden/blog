<?php

it('renders the blog homepage', function () {
    $response = $this->get('/');

    $response
        ->assertSuccessful()
        ->assertSee('vblinden.')
        ->assertSee('rel="canonical"', false)
        ->assertSee(route('home'), false)
        ->assertSee('<meta property="og:type" content="website">', false)
        ->assertSee('<meta name="twitter:card" content="summary">', false)
        ->assertSee('"@type":"WebSite"', false)
        ->assertSee('data-theme-toggle', false)
        ->assertSee('Tinkerers make better engineers')
        ->assertSee('sendwich.dev');
});

it('renders an individual blog post', function () {
    $response = $this->get('/posts/tinkerers-make-better-engineers');

    $response
        ->assertSuccessful()
        ->assertSee('Tinkerers make better engineers')
        ->assertSee('September 12, 2025')
        ->assertSee('rel="canonical"', false)
        ->assertSee(route('posts.show', 'tinkerers-make-better-engineers'), false)
        ->assertSee('<meta property="og:type" content="article">', false)
        ->assertSee('<meta property="article:published_time" content="2025-09-12T00:00:00+00:00">', false)
        ->assertSee('Some of the best engineers I know are tinkerers.', false)
        ->assertSee('"@type":"BlogPosting"', false)
        ->assertSee('Some of the best engineers I know are tinkerers.');
});

it('renders syntax highlighted code blocks', function () {
    $response = $this->get('/posts/do-not-write-your-own-css-framework');

    $response
        ->assertSuccessful()
        ->assertSee('data-lang="css"', false)
        ->assertSee('class="hl-keyword"', false);
});

it('renders embedded html in blog posts', function () {
    $response = $this->get('/posts/starship-mission-to-mars');

    $response
        ->assertSuccessful()
        ->assertSee('<iframe', false)
        ->assertDontSee('&lt;iframe', false)
        ->assertSee('href="https://www.youtube.com/watch?v=PMp3lJl2zE8"', false);
});

it('returns not found for an unknown blog post', function () {
    $this->get('/posts/does-not-exist')->assertNotFound();
});
