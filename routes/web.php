<?php

use App\Http\Controllers\BlogController;
use App\Support\Blog\PostRepository;
use App\Support\PennyMetrics;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;

Route::get('/', [BlogController::class, 'index'])->name('home');
Route::get('/posts', [BlogController::class, 'posts'])->name('posts');
Route::redirect('/writing', '/posts', 301);
Route::get('/posts/{slug}', [BlogController::class, 'show'])->name('posts.show');
Route::get('/feed', [BlogController::class, 'feed'])->name('feed');
Route::get('/feed.xml', [BlogController::class, 'feed'])->name('feed.xml');
Route::get('/sitemap.xml', function (PostRepository $posts) {
    return response()
        ->view('blog.sitemap', ['posts' => $posts->all()])
        ->header('Content-Type', 'application/xml; charset=UTF-8');
})->name('sitemap');
Route::get('/robots.txt', function () {
    return response()
        ->view('blog.robots')
        ->header('Content-Type', 'text/plain; charset=UTF-8');
})->name('robots');

Route::get('/pm/stats.js', function (Request $request) {
    $response = Http::withHeaders(PennyMetrics::upstreamHeaders($request))
        ->get('https://pennymetrics.dev/stats.js');

    return response($response->body(), $response->status())
        ->header('Content-Type', $response->header('Content-Type') ?? 'application/javascript');
});

Route::get('/pm/i.gif', function (Request $request) {
    $response = Http::withHeaders(PennyMetrics::upstreamHeaders($request))
        ->get('https://pennymetrics.dev/api/i.gif', $request->query());

    return response($response->body(), $response->status())
        ->header('Content-Type', $response->header('Content-Type') ?? 'image/gif');
});
