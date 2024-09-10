<?php

use App\Http\Controllers\Admin\ApartmentController as AdminApartmentController;
use App\Http\Controllers\Admin\HomeController as AdminHomeController;
use App\Http\Controllers\api\ApartmentController;
use App\Http\Controllers\HomeController as GuestHomeController;
use App\Models\Apartment;
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
Route::get('/', [GuestHomeController::class, 'index'])->name('home');
Route::get('/home', [GuestHomeController::class, 'index'])->name('home');


// Route::get('/apartments', [AdminApartmentController::class, 'index']) ->name('admin.apartments.index');
// Route::post('/apartments', [AdminApartmentController::class, 'store'])->name('apartments.store');
// Route::get('/apartments/create', [AdminApartmentController::class, 'create'])->name('apartments.create');
// Route::get('/apartments/{id}', [AdminApartmentController::class, 'show']) ->name('admin.apartments.show');
// Route::get('/apartments/{id}/edit', [AdminApartmentController::class, 'edit']) ->name('admin.apartments.edit');
// Route::put('/apartments/{id}', [AdminApartmentController::class, 'update']) ->name('admin.apartments.update');
// Route::delete('/apartments/{id}', [AdminApartmentController::class, 'destroy']) ->name('admin.apartments.destroy');

Route::resource('/apartments', AdminApartmentController::class);
