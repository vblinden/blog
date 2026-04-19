<?php

namespace App\Support\Blog;

readonly class Post
{
    public function __construct(
        public string $slug,
        public string $title,
        public string $date,
        public string $description,
        public int $readingTime,
        public int $publishedAt,
        public ?string $publishedAtIso8601,
        public ?string $content = null,
    ) {
    }

    public function url(): string
    {
        return route('posts.show', $this->slug);
    }
}
