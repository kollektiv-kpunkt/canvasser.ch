<?php

namespace App\Http\Controllers;

use App\Models\Turf;
use Illuminate\Http\Request;

class TurfController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
        $validated = $request->validate([
            "geometry" => "required",
            "campaign_id" => "required"
        ]);
        $validated["uuid"] = \Illuminate\Support\Str::uuid();
        $validated['user_id'] = request()->user()->id;
        $turf = Turf::create($validated);
        $turf["success"] = true;
        return response()->json($turf);
    }

    /**
     * Display the specified resource.
     */
    public function show(Turf $turf)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Turf $turf)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Turf $turf)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Turf $turf)
    {
        //
    }
}
