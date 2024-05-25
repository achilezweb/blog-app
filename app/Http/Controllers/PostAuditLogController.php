<?php

namespace App\Http\Controllers;

use App\Models\PostAuditLog;
use Illuminate\Http\Request;

class PostAuditLogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $logs = PostAuditLog::latest()->paginate(10);;
        return view('post-audit-logs.index', compact('logs'));
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
    public function show(PostAuditLog $postAuditLog)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PostAuditLog $postAuditLog)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PostAuditLog $postAuditLog)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PostAuditLog $postAuditLog)
    {
        //
    }

    public function search(Request $request){

        $data = $request->validate([
            'query' => ['required', 'string', 'max:200'],
        ]);

        $searchTerm = $request->input('query');

        // Perform the search query User model and eager load the 'roles' relationship
        $logs = PostAuditLog::whereHas('post', function ($query) use ($searchTerm) {
            $query->where('title', 'like', "%{$searchTerm}%")
                ->orWhere('body', 'like', "%{$searchTerm}%");
        })->orwhereHas('updater', function ($query) use ($searchTerm) {
            $query->where('name', 'like', "%{$searchTerm}%")
                ->orWhere('email', 'like', "%{$searchTerm}%");
        })->orWhere('action', 'like', "%{$searchTerm}%")
          ->orWhere('changes', 'like', "%{$searchTerm}%")
        //   ->with(['post','updater'])
          ->paginate(10);

        // $logs = PostAuditLog::Where('action', 'like', "%{$searchTerm}%")
        //   ->orWhere('changes', 'like', "%{$searchTerm}%")
        //   ->paginate(10);

        return view('post-audit-logs.index', compact('logs'));
    }

}
