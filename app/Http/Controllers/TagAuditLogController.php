<?php

namespace App\Http\Controllers;

use App\Models\TagAuditLog;
use Illuminate\Http\Request;

class TagAuditLogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $logs = TagAuditLog::latest()->paginate(10);;
        return view('tag-audit-logs.index', compact('logs'));
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
    public function show(TagAuditLog $tagAuditLog)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TagAuditLog $tagAuditLog)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TagAuditLog $tagAuditLog)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TagAuditLog $tagAuditLog)
    {
        //
    }
}
