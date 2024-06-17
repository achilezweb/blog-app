<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\FriendRequest;

class FriendRequestController extends Controller
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(FriendRequest $friendRequest)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(FriendRequest $friendRequest)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, FriendRequest $friendRequest)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FriendRequest $friendRequest)
    {
        //
    }

    public function sendRequest(Request $request)
    {
        $friend = User::where('username', $request->username)->firstOrFail();
        $request = new FriendRequest();
        $request->user_id = auth()->id();
        $request->friend_id = $friend->id;
        $request->save();

        return back()->with('success', 'Friend request sent.');
    }

    public function acceptRequest(FriendRequest $friendRequest)
    {
        $friendRequest->update(['status' => 'accepted']);
        auth()->user()->addFriend($friendRequest->user);

        return back()->with('success', 'Friend request accepted.');
    }
}
