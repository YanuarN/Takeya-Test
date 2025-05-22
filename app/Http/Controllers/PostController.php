<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;

class PostController extends BaseController
{

    use AuthorizesRequests;

    public function __construct()
    {
        // Apply auth middleware only to specific methods
        $this->middleware('auth')->except(['index', 'show', 'publicIndex']);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Auth::check()) {
            $posts = Post::where('user_id', Auth::id())->paginate(10);
            return view('home', compact('posts'));
        }
        return view('home'); // Tampilkan halaman home untuk guest
    }

    public function publicIndex()
    {
        $posts = Post::where('status', 'active')
            ->where('published_date', '<=', now())
            ->paginate(10);
        return view('posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePostRequest $request)
    {
        $validated = $request->validated();
        $validated['user_id'] = Auth::user()->id;

        if ($request->filled('save_as_draft')) {
            $validated['status'] = 'draft';
        } else {
            $publishedDate = new \DateTime($validated['published_date']);
            $now = new \DateTime();

            $validated['status'] = ($publishedDate <= $now)
                ? 'active'
                : 'scheduled';
        }

        Post::create($validated);
        return redirect()->route('posts.index')->with('success', 'Post created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        return view('posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        $this->authorize('update', $post);
        return view('posts.edit', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePostRequest $request, Post $post)
    {
        // Authorization is already checked in the UpdatePostRequest

        $validated = $request->validated();

        // Handle post status based on form submission
        if ($request->has('save_as_draft')) {
            $validated['status'] = 'draft';
        } elseif (isset($validated['published_date'])) {
            $published_date = new \DateTime($validated['published_date']);
            $now = new \DateTime();

            $validated['status'] = ($published_date <= $now) ? 'active' : 'scheduled';
        }

        $post->update($validated);

        return redirect()->route('posts.index')->with('success', 'Post updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        // Check if user is authorized to delete this post
        $this->authorize('delete', $post);

        $post->delete();

        return redirect()->route('home')->with('success', 'Post deleted successfully.');
    }
}
