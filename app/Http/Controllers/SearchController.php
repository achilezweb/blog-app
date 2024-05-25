<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Post;
use App\Models\Role;
use Illuminate\Http\Request;

class SearchController extends Controller
{

    public function index(Request $request)
    {
        $searchTerm = $request->input('search');

        // Search in Users
        $users = User::query()
                     ->where('name', 'LIKE', "%{$searchTerm}%")
                     ->orWhere('email', 'LIKE', "%{$searchTerm}%")
                     ->limit(10)
                     ->get();

        // Search in Posts
        $posts = Post::query()
                     ->where('title', 'LIKE', "%{$searchTerm}%")
                     ->orWhere('body', 'LIKE', "%{$searchTerm}%")
                     ->limit(10)
                     ->get();

        // Search in Roles
        $roles = Role::query()
                     ->where('name', 'LIKE', "%{$searchTerm}%")
                     ->limit(10)
                     ->get();

        return view('search.index', compact('users', 'posts', 'roles', 'searchTerm'));

        // route/web.php
        // Route::get('/search', [SearchController::class, 'index'])->name('search');

        // blade file

// <div class="container">
//     <h1>Search Results for "{{ $searchTerm }}"</h1>

//     <h2>Users</h2>
//     <ul>
//         @forelse ($users as $user)
//             <li>{{ $user->name }} - {{ $user->email }}</li>
//         @empty
//             <li>No users found.</li>
//         @endforelse
//     </ul>

//     <h2>Posts</h2>
//     <ul>
//         @forelse ($posts as $post)
//             <li>{{ $post->title }}</li>
//         @empty
//             <li>No posts found.</li>
//         @endforelse
//     </ul>

//     <h2>Roles</h2>
//     <ul>
//         @forelse ($roles as $role)
//             <li>{{ $role->name }}</li>
//         @empty
//             <li>No roles found.</li>
//         @endforelse
//     </ul>
// </div>
// @endsection

    }

}
