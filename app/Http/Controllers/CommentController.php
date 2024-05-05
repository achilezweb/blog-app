<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCommentRequest;
use App\Http\Requests\UpdateCommentRequest;
use App\Models\Comment;
use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\Gate;


class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function store(Request $request, Post $post)
    {
        $data = $request->validate(['body' => ['required', 'string', 'max:255']]);

        $post->comments()->create([...$data, 'user_id' => $request->user()->id]);
        return to_route('posts.show', $post)->withFragment('comments');

    }

    /**
     * Display the specified resource.
     */
    public function show(Comment $comment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post, Comment $comment)
    {

        Gate::authorize('update', $comment); //handled by CommentPolicy@update

        return view('posts.comments.edit', [
            'post' => $post,
            'comment' => $comment,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post, Comment $comment)
    {
        Gate::authorize('update', $comment); //handled by CommentPolicy@update

        $data = $request->validate([
            'body' => ['required', 'string', 'max:255'],
        ]);

        $comment->update([...$data, 'user_id' => $request->user()->id]);
        return to_route('posts.show', $post)->withFragment('comments');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post, Comment $comment)
    {
        Gate::authorize('delete', $comment); //handled by CommentPolicy@delete

        $comment->delete();

        return to_route('posts.show', $post)->withFragment('comments');

    }
}
