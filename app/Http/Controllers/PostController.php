<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Str;
use League\CommonMark\Environment\Environment;
use League\CommonMark\Extension\CommonMark\CommonMarkCoreExtension;
use League\CommonMark\Extension\FrontMatter\FrontMatterExtension;
use League\CommonMark\MarkdownConverter;
use Tempest\Highlight\CommonMark\HighlightExtension;
use Tempest\Highlight\Highlighter;

class PostController extends Controller
{
    public function show(string $id)
    {
        $highlighter = new Highlighter;

        $environment = new Environment([
            'html_input' => 'allow',
        ]);
        $environment
            ->addExtension(new CommonMarkCoreExtension)
            ->addExtension(new HighlightExtension($highlighter))
            ->addExtension(new FrontMatterExtension);

        $markdown = new MarkdownConverter($environment);

        $filePath = resource_path("posts/{$id}.md");
        if (! file_exists($filePath)) {
            abort(404);
        }

        $contents = file_get_contents($filePath);

        /** @var \League\CommonMark\Extension\FrontMatter\FrontMatterInterface $result */
        $result = $markdown->convert(Blade::render($contents));
        $info = $result->getFrontMatter();

        $title = $info['title'] ?? '';
        $date = $info['date'] ?? '';
        $readingTime = ceil(Str::wordCount(strip_tags((string) $result)) / 100);

        return view('post', [
            'title' => $title,
            'date' => $date,
            'readingTime' => $readingTime,
            'content' => $result,
        ]);
    }
}
