<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use App\Http\Requests\StoreCategoryPostRequest;
use App\Http\Requests\UpdateCategoryPostRequest;

class CategoryPostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categoryPosts = Post::with('categories')->latest()->paginate(10); // Fetch all users with their roles
        return view('category-post.index', compact('categoryPosts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('category-post.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryPostRequest $request)
    {
        $request->validated();

        $post = Post::find($request->post_id);
        $categories = Category::find($request->category_id);

        $post->categories()->syncWithoutDetaching($request->category_id); //better to use syncWithoutDetaching instead of attach

        return redirect()->route('category-post.index')->with('success', 'CategoryPost created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $categoryPost = Post::with('categories')->findOrFail($id);
        return view('category-post.show', compact('categoryPost'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $post = Post::with('categories')->findOrFail($id);
        $categories = Category::all();
        return view('category-post.edit', compact('post', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryPostRequest $request, $id)
    {
        $request->validated();

        $post = Post::findOrFail($id);
        $categories = Category::find($request->category_id);

        $post->categories()->sync($request->category_id);  // Assuming single role replacement

        return redirect()->route('category-post.index')->with('success', 'CategoryPost updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($postId, $categoryId)
    {
        $post = Post::findOrFail($postId);
        $categories = Category::findOrFail($categoryId);

        $post->categories()->detach($categoryId);

        return redirect()->route('category-post.index')->with('success', 'CategoryPost removed successfully.');
    }
}
