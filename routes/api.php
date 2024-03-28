<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserAuthController;
use App\Http\Controllers\ItineraryController;

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

// Route::middleware('auth:sanctum')->get('user',[UserAuthController::class,'user']);

Route::post('register',[UserAuthController::class,'register']);
Route::post('login',[UserAuthController::class,'login']);

Route::middleware('auth:api')->post('logout',[UserAuthController::class,'logout']);

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::middleware('auth:api')->post('store', [ItineraryController::class, 'store']);
Route::middleware('auth:api')->get('itineraryy', [ItineraryController::class, 'index']);

Route::middleware('auth:api')->put('itineraries/update/{id}', [ItineraryController::class, 'update']);
Route::middleware('auth:api')->delete('itineraries/{id}', [ItineraryController::class, 'destroy']);

Route::middleware('auth:api')->post('liste-a-visualiser/{itineraireId}', [ItineraryController::class, 'StoreListeAvisiter']);
Route::middleware('auth:api')->get('liste-a-visualiser', [ItineraryController::class, 'DisplayListeAvisiter']);


Route::get('itineraries', [ItineraryController::class, 'indexAll']);
Route::get('itineraries/search', [ItineraryController::class, 'search']);
Route::get('itineraries/filter', [ItineraryController::class, 'filter']);




