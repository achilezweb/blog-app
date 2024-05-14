<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRoleUserRequest;
use App\Http\Requests\UpdateRoleUserRequest;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;

class RoleUserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $roleUserPivot = RoleUser::all();
        // return view('role_user.index', compact('roleUserPivot'));

        //Gate?
        $roleUsers = User::with('roles')->paginate(10); // Fetch all users with their roles
        return view('roleUsers.index', compact('roleUsers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //Gate?
        return view('roleUsers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //Gate?
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'role_id' => 'required|exists:roles,id',
        ]);

        $user = User::find($request->user_id);
        $role = Role::find($request->role_id);

        // Prevent admins from creating or assigning the superadmin role
        if (auth()->user()->hasRoles('admin') && !auth()->user()->hasRoles('superadmin') && $role->name === 'superadmin') {
            return back()->with('error', 'Admins cannot assign the superadmin role.');
        }

        $user->roles()->syncWithoutDetaching($request->role_id); //better to use syncWithoutDetaching instead of attach

        return redirect()->route('roleUsers.index')->with('success', 'RoleUser created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id) //RoleUser $roleUser
    {
        //Gate?
        $roleUser = User::with('roles')->findOrFail($id);
        return view('roleUsers.show', compact('roleUser'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id) //RoleUser $roleUser
    {
        // Gate?
        $user = User::with('roles')->findOrFail($id);
        $roles = Role::all();
        return view('roleUsers.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id) //RoleUser $roleUser
    {
        // Gate?
        $request->validate([
            'role_id' => 'required|exists:roles,id',
        ]);

        $user = User::findOrFail($id);
        $role = Role::find($request->role_id);

        // Prevent admins from creating or assigning the superadmin role
        if (auth()->user()->hasRoles('admin') && !auth()->user()->hasRoles('superadmin') && $role->name === 'superadmin') {
            return back()->with('error', 'Admins cannot update the superadmin role.');
        }

        $user->roles()->sync($request->role_id);  // Assuming single role replacement

        return redirect()->route('roleUsers.index')->with('success', 'RoleUser updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($userId, $roleId)
    {
        // Gate?
        $user = User::findOrFail($userId);
        $role = Role::findOrFail($roleId);

        // Prevent admins from creating or assigning the superadmin role
        if (auth()->user()->hasRoles('admin') && !auth()->user()->hasRoles('superadmin') && $role->name === 'superadmin') {
            return back()->with('error', 'Admins cannot remove the superadmin role.');
        }

        $user->roles()->detach($roleId);

        return redirect()->route('roleUsers.index')->with('success', 'RoleUser removed successfully.');
    }
}
