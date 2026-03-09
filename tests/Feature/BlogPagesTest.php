<?php

it('renders the blog homepage', function () {
    $response = $this->get('/');

    $response
        ->assertSuccessful()
        ->assertSee('vblinden.')
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
