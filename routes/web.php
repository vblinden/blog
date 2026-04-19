<?php

use App\Http\Controllers\BlogController;
use App\Support\Blog\PostRepository;
use Illuminate\Support\Facades\Route;

Route::get('/', [BlogController::class, 'index'])->name('home');
Route::get('/posts/{slug}', [BlogController::class, 'show'])->name('posts.show');
Route::get('/sitemap.xml', function (PostRepository $posts) {
    return response()
        ->view('blog.sitemap', ['posts' => $posts->all()])
        ->header('Content-Type', 'application/xml');
})->name('sitemap');
Route::get('/robots.txt', function () {
    return response(view('blog.robots'), 200, ['Content-Type' => 'text/plain; charset=UTF-8']);
})->name('robots');
