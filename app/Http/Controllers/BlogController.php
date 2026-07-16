<?php

namespace App\Http\Controllers;

use App\Support\Blog\PostRepository;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Response;

class BlogController extends Controller
{
    public function __construct(protected PostRepository $posts)
    {
    }

    public function index(): View
    {
        $tracking = config('blog.project_tracking', []);

        $projects = collect(config('blog.projects', []))->map(function (array $project) use ($tracking) {
            if ($tracking !== []) {
                $project['url'] .= (str_contains($project['url'], '?') ? '&' : '?').http_build_query($tracking);
            }

            return $project;
        })->all();

        return view('blog.index', [
            'posts' => $this->posts->all(),
            'projects' => $projects,
            'pageTitle' => config('blog.site_title'),
            'pageDescription' => config('blog.home_description'),
            'canonicalUrl' => url('/'),
        ]);
    }

    public function posts(): View
    {
        return view('blog.posts', [
            'posts' => $this->posts->all(),
            'pageTitle' => 'Posts - '.config('blog.site_title'),
            'pageDescription' => 'Posts by '.config('blog.author').' on software engineering, side projects, and practical lessons.',
            'canonicalUrl' => route('posts'),
        ]);
    }

    public function show(string $slug): View
    {
        $post = $this->posts->find($slug);

        abort_if($post === null, 404);

        $adjacent = $this->posts->adjacent($slug);

        return view('blog.post', [
            'post' => $post,
            'newerPost' => $adjacent['newer'],
            'olderPost' => $adjacent['older'],
            'pageTitle' => "{$post->title} - ".config('blog.site_title'),
            'pageDescription' => $post->description,
            'canonicalUrl' => $post->url(),
        ]);
    }

    public function feed(): Response
    {
        $posts = $this->posts->all();

        return response()
            ->view('blog.feed', [
                'posts' => $posts,
                'updatedAt' => $posts->first()?->publishedAtIso8601 ?? now()->toAtomString(),
            ])
            ->header('Content-Type', 'application/atom+xml; charset=UTF-8');
    }
}
