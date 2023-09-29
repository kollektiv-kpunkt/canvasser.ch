<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Building;

class BuildingController extends Controller
{
    public function index() {
        return Building::all();
    }

    /**
     * Find all buildings within a given turf
     */
    public function findInTurf(Request $request)
    {
        $polygons = array_filter($request->input("turf")["features"], (function ($feature) {
            return $feature["geometry"]["type"] === "Polygon";
        }));
        $buildings = collect([]);
        foreach ($polygons as $polygon) {
            $buildings = $buildings->merge(Building::whereRaw("ST_Within(coordinates, ST_GeomFromGeoJSON(?))", [json_encode($polygon["geometry"])])->get(["id","EGID", "numberOfApartments"]));
        }
        return response()->json([
            "number_of_buildings" => $buildings->count(),
            "number_of_apartments" => $buildings->sum("numberOfApartments"),
            "buildings" => $buildings
        ]);
    }
}
