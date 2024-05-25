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
        $logs = CategoryAuditLog::latest()->paginate(10);
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

    public function search(Request $request){

        $data = $request->validate([
            'query' => ['required', 'string', 'max:200'],
        ]);

        $searchTerm = $request->input('query');

        // Perform the search query User model and eager load the 'roles' relationship
        $logs = CategoryAuditLog::whereHas('category', function ($query) use ($searchTerm) {
            $query->where('name', 'like', "%{$searchTerm}%")
                ->orWhere('description', 'like', "%{$searchTerm}%");
        })->orwhereHas('updater', function ($query) use ($searchTerm) {
            $query->where('name', 'like', "%{$searchTerm}%")
                ->orWhere('email', 'like', "%{$searchTerm}%");
        })->orWhere('action', 'like', "%{$searchTerm}%")
          ->orWhere('changes', 'like', "%{$searchTerm}%")
        //   ->with(['category','updater'])
          ->paginate(10);

        // $logs = CategoryAuditLog::Where('action', 'like', "%{$searchTerm}%")
        //   ->orWhere('changes', 'like', "%{$searchTerm}%")
        //   ->paginate(10);

        return view('category-audit-logs.index', compact('logs'));
    }

}
