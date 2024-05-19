<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Tag;
use App\Http\Requests\StoreTagPostRequest;
use App\Http\Requests\UpdateTagPostRequest;

class TagPostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tagPosts = Post::with('tags')->latest()->paginate(10); // Fetch all users with their roles
        return view('tag-post.index', compact('tagPosts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('tag-post.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTagPostRequest $request)
    {
        $request->validated();

        $post = Post::find($request->post_id);
        $tags = Tag::find($request->tag_id);

        $post->tags()->syncWithoutDetaching($request->tag_id); //better to use syncWithoutDetaching instead of attach

        return redirect()->route('tag-post.index')->with('success', 'TagPost created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $tagPost = Post::with('tags')->findOrFail($id);
        return view('tag-post.show', compact('tagPost'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $post = Post::with('tags')->findOrFail($id);
        $tags = Tag::all();
        return view('tag-post.edit', compact('post', 'tags'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTagPostRequest $request, $id)
    {
        $request->validated();

        $post = Post::findOrFail($id);
        $tags = Tag::find($request->tag_id);

        $post->tags()->sync($request->tag_id);  // Assuming single role replacement

        return redirect()->route('tag-post.index')->with('success', 'TagPost updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($postId, $tagId)
    {
        $post = Post::findOrFail($postId);
        $tags = Tag::findOrFail($tagId);

        $post->tags()->detach($tagId);

        return redirect()->route('tag-post.index')->with('success', 'TagPost removed successfully.');
    }
}
