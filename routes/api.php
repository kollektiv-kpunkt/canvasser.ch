<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BuildingController;
use App\Http\Controllers\ZipcodeController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post("/buildings/find", [BuildingController::class, "findInTurf"]);
Route::post("/buildings/count", function () {
    return response()->json(["count" => \App\Models\Building::count()]);
});

Route::get("/zipcodes/{zipcode}", function (Request $request) {
    $zipcode = \App\Models\Zipcode::where('zipcode', $request->zipcode)->where("geoShape", "!=", null)->get(["zipcode", "city", "geoShape"]);
    return response()->json($zipcode);
});
