<?php

namespace App\Http\Controllers;

use App\Services\BlogPostRepository;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Arr;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class BlogController extends Controller
{
    public function index(BlogPostRepository $posts): View
    {
        $homepageDescription = 'Personal blog of Vincent van der Linden about software engineering, side projects, deployment, Laravel, and practical lessons from building things.';

        return view('blog.index', [
            'posts' => $posts->all(),
            'projects' => $this->projects(),
            'seo' => [
                'title' => 'vblinden',
                'description' => $homepageDescription,
                'canonical' => route('home'),
                'ogType' => 'website',
                'jsonLd' => [
                    [
                        '@context' => 'https://schema.org',
                        '@type' => 'WebSite',
                        'name' => 'vblinden',
                        'url' => route('home'),
                        'description' => $homepageDescription,
                    ],
                    [
                        '@context' => 'https://schema.org',
                        '@type' => 'Blog',
                        'name' => 'vblinden',
                        'url' => route('home'),
                        'description' => $homepageDescription,
                        'author' => [
                            '@type' => 'Person',
                            'name' => 'Vincent van der Linden',
                        ],
                    ],
                ],
            ],
        ]);
    }

    public function show(BlogPostRepository $posts, string $slug): View
    {
        $post = $posts->find($slug);

        if ($post === null) {
            throw new NotFoundHttpException;
        }

        return view('blog.show', [
            'post' => $post,
            'seo' => [
                'title' => "{$post['title']} - vblinden",
                'description' => $post['description'],
                'canonical' => route('posts.show', $post['slug']),
                'ogType' => 'article',
                'publishedTime' => $post['published_at_iso8601'],
                'jsonLd' => [
                    Arr::whereNotNull([
                        '@context' => 'https://schema.org',
                        '@type' => 'BlogPosting',
                        'headline' => $post['title'],
                        'description' => $post['description'],
                        'datePublished' => $post['published_at_iso8601'],
                        'dateModified' => $post['published_at_iso8601'],
                        'mainEntityOfPage' => route('posts.show', $post['slug']),
                        'url' => route('posts.show', $post['slug']),
                        'author' => [
                            '@type' => 'Person',
                            'name' => 'Vincent van der Linden',
                        ],
                        'publisher' => [
                            '@type' => 'Person',
                            'name' => 'Vincent van der Linden',
                        ],
                    ]),
                ],
            ],
        ]);
    }

    /**
     * @return array<int, array{name: string, url: string, description: string}>
     */
    private function projects(): array
    {
        return [
            [
                'name' => 'sendwich.dev',
                'url' => 'https://sendwich.dev',
                'description' => 'It\'s a lean, developer-first transactional email service that delivers the essentials without the bloat, gimmicks, or hidden pricing tricks.',
            ],
            [
                'name' => 'checkeroni.com',
                'url' => 'https://www.checkeroni.com',
                'description' => 'Minimal, simple and inexpensive 24/7 uptime monitoring service. Create an account, add an url, and it will check it every couple of minutes. When the url is down, it will notify you via email, SMS or by pinging a webhook.',
            ],
            [
                'name' => 'whatswrong.dev',
                'url' => 'https://whatswrong.dev',
                'description' => 'Great tool to help you find out what\'s wrong with your website. Application exception tracking service for Laravel. A sort of Sentry light.',
            ],
            [
                'name' => 'staravatars.com',
                'url' => 'https://staravatars.com',
                'description' => 'Create beautiful space and star based avatars based on the text provided. I use this for my own projects to get rid of the boring default avatars.',
            ],
            [
                'name' => 'nederboard.nl',
                'url' => 'https://nederboard.nl',
                'description' => 'A soundboard with snippets from all kinds of different meme videos in the Netherlands. Including classics like <a href="https://nederboard.nl/board/helemaalknettah" target="_blank" rel="noreferrer">Helemaal knettah</a> and <a href="https://nederboard.nl/board/rustahg" target="_blank" rel="noreferrer">Rustahg</a> plus a dozen more!',
            ],
            [
                'name' => 'iloveitshipit.com',
                'url' => 'https://iloveitshipit.com',
                'description' => 'Small and for fun soundboard of the legendary words spoken by <a href="https://www.hanselman.com" target="_blank" rel="noreferrer">Scott Hanselman</a> during a .NET conference back in the day.',
            ],
        ];
    }
}
