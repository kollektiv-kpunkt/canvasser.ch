<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class CampaignController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('campaigns.index', [
            'campaigns' => Campaign::usersCampaigns(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('campaigns.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|max:100',
            'slug' => 'required|max:100|unique:campaigns',
            'description' => 'max:255',
            'region' => "required",
            "admins" => "array",
        ]);
        $validated["uuid"] = Str::uuid();
        Campaign::create($validated);
        return redirect()->route('campaigns.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Campaign $campaign)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Campaign $campaign)
    {
        return view('campaigns.edit', [
            'campaign' => $campaign,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Campaign $campaign)
    {
        $validated = $request->validate([
            'title' => 'required|max:100',
            'slug' => 'required|max:100|unique:campaigns,slug,' . $campaign->id,
            'description' => 'max:255',
            'region' => "required",
            "admins" => "array",
        ]);
        $campaign->update($validated);
        return redirect()->route('campaigns.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Campaign $campaign)
    {
        $campaign->delete();
        return redirect()->route('campaigns.index');
    }

    /**
     * Display map for the active campaign.
     */
    public function map(Campaign $campaign)
    {
        return view('campaigns.map', [
            'campaign' => $campaign,
        ]);
    }
}
