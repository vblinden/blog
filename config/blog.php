<?php

return [
    'site_name' => env('BLOG_SITE_NAME', 'vblinden'),
    'site_title' => env('BLOG_SITE_TITLE', 'vblinden'),
    'author' => 'Vincent van der Linden',
    'author_handle' => 'vblinden',
    'locale' => 'en_US',
    'home_description' => 'Personal blog of Vincent van der Linden (vblinden) about software engineering, side projects, deployment, Laravel, and practical lessons from building things.',
    'site_url' => rtrim((string) env('APP_URL', ''), '/'),
    'posts_path' => base_path('posts'),
    'social' => [
        'github' => 'https://github.com/vblinden',
        'x' => 'https://x.com/vblinden',
        'email' => 'support@vblinden.dev',
    ],
    'project_tracking' => [
        'utm_source' => 'vblinden.dev',
        'utm_medium' => 'referral',
        'utm_campaign' => 'homepage',
    ],
    'projects' => [
        [
            'name' => 'mailsurge.dev',
            'url' => 'https://mailsurge.dev',
            'description' => 'Lean transactional email for developers: domain verify, simple API, signed webhooks, delivery analytics.',
        ],
        [
            'name' => 'pennymetrics.dev',
            'url' => 'https://pennymetrics.dev',
            'description' => 'Privacy-friendly web analytics without cookies or consent banners.',
        ],
        [
            'name' => 'chatwithyoursite.com',
            'url' => 'https://chatwithyoursite.com',
            'description' => 'Turn your site, PDFs, and notes into a grounded chatbot and search API.',
        ],
        [
            'name' => 'moyouai.com',
            'url' => 'https://moyouai.com',
            'description' => 'Describe a brand and generate production-ready SVG logos.',
        ],
        [
            'name' => 'absurge.com',
            'url' => 'https://absurge.com',
            'description' => '',
        ],
        [
            'name' => 'goutipedia.com',
            'url' => 'https://goutipedia.com',
            'description' => 'Clear guidance on gout symptoms, triggers, treatment, and day-to-day management.',
        ],
        [
            'name' => 'staravatars.com',
            'url' => 'https://staravatars.com',
            'description' => 'Deterministic space-themed avatars from any name, email, or path.',
        ],
        [
            'name' => 'nederboard.nl',
            'url' => 'https://nederboard.nl',
            'description' => 'Dutch meme soundboard with viral clips and internet classics.',
        ],
        [
            'name' => 'iloveitshipit.com',
            'url' => 'https://iloveitshipit.com',
            'description' => 'Replay Scott Hanselman\'s "I love it, ship it" whenever you need a push.',
        ],
    ],
];
