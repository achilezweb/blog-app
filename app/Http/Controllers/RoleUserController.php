<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\StoreRoleUserRequest;
use App\Http\Requests\UpdateRoleUserRequest;

class RoleUserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roleUsers = User::with('roles')->paginate(10); // Fetch all users with their roles
        return view('role-user.index', compact('roleUsers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //Gate?
        return view('role-user.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRoleUserRequest $request)
    {
        $request->validated();

        $user = User::find($request->user_id);
        $roles = Role::find($request->role_id);

        $user->roles()->syncWithoutDetaching($request->role_id); //better to use syncWithoutDetaching instead of attach

        return redirect()->route('role-user.index')->with('success', 'RoleUser created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id) //RoleUser $roleUser
    {
        $roleUser = User::with('roles')->findOrFail($id);
        return view('role-user.show', compact('roleUser'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id) //RoleUser $roleUser
    {
        $user = User::with('roles')->findOrFail($id);
        $roles = Role::all();
        return view('role-user.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRoleUserRequest $request, $id) //RoleUser $roleUser
    {
        $request->validated();

        $user = User::findOrFail($id);
        $roles = Role::find($request->role_id);

        $roleHasSuperAdmin = $roles->contains(function ($role) {
            return $role['name'] === 'superadmin'; //$role field has superadmin
        });

        // Rules: Prevent admins from creating or assigning the superadmin role
        if (auth()->user()->hasRoles('admin') && !auth()->user()->hasRoles('superadmin') && $roleHasSuperAdmin) {
            return back()->with('error', 'Admins cannot update the superadmin role.');
        }

        $user->roles()->sync($request->role_id);  // Assuming single role replacement

        return redirect()->route('role-user.index')->with('success', 'RoleUser updated successfully.');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($userId, $roleId)
    {
        $user = User::findOrFail($userId);
        $roles = Role::findOrFail($roleId);

        $user->roles()->detach($roleId);

        return redirect()->route('role-user.index')->with('success', 'RoleUser removed successfully.');
    }

    public function search(Request $request){

        $data = $request->validate([
            'query' => ['required', 'string', 'max:200'],
        ]);

        $searchTerm = $request->input('query');

        // Perform the search query User model and eager load the 'roles' relationship
        $roleUsers = User::whereHas('roles', function ($query) use ($searchTerm) {
            $query->where('name', 'like', "%{$searchTerm}%")
                ->orWhere('description', 'like', "%{$searchTerm}%");
        })->orWhere('name', 'like', "%{$searchTerm}%")
          ->orWhere('email', 'like', "%{$searchTerm}%")
          ->with('roles')
          ->paginate(10);

        return view('role-user.index', compact('roleUsers'));
    }

}
