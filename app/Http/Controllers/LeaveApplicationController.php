<?php

namespace App\Http\Controllers;

use App\Models\LeaveApplication;
use Illuminate\Http\Request;

class LeaveApplicationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(LeaveApplication::all());
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
        $leaveApplication = LeaveApplication::create($request->validated());
        return response()->json($leaveApplication, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(LeaveApplication $leaveApplication)
    {
        return response()->json($leaveApplication);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(LeaveApplication $leaveApplication)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, LeaveApplication $leaveApplication)
    {
        $leaveApplication->update($request->validated());
        return response()->json($leaveApplication);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(LeaveApplication $leaveApplication)
    {
        $leaveApplication->delete();
        return response()->json(null, 204);
    }
}
