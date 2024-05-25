<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Gate;

class UserController extends Controller
{

    public function index()
    {
        // Logic to fetch and display users
        $query = User::whereDoesntHave('roles', function ($query) {
            $query->where('name', 'superadmin');
        })->latest(); //latest();

        if (auth()->user()->hasRoles('superadmin')) {
            $query = User::latest();
        }

        $users = $query->paginate(10);

        // return $users;
        return view('users.index', compact('users'));
    }

    public function create()
    {
        // Logic to show user creation form
        return view('users.create');
    }

    public function store(UserRequest $request)
    {
        //Gate::authorize('create', $user); //handled by UserPolicy@create
        // Logic to store a new
        $user = User::create($request->validated());

        //assign user default role on the newly created user
        $roles = Role::name('user')->first();
        $user->roles()->syncWithoutDetaching($roles->id); //better to use syncWithoutDetaching instead of attach

        return redirect()->route('users.index')->with('success', 'User created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //Gate?
        return view('users.show', compact('user'));
    }

    public function edit(User $user)
    {
        Gate::authorize('update', $user); //handled by UserPolicy@update
        // Logic to show user edit form
        return view('users.edit', compact('user'));
    }

    public function update(UserRequest $request, User $user)
    {
        Gate::authorize('update', $user); //handled by UserPolicy@update
        // Logic to update a user
        $validated = $request->validated();

        // Only update the password if it's provided and not empty
        if (empty($validated['password'])) {
            unset($validated['password']); // Do not attempt to update the password if it's not provided
        }

        $user->update($validated);
        return redirect()->route('users.index')->with('success', 'User updated successfully.');
    }

    public function destroy(User $user)
    {
        // Gate::authorize('delete', $user); //handled by UserPolicy@delete
        // Logic to delete a

        $user->roles()->detach($user->roles);
        //need also to detach the comments
        $user->delete();
        return redirect()->route('users.index')->with('success', 'User deleted successfully.');
    }

    public function search(Request $request){

        $data = $request->validate([
            'query' => ['required', 'string', 'max:200'],
        ]);

        $searchTerm = $request->input('query');

        $query = User::whereDoesntHave('roles', function ($query) {
            $query->where('name', 'superadmin');
        })->latest(); //latest();

        if (auth()->user()->hasRoles('superadmin')) {
            $query = User::latest();
        }

        $users = $query->when($searchTerm, function ($query, $searchTerm) {
            return $query->where(function ($q) use ($searchTerm) {
                $q->where('name', 'like', '%' . $searchTerm . '%')
                  ->orWhere('email', 'like', '%' . $searchTerm . '%');
            });
        })->paginate(10);

        return view('users.index', compact('users'));
    }

    public function showDeleted()
    {
        $users = User::onlyTrashed()->paginate(10);
        return view('users.deleted', compact('users'));
    }

    public function restore($id)
    {
        $user = User::onlyTrashed()->findOrFail($id);
        $user->restore();

        return redirect()->route('users.deleted')->with('success', 'User restored successfully.');
    }

}
