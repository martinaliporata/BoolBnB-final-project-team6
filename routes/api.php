<?php

use App\Http\Controllers\api\ApartmentController;
use App\Http\Controllers\api\ApartmentSponsorshipController;
use App\Http\Controllers\Api\MessageController;
use App\Http\Controllers\api\ViewController;
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

Route::get('vue-apartments', function () {
    return redirect()->to(config('app.url') . '/');
});


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::get('/apartments/search', [ApartmentController::class, 'search']);
Route::resource('/apartments', ApartmentController::class);




Route::post('/apartments/{apartmentId}/update-sponsorship', [ApartmentController::class, 'updateSponsorship']);

Route::post('/apartment-sponsorship', [ApartmentSponsorshipController::class, 'store']);

Route::post('/apartments/{apartmentId}/view', [ViewController::class, 'storeView']);

Route::post('/messages', [MessageController::class, 'store']);



