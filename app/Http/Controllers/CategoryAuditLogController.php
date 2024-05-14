<?php

namespace App\Http\Controllers;

use App\Models\CategoryAuditLog;
use Illuminate\Http\Request;

class CategoryAuditLogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $logs = CategoryAuditLog::latest()->paginate(10);;
        return view('category-audit-logs.index', compact('logs'));
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
    public function show(CategoryAuditLog $categoryAuditLog)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CategoryAuditLog $categoryAuditLog)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CategoryAuditLog $categoryAuditLog)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CategoryAuditLog $categoryAuditLog)
    {
        //
    }
}
