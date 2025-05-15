<?php

use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'index');
Route::get('/posts/{id}', [PostController::class, 'show']);
