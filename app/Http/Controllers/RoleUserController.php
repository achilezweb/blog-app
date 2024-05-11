<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRoleUserRequest;
use App\Http\Requests\UpdateRoleUserRequest;
use Illuminate\Http\Request;
use App\Models\RoleUser;

class RoleUserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roleUserPivot = RoleUser::all();
        return view('role_user', compact('roleUserPivot'));
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
    public function store(StoreRoleUserRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(RoleUser $roleUser)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(RoleUser $roleUser)
    {
        // Gate?
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRoleUserRequest $request, RoleUser $roleUser)
    {
        // Gate?
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RoleUser $roleUser)
    {
        // Gate?
    }
}
