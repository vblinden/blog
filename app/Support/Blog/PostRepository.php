<?php

namespace App\Support\Blog;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class PostRepository
{
    public function all(): Collection
    {
        return collect(File::files($this->postsPath()))
            ->filter(fn ($file) => $file->getExtension() === 'md')
            ->map(fn ($file) => $this->parsePostFile($file->getFilename()))
            ->filter()
            ->sortByDesc(fn (Post $post) => $post->publishedAt)
            ->values();
    }

    public function find(string $slug): ?Post
    {
        return $this->parsePostFile("{$slug}.md");
    }

    public function slugs(): Collection
    {
        return $this->all()->pluck('slug');
    }

    protected function parsePostFile(string $fileName): ?Post
    {
        $fullPath = $this->postsPath().DIRECTORY_SEPARATOR.$fileName;

        if (! File::exists($fullPath)) {
            return null;
        }

        $slug = Str::beforeLast($fileName, '.md');
        $contents = File::get($fullPath);
        [$frontMatter, $markdown] = $this->splitFrontMatter($contents);
        $normalizedContent = $this->normalizePostContent($markdown);
        $title = $this->normalizeTitle((string) ($frontMatter['title'] ?? $this->headlineFromSlug($slug)));
        $date = trim((string) ($frontMatter['date'] ?? ''));
        $publishedAt = $this->timestampFor($date);
        $description = $this->descriptionFor($frontMatter['description'] ?? null, $normalizedContent);
        $readingTime = $this->readingTimeFor($normalizedContent);

        return new Post(
            slug: $slug,
            title: $title,
            date: $date,
            description: $description,
            readingTime: $readingTime,
            publishedAt: $publishedAt,
            publishedAtIso8601: $publishedAt === 0 ? null : gmdate(DATE_ATOM, $publishedAt),
            content: $normalizedContent,
        );
    }

    protected function splitFrontMatter(string $contents): array
    {
        if (! preg_match('/\A---\R(.*?)\R---\R?(.*)\z/s', $contents, $matches)) {
            return [[], $contents];
        }

        $frontMatter = collect(preg_split('/\R/', $matches[1]) ?: [])
            ->map(fn ($line) => explode(':', $line, 2))
            ->filter(fn ($parts) => count($parts) === 2)
            ->mapWithKeys(fn ($parts) => [trim($parts[0]) => trim($parts[1])])
            ->all();

        return [$frontMatter, $matches[2]];
    }

    protected function normalizePostContent(string $content): string
    {
        return str_ireplace(['<x-link', '</x-link>'], ['<a', '</a>'], $content);
    }

    protected function normalizeTitle(string $title): string
    {
        return preg_replace('/^[\'"]|[\'"]$/', '', trim($title)) ?? trim($title);
    }

    protected function headlineFromSlug(string $slug): string
    {
        return collect(explode('-', $slug))
            ->map(fn ($part) => Str::ucfirst($part))
            ->implode(' ');
    }

    protected function timestampFor(string $date): int
    {
        if ($date === '') {
            return 0;
        }

        $normalizedDate = str_replace('Augustus', 'August', $date);
        $timestamp = strtotime("{$normalizedDate} UTC");

        return $timestamp === false ? 0 : $timestamp;
    }

    protected function descriptionFor(mixed $frontMatterDescription, string $content): string
    {
        $description = trim((string) ($frontMatterDescription ?? ''));

        if ($description !== '') {
            return $this->normalizeTitle($description);
        }

        return $this->limit($this->stripMarkdown($content), 160);
    }

    protected function readingTimeFor(string $content): int
    {
        $words = preg_split('/\s+/', $this->stripMarkdown($content), -1, PREG_SPLIT_NO_EMPTY);

        return max(1, (int) ceil(count($words) / 200));
    }

    protected function stripMarkdown(string $content): string
    {
        $normalized = preg_replace('/```[\s\S]*?```/', ' ', $content) ?? $content;
        $normalized = preg_replace('/`([^`]+)`/', '$1', $normalized) ?? $normalized;
        $normalized = preg_replace('/!\[[^\]]*]\([^)]*\)/', ' ', $normalized) ?? $normalized;
        $normalized = preg_replace('/\[([^\]]+)]\([^)]*\)/', '$1', $normalized) ?? $normalized;
        $normalized = preg_replace('/<[^>]+>/', ' ', $normalized) ?? $normalized;
        $normalized = preg_replace('/[*_#>\-]/', ' ', $normalized) ?? $normalized;

        return trim((string) preg_replace('/\s+/', ' ', $normalized));
    }

    protected function limit(string $value, int $maxLength): string
    {
        if (mb_strlen($value) <= $maxLength) {
            return $value;
        }

        return rtrim(mb_substr($value, 0, $maxLength - 1)).'…';
    }

    protected function postsPath(): string
    {
        return (string) config('blog.posts_path', base_path('posts'));
    }
}
