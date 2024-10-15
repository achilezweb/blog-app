<?php

namespace App\Http\Controllers;

use App\Models\Chatgpt;
use Illuminate\Http\Request;
use OpenAI\Laravel\Facades\OpenAI;
use App\Http\Requests\StoreChatgptRequest;
use App\Models\Channel;

class ChatgptController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $chatgpts = Chatgpt::all();
        $chatgpts = Chatgpt::latest()->paginate(10);
        $channels = Channel::where('user_id', auth()->id()) // Filter by the logged-in user's ID
                        ->latest()
                        ->paginate(10);

        return view('chatgpts.index', compact('chatgpts','channels'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('chatgpts.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreChatgptRequest $request)
    {
        // Fetch previous messages from the database for this user
        $previousMessages = Chatgpt::where('user_id', $request->user()->id)
                                    ->orderBy('created_at', 'asc')
                                    ->get();

        // Prepare messages array with previous messages
        $messages = [];
        foreach ($previousMessages as $msg) {
            $messages[] = ['role' => $msg->role, 'content' => $msg->prompt];
            $messages[] = ['role' => 'assistant', 'content' => $msg->response];
        }

        // Add the new user message
        $messages[] = ['role' => 'user', 'content' => $request->input('prompt')];



        // Call the OpenAI API
        $model = 'gpt-4o-2024-05-13'; //gpt-4o-2024-05-13, gpt-4o-mini, gpt-4,
        $role = 'user';
        $result = OpenAI::chat()->create([
            'model' => $model,
            'messages' => $messages,
        ]);

        // Save the prompt and response in the database
        Chatgpt::create([
            'prompt' => $request->input('prompt'),
            'response' => $result->choices[0]->message->content,
            'model' => $model,
            'role' => $role,
            'user_id' => $request->user()->id,
            'channel_id' => $request->input('channel_id'),
        ]);

        // Chatgpt::create($request->validated());
        return redirect()->route('chatgpts.index')->with('success', 'Prompt/Response saved!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Chatgpt $chatgpt)
    {
        return view('chatgpts.show', compact('chatgpt'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Chatgpt $chatgpt)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Chatgpt $chatgpt)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Chatgpt $chatgpt)
    {
        //
    }
}
