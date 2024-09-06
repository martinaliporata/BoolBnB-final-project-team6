<?php

use App\Http\Controllers\api\ApartmentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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


Route::resource('/apartment', ApartmentController::class);

Route::get('/apartments/search', [ApartmentController::class, 'search']);

Route::post('/apartments/{apartmentId}/update-sponsorship', [ApartmentController::class, 'updateSponsorship']);
