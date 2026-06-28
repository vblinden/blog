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
            'description' => 'A lean, developer-first transactional email service that delivers the essentials without the bloat, gimmicks, or hidden pricing tricks. Verify your domain once, then send via a straightforward API with signed webhooks and delivery analytics to keep user state and suppression lists accurate.',
        ],
        [
            'name' => 'pennymetrics.dev',
            'url' => 'https://pennymetrics.dev',
            'description' => 'A simple, privacy-friendly web analytics service that gives you the metrics that matter without cookies, bloat, or tracking your visitors. Drop in a lightweight script, skip the consent banner, and see visitors, pageviews, referrers, and custom events in a clean dashboard within seconds.',
        ],
        [
            'name' => 'chatwithyoursite.com',
            'url' => 'https://chatwithyoursite.com',
            'description' => 'Crawl your website, upload PDFs and custom text, and turn it into a chatbot that answers visitors with grounded responses. The same indexed content is available through an agent-ready search API for custom bots and copilots, with built-in chat insights to track top questions, satisfaction, and content gaps.',
        ],
        [
            'name' => 'goutipedia.com',
            'url' => 'https://goutipedia.com',
            'description' => 'An encyclopedia and knowledge base about gout — symptoms, triggers, treatments, and practical advice for managing it. Written for patients and caregivers who want clear guidance on flares, diet, medication, and day-to-day management without wading through outdated forum posts.',
        ],
        [
            'name' => 'staravatars.com',
            'url' => 'https://staravatars.com',
            'description' => 'Create beautiful space and star based avatars from any text—a deterministic hash turns your name, email, or path into a unique cosmic portrait every time. Pick from palettes like sunset, ocean, and forest, customize shape and size, and embed them anywhere you need personality instead of a boring default avatar.',
        ],
        [
            'name' => 'nederboard.nl',
            'url' => 'https://nederboard.nl',
            'description' => 'A Dutch meme soundboard packed with snippets from viral videos, TV moments, and internet classics across the Netherlands. Browse boards for fan favorites like <a href="https://nederboard.nl/board/helemaalknettah" target="_blank" rel="noreferrer">Helemaal knettah</a> and <a href="https://nederboard.nl/board/rustahg" target="_blank" rel="noreferrer">Rustahg</a>, hit play to share the clip, and discover dozens more.',
        ],
        [
            'name' => 'iloveitshipit.com',
            'url' => 'https://iloveitshipit.com',
            'description' => 'A small, for-fun soundboard of the legendary words spoken by <a href="https://www.hanselman.com" target="_blank" rel="noreferrer">Scott Hanselman</a> during a .NET conference back in the day. Click to replay "I love it, ship it" whenever you need a morale boost before merging that pull request or pushing code to production.',
        ],
    ],
];
