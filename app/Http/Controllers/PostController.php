<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\Gate;
use App\Models\Tag;
use App\Models\User;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $posts = Post::latest()->with('user')->with('category')->paginate(10);
        // $posts = Post::latest()->with('user')->paginate(10);

        // $posts = auth()->user()->posts()->orderBy('is_pinned', 'desc')->orderBy('created_at', 'desc')->paginate(10); //if displaying your own post

        // Fetch posts, prioritizing pinned posts
        $posts = Post::orderBy('is_pinned', 'desc') // Pinned posts first
            ->orderBy('created_at', 'desc') // Then by creation date
            ->paginate(10); // Adjust pagination as needed

        $tags = Tag::all(); // Fetch all tags
        $categories = Category::all(); // Fetch all categories
        $users = User::all();
        return view('posts.index', compact('posts', 'tags', 'categories', 'users'));
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
    public function store(StorePostRequest $request)
    {
        //no gate
        $validatedData = $request->validated();

        // Add user_id to the validated data
        $validatedData['user_id'] = $request->user()->id;

        // Parse mentions in the post body
        $validatedData['body'] = $this->parseMentions($validatedData['body']);

        $post = Post::create($validatedData);
        $post->tags()->sync($request->tags); //best compared to attach
        $post->categories()->sync($request->categories); //best compared to attach
        $post->taggedUsers()->sync($request->tagged_users);

        return to_route('posts.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        $post->increment('page_views');


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
        $users = User::all();
        return view('posts.edit', compact('post', 'tags', 'categories', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePostRequest $request, Post $post)
    {
        Gate::authorize('update', $post); //handled by PostPolicy@update

        $validatedData = $request->validated();

        // Add user_id to the validated data
        $validatedData['user_id'] = $request->user()->id;

        $post->update($validatedData);
        $post->tags()->sync($request->tags); //best compared to attach
        $post->categories()->sync($request->categories); //best compared to attach
        $post->taggedUsers()->sync($request->tagged_users);
        return to_route('posts.index');
    }

    /**
     * Parse @mentions in the text and convert them to links.
     *
     * @param string $body
     * @return string
     */
    protected function parseMentions($body)
    {
        preg_match_all('/@([\w.-]+)/', $body, $matches);
        $usernames = $matches[1];

        $users = User::whereIn('username', $usernames)->get();

        foreach ($users as $user) {
            $link = "<a href='" . route('users.show', $user->id) . "'>@$user->username</a>";
            $body = str_replace("@$user->username", $link, $body);
        }

        return $body;
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

    public function showDeleted()
    {
        $posts = Post::onlyTrashed()->paginate(10);
        return view('posts.deleted', compact('posts'));
    }

    public function restore($id)
    {
        $post = Post::onlyTrashed()->findOrFail($id);
        $post->restore();

        return redirect()->route('posts.deleted')->with('success', 'Post restored successfully.');
    }

    public function like(Post $post)
    {
        $user = auth()->user(); //Auth::user();
        $user->likedPosts()->syncWithoutDetaching([$post->id]);

        return back()->with('success', 'You liked the post.');
    }

    public function unlike(Post $post)
    {
        $user = auth()->user(); //Auth::user();
        $user->likedPosts()->detach($post->id);

        return back()->with('success', 'You unliked the post.');
    }

    public function share(Post $post)
    {
        $user = auth()->user();
        $user->sharedPosts()->syncWithoutDetaching([$post->id]);
        // $post->shares()->create(['user_id' => $user->id()]); // Assuming users are logged in

        return back()->with('success', 'Post shared successfully.');
    }

    public function pin(Post $post)
    {
        $post->update(['is_pinned' => true]);
        return redirect()->back()->with('success', 'Post pinned successfully.');
    }

    public function unpin(Post $post)
    {
        $post->update(['is_pinned' => false]);
        return redirect()->back()->with('success', 'Post unpinned successfully.');
    }

}
