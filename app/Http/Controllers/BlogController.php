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
        return view('blog.index', [
            'posts' => $this->posts->all(),
            'projects' => config('blog.projects', []),
            'pageTitle' => config('blog.site_title'),
            'pageDescription' => config('blog.home_description'),
            'canonicalUrl' => url('/'),
            'useSiteTitleHeading' => true,
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
            'useSiteTitleHeading' => false,
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
