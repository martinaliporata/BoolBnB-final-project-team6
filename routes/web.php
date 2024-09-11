<?php

use App\Http\Controllers\Admin\ApartmentController;
use App\Http\Controllers\admin\ApartmentSponsorshipController;
use App\Http\Controllers\Admin\HomeController as AdminHomeController;
use App\Http\Controllers\admin\ViewController;
use App\Http\Controllers\HomeController as GuestHomeController;
use App\Models\Apartment;
use GuzzleHttp\Middleware;
use Illuminate\Support\Facades\Auth;
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

Auth::routes();

Route::get('/', function () {
    return view('layouts.app');
})->name('Index');


Route::get('/home', [GuestHomeController::class, 'index'])->name('home');




Route::middleware('auth')->name('admin.')->prefix('admin')->group(
    function () {
        Route::get('apartments/delete', [ApartmentController::class, 'deletedIndex'])->name('apartments.deleteindex');
        Route::patch('apartments/{apartment}/restore', [ApartmentController::class, 'restore'])->name('apartments.restore');
        Route::delete('apartments/{apartment}/delete', [ApartmentController::class, 'delete'])->name('apartments.permanent_delete');

        Route::get('/apartments/create', function () {
            return view('admin.apartments.create');
        })->name('apartments-create');
        Route::get('/apartments/edit', function () {
            return view('admin.apartments.edit');
        })->name('apartments-edit');
        Route::get('/secret-home', [AdminHomeController::class, 'index'])->name('home');
    }
);

Route::resource('/apartments', ApartmentController::class);

// Rotta per mostrare il form di creazione di una sponsorship
Route::get('/apartments/sponsorships/create', [ApartmentSponsorshipController::class, 'create'])
    ->name('apartment.sponsorships.create');

// Rotta per gestire l'invio del form e salvare la sponsorship
Route::post('/apartments/sponsorships', [ApartmentSponsorshipController::class, 'store'])
    ->name('apartment.sponsorships.store');

//Rotta per mostrare grafico visualizzazioni
Route::get('/apartment/{id}/views', [ViewController::class, 'getViewData']);
