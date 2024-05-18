<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class CategoryPostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //Gate?
        $categoryPosts = Post::with('categories')->latest()->paginate(10); // Fetch all users with their roles
        return view('category-post.index', compact('categoryPosts'));
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(CategoryPost $categoryPost)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CategoryPost $categoryPost)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CategoryPost $categoryPost)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CategoryPost $categoryPost)
    {
        //
    }
}
