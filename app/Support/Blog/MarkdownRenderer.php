<?php

namespace App\Support\Blog;

use Illuminate\Support\HtmlString;
use League\CommonMark\Environment\Environment;
use League\CommonMark\Extension\CommonMark\CommonMarkCoreExtension;
use League\CommonMark\Extension\GithubFlavoredMarkdownExtension;
use League\CommonMark\MarkdownConverter;
use Tempest\Highlight\CommonMark\HighlightExtension;
use Tempest\Highlight\Highlighter;

class MarkdownRenderer
{
    protected MarkdownConverter $converter;

    public function __construct()
    {
        $environment = new Environment([
            'html_input' => 'allow',
            'allow_unsafe_links' => false,
            'disallowed_raw_html' => [
                // GFM blocks iframes by default; allow them for embedded videos in posts.
                'disallowed_tags' => [
                    'title',
                    'textarea',
                    'style',
                    'xmp',
                    'noembed',
                    'noframes',
                    'script',
                    'plaintext',
                ],
            ],
        ]);

        $environment
            ->addExtension(new CommonMarkCoreExtension())
            ->addExtension(new GithubFlavoredMarkdownExtension())
            ->addExtension(new HighlightExtension(new Highlighter()));

        $this->converter = new MarkdownConverter($environment);
    }

    public function render(string $markdown): HtmlString
    {
        return new HtmlString((string) $this->converter->convert($markdown));
    }
}
