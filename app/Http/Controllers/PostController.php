<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\Gate;
use App\Models\Tag;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $posts = Post::latest()->with('user')->with('category')->paginate(10);
        $posts = Post::latest()->with('user')->paginate(10);
        $tags = Tag::all(); // Fetch all tags
        $categories = Category::all(); // Fetch all categories
        return view('posts.index', compact('posts', 'tags', 'categories'));
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
            'tags' => ['required', 'array'],
            'tags.*' => ['exists:tags,id'],
            'categories' => ['required', 'array'],
            'categories.*' => ['exists:categories,id'],

            'privacy_id' => ['required', 'string'],
        ]);

        $post = Post::create([...$data, 'user_id' => $request->user()->id]);
        $post->tags()->sync($request->tags); //best compared to attach
        $post->categories()->sync($request->categories); //best compared to attach

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
        $tags = Tag::all(); // Fetch all tags
        $categories = Category::all(); // Fetch all categories
        return view('posts.edit', compact('post', 'tags', 'categories'));
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
            'tags' => ['required', 'array'],
            'tags.*' => ['exists:tags,id'],
            'categories' => ['required', 'array'],
            'categories.*' => ['exists:categories,id'],

            // 'privacy_id' => ['required', 'string'],
        ]);

        $post->update([...$data, 'user_id' => $request->user()->id]);
        $post->tags()->sync($request->tags); //best compared to attach
        $post->categories()->sync($request->categories); //best compared to attach
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

        $data = $request->validate([
            'query' => ['required', 'string', 'max:200'],
        ]);

        $query = $request->input('query');

        // Perform the search query
        $posts = Post::where('title', 'like', "%$query%")
                     ->orWhere('body', 'like', "%$query%")
                     ->with('user')
                     ->paginate(10);

        $tags = Tag::all(); // Fetch all tags

        return view('posts.index', compact('posts', 'tags'));
    }


}
