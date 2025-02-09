<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    // Store a new post
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|in:news,update,task',
            'message' => 'required|string',
            'author_id' => 'required|exists:users,id',
        ]);

        Post::create($validated);

        return redirect()->route('dashboard')->with('success', 'Post created successfully.');
    }

    // ✅ Add this method to update an existing post
    public function update(Request $request, Post $post)
    {
        // Ensure the logged-in user is the author of the post
        if ($request->user()->id !== $post->author_id) {
            return redirect()->route('dashboard')->with('error', 'Unauthorized action.');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|in:news,update,task',
            'message' => 'required|string',
        ]);

        $post->update($validated);

        return redirect()->route('dashboard')->with('success', 'Post updated successfully.');
    }

    // Delete a post
    public function destroy(Post $post)
    {
        // Ensure the logged-in user is the author of the post
        if (auth()->id() !== $post->author_id) {
            return redirect()->route('dashboard')->with('error', 'Unauthorized action.');
        }

        $post->delete();

        return redirect()->route('dashboard')->with('success', 'Post deleted successfully.');
    }
}

