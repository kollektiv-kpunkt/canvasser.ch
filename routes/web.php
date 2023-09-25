<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CampaignController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


// Route::get("/admin", function () {
//     return view("dashboard");
// })->middleware(["auth", "verified"]);

Route::middleware(["auth", "verified"])->prefix("admin")->group(function () {
    Route::get('/', function () {
        return view('dashboard');
    })->name('admin');

    Route::resource('campaigns', CampaignController::class)->middleware("campaignaccess");
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


require __DIR__.'/auth.php';


Route::prefix("/{campaign:slug}")->group(function () {
    Route::get("/", [CampaignController::class, "map"])->name("campaigns.map");
    Route::resource("turfs", \App\Http\Controllers\TurfController::class)->only(["store"]);
});
