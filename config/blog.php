<?php

return [
    'site_name' => env('BLOG_SITE_NAME', 'vblinden'),
    'site_title' => env('BLOG_SITE_TITLE', 'vblinden'),
    'author' => 'vblinden',
    'home_description' => 'Personal blog of vblinden about software engineering, side projects, deployment, Laravel, and practical lessons from building things.',
    'site_url' => rtrim((string) env('APP_URL', ''), '/'),
    'posts_path' => base_path('posts'),
    'projects' => [
        [
            'name' => 'mailsurge.dev',
            'url' => 'https://mailsurge.dev',
            'description' => "It's a lean, developer-first transactional email service that delivers the essentials without the bloat, gimmicks, or hidden pricing tricks.",
        ],
        [
            'name' => 'pennymetrics.dev',
            'url' => 'https://pennymetrics.dev',
            'description' => 'A simple, privacy-friendly web analytics service that gives you the metrics that matter without cookies, bloat, or tracking your visitors.',
        ],
        [
            'name' => 'chatwithyoursite.com',
            'url' => 'https://chatwithyoursite.com',
            'description' => 'Crawl your website, upload PDFs and custom text, and turn it into a chatbot that answers visitors with grounded responses. The same indexed content is available through an agent-ready search API for custom bots and copilots, with built-in chat insights to track top questions, satisfaction, and content gaps.',
        ],
        [
            'name' => 'goutipedia.com',
            'url' => 'https://goutipedia.com',
            'description' => 'An encyclopedia and knowledge base about gout — symptoms, triggers, treatments, and practical advice for managing it.',
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
    ],
];
