<?php

use App\Http\Controllers\Admin\ApartmentController;
use App\Http\Controllers\Admin\HomeController as AdminHomeController;
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

Route::get('/', function(){
    return view('layouts.app');
})->name('Index');

Route::get('/home', [GuestHomeController::class, 'index'])->name('home');



Route::middleware('auth')->name('admin.')->prefix('admin')->group(
    function(){
        Route::get('/secret-home', [AdminHomeController::class, 'index'])->name('home');
    }
);

Route::resource('/apartments', ApartmentController::class);
