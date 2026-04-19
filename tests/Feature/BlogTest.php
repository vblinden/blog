<?php

it('shows blog posts on the homepage', function () {
    $response = $this->get('/');

    $response->assertOk();
    $response->assertSee('Simplicity is a feature');
    $response->assertSee('Projects.');
});

it('renders a blog post page', function () {
    $response = $this->get('/posts/simplicity-is-a-feature');

    $response->assertOk();
    $response->assertSee('Simplicity is a feature');
    $response->assertSee('A lot of developers I know and work with are constantly building for imaginary what ifs.');
});

it('renders fenced code blocks with tempest highlight markup', function () {
    $response = $this->get('/posts/deploying-an-application-using-dokku-with-https-and-redirects');

    $response->assertOk();
    $response->assertSee('data-lang="bash"', false);
    $response->assertSee('hl-generic', false);
});

it('returns a 404 for missing blog posts', function () {
    $this->get('/posts/does-not-exist')->assertNotFound();
});

it('exposes sitemap and robots endpoints', function () {
    $this->get('/sitemap.xml')
        ->assertOk()
        ->assertHeader('Content-Type', 'application/xml')
        ->assertSee('/posts/simplicity-is-a-feature', false);

    $this->get('/robots.txt')
        ->assertOk()
        ->assertHeader('Content-Type', 'text/plain; charset=UTF-8')
        ->assertSee('Sitemap:', false);
});
