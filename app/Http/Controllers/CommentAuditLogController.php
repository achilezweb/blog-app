<?php

namespace App\Http\Controllers;

use App\Models\CommentAuditLog;
use Illuminate\Http\Request;

class CommentAuditLogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $logs = CommentAuditLog::latest()->paginate(10);;
        return view('comment-audit-logs.index', compact('logs'));
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
    public function show(CommentAuditLog $commentAuditLog)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CommentAuditLog $commentAuditLog)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CommentAuditLog $commentAuditLog)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CommentAuditLog $commentAuditLog)
    {
        //
    }

    public function search(Request $request){

        $data = $request->validate([
            'query' => ['required', 'string', 'max:200'],
        ]);

        $searchTerm = $request->input('query');

        // Perform the search query User model and eager load the 'roles' relationship
        $logs = CommentAuditLog::whereHas('comment', function ($query) use ($searchTerm) {
            $query->where('body', 'like', "%{$searchTerm}%");
        })->orwhereHas('updater', function ($query) use ($searchTerm) {
            $query->where('name', 'like', "%{$searchTerm}%")
                ->orWhere('email', 'like', "%{$searchTerm}%");
        })->orWhere('action', 'like', "%{$searchTerm}%")
          ->orWhere('changes', 'like', "%{$searchTerm}%")
        //   ->with(['comment','updater'])
          ->paginate(10);

        // $logs = CommentAuditLog::Where('action', 'like', "%{$searchTerm}%")
        //   ->orWhere('changes', 'like', "%{$searchTerm}%")
        //   ->paginate(10);

        return view('comment-audit-logs.index', compact('logs'));
    }

}
