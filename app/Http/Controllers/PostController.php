<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\Gate;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::latest()->with('user')->with('category')->paginate(10);
        return view('posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:200'],
            'body' => ['required', 'string', 'max:255'],
            'category_id' => ['required', 'string'],
            'tag_id' => ['required', 'string'],
            'privacy_id' => ['required', 'string'],
        ]);

        Post::create([...$data, 'user_id' => $request->user()->id]);
        return to_route('posts.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        $comments = $post->comments()->latest()->with('user')->paginate(10);
        return view('posts.show', compact('post','comments'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {

        Gate::authorize('update', $post); //handled by PostPolicy@update
        return view('posts.edit', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        Gate::authorize('update', $post); //handled by PostPolicy@update

        $data = $request->validate([
            'title' => ['required', 'string', 'max:200'],
            'body' => ['required', 'string', 'max:255'],
            // 'category_id' => ['required', 'string'],
            // 'tag_id' => ['required', 'string'],
            // 'privacy_id' => ['required', 'string'],
        ]);

        $post->update([...$data, 'user_id' => $request->user()->id]);
        return to_route('posts.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        Gate::authorize('delete', $post); //handled by PostPolicy@delete

        $post->delete();

        return to_route('posts.index');
    }

    public function search(Request $request){

        $query = $request->input('query');

        // Perform the search query
        $posts = Post::where('title', 'like', "%$query%")
                     ->orWhere('body', 'like', "%$query%")
                     ->with('user')
                     ->with('category')
                     ->paginate(10);

        return view('posts.index', compact('posts'));
    }


}
