<?php

namespace App\Http\Controllers;

use App\Support\Blog\PostRepository;
use Illuminate\Contracts\View\View;

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
        ]);
    }

    public function show(string $slug): View
    {
        $post = $this->posts->find($slug);

        abort_if($post === null, 404);

        return view('blog.post', [
            'post' => $post,
            'pageTitle' => "{$post->title} - ".config('blog.site_title'),
            'pageDescription' => $post->description,
            'canonicalUrl' => $post->url(),
        ]);
    }
}
