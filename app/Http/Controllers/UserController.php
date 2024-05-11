<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class UserController extends Controller
{

    public function index()
    {
        // Logic to fetch and display users
    }

    public function create()
    {
        // Logic to show user creation form
    }

    public function store(Request $request)
    {
        //Gate::authorize('create', $user); //handled by UserPolicy@create
        // Logic to store a new user
    }

    public function edit(User $user)
    {
        Gate::authorize('update', $user); //handled by UserPolicy@update
        // Logic to show user edit form
    }

    public function update(Request $request, User $user)
    {
        Gate::authorize('update', $user); //handled by UserPolicy@update
        // Logic to update a user
    }

    public function destroy(User $user)
    {
        Gate::authorize('delete', $user); //handled by UserPolicy@delete
        // Logic to delete a user
    }

    /**
     * manage method
     *
     * @param User $user
     * @return void
     */
    public function manage(User $user)
    {
        Gate::authorize('manage', $user); //handled by UserPolicy@manage

        // Logic for managing users
    }

    public function createSuperadmin(User $user)
    {
        Gate::authorize('manageSuperadmin', $user); //handled by UserPolicy@manageSuperadmin

        // Logic for managing superadmin
    }

}
