<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePrivacyRequest;
use App\Http\Requests\UpdatePrivacyRequest;
use App\Models\Privacy;

class PrivacyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $privacies = Privacy::latest()->paginate(10);
        return view('privacies.index', compact('privacies'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('privacies.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePrivacyRequest $request)
    {
        Privacy::create($request->validated());
        return redirect()->route('privacies.index')->with('success', 'Privacy created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Privacy $privacy)
    {
        return view('privacies.show', compact('privacy'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Privacy $privacy)
    {
        return view('privacies.edit', compact('privacy'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePrivacyRequest $request, Privacy $privacy)
    {
        $privacy->update($request->validated());
        return redirect()->route('privacies.index')->with('success', 'Privacy updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Privacy $privacy)
    {
        $privacy->delete();
        return redirect()->route('privacies.index')->with('success', 'Privacy deleted successfully.');
    }
}
