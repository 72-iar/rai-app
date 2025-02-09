<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index()
    {
        $posts = Post::with('author:id,first_name,last_name')->latest()->get(); // ✅ Fetch with author name

        return Inertia::render('Dashboard', [
            'auth' => [
                'user' => Auth::user()
            ],
            'posts' => $posts
        ]);
    }
}

