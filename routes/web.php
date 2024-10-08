<?php

use App\Http\Controllers\Admin\ApartmentController;
use App\Http\Controllers\admin\ApartmentSponsorshipController;
use App\Http\Controllers\Admin\AdminController as AdminController;
use App\Http\Controllers\admin\ViewController;
use App\Http\Controllers\Admin\MessageController;
use App\Http\Controllers\HomeController as GuestHomeController;
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

Route::get('/', function(){
    return view('homepage');
})->name('Index');

Route::get('/myapp', [GuestHomeController::class, 'myapp'])->name('myapp');
Route::put('/update', [GuestHomeController::class, 'update'])->name('profile.update');


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
        Route::get('/secret-home', [AdminController::class, 'index'])->name('home');
    }
);
Route::put('/apartments/{apartment}', [ApartmentController::class, 'update'])->name('apartments.update');

Route::resource('/apartments', ApartmentController::class)->except(['index']);


// Rotta per mostrare il form di creazione di una sponsorship
Route::get('/apartments/sponsorships/create', [ApartmentSponsorshipController::class, 'create'])
    ->name('apartment.sponsorships.create');

// Rotta per gestire l'invio del form e salvare la sponsorship
Route::post('/apartments/sponsorships', [ApartmentSponsorshipController::class, 'store'])
    ->name('apartment.sponsorships.store');

//Rotta per mostrare grafico visualizzazioni
Route::get('/apartment/{id}/views', [ViewController::class, 'getViewData']);

Route::get('/search', [ApartmentController::class, 'search'])->name('search');

Route::get('/messages', [MessageController::class, 'index'])->name('admin.messages.index');
Route::get('/messages/{id}', [MessageController::class, 'show'])->name('messages.show');
Route::delete('/messages/{id}', [App\Http\Controllers\admin\MessageController::class, 'destroy'])->name('messages.destroy');



