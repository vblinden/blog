<?php

use Illuminate\Support\Facades\Http;

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

it('renders embedded iframes in blog posts', function () {
    $response = $this->get('/posts/starship-mission-to-mars');

    $response->assertOk();
    $response->assertSee('<iframe', false);
    $response->assertSee('youtube-nocookie.com/embed/910AkzxgtBs', false);
    $response->assertDontSee('&lt;iframe', false);
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

it('proxies penny metrics assets', function () {
    Http::fake([
        'pennymetrics.dev/stats.js' => Http::response('window.pennymetrics = {};', 200, [
            'Content-Type' => 'application/javascript',
        ]),
        'pennymetrics.dev/api/i.gif*' => Http::response('GIF89a', 200, [
            'Content-Type' => 'image/gif',
        ]),
    ]);

    $this->get('/pm/stats.js', ['User-Agent' => 'TestAgent/1.0'])
        ->assertOk()
        ->assertHeader('Content-Type', 'application/javascript')
        ->assertSee('window.pennymetrics', false);

    Http::assertSent(fn ($request) => $request->url() === 'https://pennymetrics.dev/stats.js'
        && $request->hasHeader('X-PM-Client-IP'));

    $this->get('/pm/i.gif?d=abc123', [
        'User-Agent' => 'TestAgent/1.0',
        'CF-Connecting-IP' => '203.0.113.42',
    ])
        ->assertOk()
        ->assertHeader('Content-Type', 'image/gif')
        ->assertSee('GIF89a', false);

    Http::assertSent(fn ($request) => str_starts_with($request->url(), 'https://pennymetrics.dev/api/i.gif')
        && in_array('203.0.113.42', $request->header('X-PM-Client-IP'), true));
});
