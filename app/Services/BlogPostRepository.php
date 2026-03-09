<?php

namespace App\Services;

use Carbon\CarbonImmutable;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use League\CommonMark\Environment\Environment;
use League\CommonMark\Extension\Autolink\AutolinkExtension;
use League\CommonMark\Extension\CommonMark\CommonMarkCoreExtension;
use League\CommonMark\Extension\Strikethrough\StrikethroughExtension;
use League\CommonMark\Extension\Table\TableExtension;
use League\CommonMark\Extension\TaskList\TaskListExtension;
use League\CommonMark\MarkdownConverter;
use Tempest\Highlight\CommonMark\HighlightExtension;

class BlogPostRepository
{
    /**
     * @return array<int, array{slug: string, title: string, date: string, html: string}>
     */
    public function all(): array
    {
        $posts = collect(glob(base_path('posts/*.md')) ?: [])
            ->map(fn (string $path): ?array => $this->parseFile($path))
            ->filter()
            ->sortByDesc('published_at')
            ->values()
            ->map(fn (array $post): array => Arr::except($post, ['published_at']))
            ->all();

        return $posts;
    }

    /**
     * @return array{slug: string, title: string, date: string, html: string}|null
     */
    public function find(string $slug): ?array
    {
        $path = base_path("posts/{$slug}.md");

        if (! is_file($path)) {
            return null;
        }

        $post = $this->parseFile($path);

        if ($post === null) {
            return null;
        }

        return Arr::except($post, ['published_at']);
    }

    /**
     * @return array{slug: string, title: string, date: string, html: string, published_at: int}|null
     */
    private function parseFile(string $path): ?array
    {
        $contents = file_get_contents($path);

        if ($contents === false) {
            return null;
        }

        [$frontMatter, $markdown] = $this->extractFrontMatter($contents);

        $slug = pathinfo($path, PATHINFO_FILENAME);
        $title = $frontMatter['title'] ?? Str::headline($slug);
        $date = trim($frontMatter['date'] ?? '');

        return [
            'slug' => $slug,
            'title' => trim($title, "\"' "),
            'date' => $date,
            'html' => $this->renderMarkdown($markdown),
            'published_at' => $this->timestampFor($date),
        ];
    }

    /**
     * @return array{0: array<string, string>, 1: string}
     */
    private function extractFrontMatter(string $contents): array
    {
        if (! preg_match('/\A---\R(?<frontmatter>.*?)\R---\R?(?<markdown>.*)\z/s', $contents, $matches)) {
            return [[], $contents];
        }

        $frontMatter = collect(preg_split('/\R/', $matches['frontmatter']) ?: [])
            ->mapWithKeys(function (string $line): array {
                if (! str_contains($line, ':')) {
                    return [];
                }

                [$key, $value] = explode(':', $line, 2);

                return [trim($key) => trim($value)];
            })
            ->all();

        return [$frontMatter, $matches['markdown']];
    }

    private function timestampFor(string $date): int
    {
        if ($date === '') {
            return 0;
        }

        $normalizedDate = strtr(trim($date), [
            'Augustus' => 'August',
        ]);

        try {
            return CarbonImmutable::parse($normalizedDate)->getTimestamp();
        } catch (\Throwable) {
            return 0;
        }
    }

    private function renderMarkdown(string $markdown): string
    {
        $environment = new Environment([
            'html_input' => 'allow',
            'allow_unsafe_links' => false,
        ]);

        $environment->addExtension(new CommonMarkCoreExtension);
        $environment->addExtension(new AutolinkExtension);
        $environment->addExtension(new StrikethroughExtension);
        $environment->addExtension(new TableExtension);
        $environment->addExtension(new TaskListExtension);
        $environment->addExtension(new HighlightExtension);

        return (string) (new MarkdownConverter($environment))->convert($markdown);
    }
}
