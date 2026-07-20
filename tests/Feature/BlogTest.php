<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;

it('trusts reverse proxy headers from fizz', function () {
    Route::get('/__trust-proxy-check', function (Request $request) {
        return response()->json([
            'ip' => $request->ip(),
            'secure' => $request->secure(),
            'scheme' => $request->getScheme(),
            'host' => $request->getHost(),
        ]);
    });

    $this->call('GET', '/__trust-proxy-check', server: [
        'REMOTE_ADDR' => '127.0.0.1',
        'HTTP_X_FORWARDED_FOR' => '203.0.113.50',
        'HTTP_X_FORWARDED_PROTO' => 'https',
        'HTTP_X_FORWARDED_HOST' => 'vblinden.dev',
        'HTTP_X_FORWARDED_PORT' => '443',
    ])
        ->assertOk()
        ->assertJson([
            'ip' => '203.0.113.50',
            'secure' => true,
            'scheme' => 'https',
            'host' => 'vblinden.dev',
        ]);
});

it('shows blog posts on the homepage', function () {
    $response = $this->get('/');

    $response->assertOk();
    $response->assertSee('<h1 class="page-title">vblinden</h1>', false);
    $response->assertSee('Simplicity is a feature');
    $response->assertSee('Undesign it');
    $response->assertSee('Latest posts:');
    $response->assertSee('read my posts');
    $response->assertSee('mailsurge.dev');
    $response->assertSee('utm_source=vblinden.dev', false);
    $response->assertSee('utm_medium=referral', false);
    $response->assertSee('utm_campaign=homepage', false);
    $response->assertSee('@vblinden');
    $response->assertDontSee('@{{ config', false);
    $response->assertSee('support@vblinden.dev');
    $response->assertSee('https://x.com/vblinden', false);
    $response->assertSee('application/atom+xml', false);
    $response->assertSee('application/ld+json', false);
    $response->assertSee('Skip to content');
});

it('lists all posts on the posts page', function () {
    $response = $this->get('/posts');

    $response->assertOk();
    $response->assertSee('<h1 class="page-title">Posts</h1>', false);
    $response->assertDontSee('By vblinden');
    $response->assertDontSee('Here’s a list of my posts');
    $response->assertSee('Simplicity is a feature');
    $response->assertSee('Undesign it');
    $response->assertSee('The Critical Path');
});

it('redirects the old writing url to posts', function () {
    $this->get('/writing')->assertRedirect('/posts');
});

it('uses a single page heading hierarchy on posts', function () {
    $response = $this->get('/posts/undesign-it');

    $response->assertOk();
    $response->assertSee('<h1 class="article-title">Undesign it</h1>', false);
    $response->assertDontSee('By vblinden');
    $response->assertDontSee('<h1 class="page-title">', false);
    $response->assertDontSee('<h1 class="site-title">', false);
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
        ->assertSee('/posts', false)
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
        'pennymetrics.dev/api/collect' => Http::response(['ok' => true], 202, [
            'Content-Type' => 'application/json',
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

    $payload = json_encode([
        'type' => 'pageview',
        'hostname' => 'vblinden.dev',
        'path' => '/',
    ], JSON_THROW_ON_ERROR);

    $this->call('POST', '/pm/api/collect', content: $payload, server: [
        'CONTENT_TYPE' => 'text/plain',
        'HTTP_USER_AGENT' => 'TestAgent/1.0',
        'HTTP_CF_CONNECTING_IP' => '203.0.113.99',
    ])
        ->assertStatus(202)
        ->assertJson(['ok' => true]);

    Http::assertSent(fn ($request) => $request->url() === 'https://pennymetrics.dev/api/collect'
        && $request->body() === $payload
        && in_array('203.0.113.99', $request->header('X-PM-Client-IP'), true));
});

it('embeds first-party pennymetrics collect and pixel endpoints', function () {
    $this->get('/')
        ->assertOk()
        ->assertSee('data-endpoint="/pm/i.gif"', false)
        ->assertSee('data-collect="/pm/api/collect"', false);
});
