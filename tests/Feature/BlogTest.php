<?php

use Illuminate\Support\Facades\Http;

it('shows blog posts on the homepage', function () {
    $response = $this->get('/');

    $response->assertOk();
    $response->assertSee('Simplicity is a feature');
    $response->assertSee('Undesign it');
    $response->assertSee('July 11, 2026');
    $response->assertSee('min read');
    $response->assertSee('Projects.');
    $response->assertSee('support@vblinden.dev');
    $response->assertSee('https://x.com/vblinden', false);
    $response->assertSee('application/atom+xml', false);
    $response->assertSee('application/ld+json', false);
    $response->assertSee('Skip to content');
});

it('uses a single page heading hierarchy on posts', function () {
    $response = $this->get('/posts/undesign-it');

    $response->assertOk();
    $response->assertSee('<h1 class="article-title">Undesign it</h1>', false);
    $response->assertDontSee('<h1 class="site-title">', false);
    $response->assertSee('<p class="site-title">', false);
});

it('renders a blog post page with adjacent navigation', function () {
    $response = $this->get('/posts/simplicity-is-a-feature');

    $response->assertOk();
    $response->assertSee('Simplicity is a feature');
    $response->assertSee('A lot of developers I know and work with are constantly building for imaginary what ifs.');
    $response->assertSee('Post navigation');
    $response->assertSee('Older');
    $response->assertSee('Newer');
    $response->assertSee('rel="prev"', false);
    $response->assertSee('rel="next"', false);
    $response->assertSee('BreadcrumbList', false);
    $response->assertSee('article:published_time', false);
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

it('exposes sitemap robots and atom feed endpoints', function () {
    $this->get('/sitemap.xml')
        ->assertOk()
        ->assertHeader('Content-Type', 'application/xml; charset=UTF-8')
        ->assertSee('/posts/simplicity-is-a-feature', false)
        ->assertSee('/feed', false);

    $this->get('/robots.txt')
        ->assertOk()
        ->assertHeader('Content-Type', 'text/plain; charset=UTF-8')
        ->assertSee('Sitemap:', false)
        ->assertDontSee('Host:', false);

    $this->get('/feed')
        ->assertOk()
        ->assertHeader('Content-Type', 'application/atom+xml; charset=UTF-8')
        ->assertSee('<feed xmlns="http://www.w3.org/2005/Atom">', false)
        ->assertSee('Undesign it')
        ->assertSee('/posts/undesign-it', false);
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
