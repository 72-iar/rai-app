<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PostController;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
    ]);
});

// Protect routes with authentication middleware
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // CRUD Routes for Posts
    Route::post('/posts', [PostController::class, 'store'])->name('posts.store'); // Create Post
    Route::get('/posts', [PostController::class, 'index'])->name('posts.index'); // Fetch All Posts
    Route::put('/posts/{post}', [PostController::class, 'update'])->name('posts.update'); // Edit Post
    Route::delete('/posts/{post}', [PostController::class, 'destroy'])->name('posts.destroy'); // Delete Post
});
