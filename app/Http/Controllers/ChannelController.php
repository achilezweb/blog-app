<?php

namespace App\Http\Controllers;

use App\Models\Channel;
use Illuminate\Http\Request;
use App\Http\Requests\StoreChannelRequest;
use App\Http\Requests\UpdateChannelRequest;

class ChannelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $channels = Channel::where('user_id', auth()->id()) // Filter by the logged-in user's ID
                        ->latest()
                        ->paginate(10);

        return view('channels.index', compact('channels'));
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
    public function store(StoreChannelRequest $request)
    {
        
        // Save the prompt and response in the database
        Channel::create([
            'name' => $request->input('name'),
            'user_id' => $request->user()->id,
        ]);

        // Chatgpt::create($request->validated());
        return redirect()->route('channels.index')->with('success', 'Channel saved!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Channel $channel)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Channel $channel)
    {
        return view('channels.edit', compact('channel'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateChannelRequest $request, Channel $channel)
    {
        $channel->update($request->validated());
        return redirect()->route('channels.index')->with('success', 'Channel updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Channel $channel)
    {
        $channel->delete();
        return redirect()->route('channels.index')->with('success', 'Channel deleted successfully.');
    }

    public function search(Request $request){

        $data = $request->validate([
            'query' => ['required', 'string', 'max:200'],
        ]);

        $query = $request->input('query');

        // Perform the search query
        $channels = Channel::where('name', 'like', "%$query%")
                        ->where('user_id', auth()->user()->id)
                        ->with('user')
                        ->paginate(10);

        return view('channels.index', compact('channels'));
    }

}
