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
}
