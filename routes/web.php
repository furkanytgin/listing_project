<?php

use App\Models\Listing;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ListingController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [ListingController::class, 'index'])->name('home');

Route::get('/listings/manage', [ListingController::class, 'manage'])->name('listing.manage');


Route::get('/listings/{listing}', [ListingController::class, 'show'])->name('listing.show');

//Show create listing form
Route::get('/listing/create', [ListingController::class, 'create'])->middleware('auth')->name('listing.create');

//Store Listing form
Route::post('/listing/store', [ListingController::class, 'store'])->middleware('auth')->name('listing.store');

//Show Listing edit
Route::get('/listing/{listing}/edit', [ListingController::class, 'edit'])->middleware('auth')->name('listing.edit');


//Update Listing datas
Route::put('/listing/{listing}/update', [ListingController::class, 'update'])->middleware('auth')->name('listing.update');


//Delete Listing datas
Route::delete('/listing/{listing}/delete', [ListingController::class, 'delete'])->middleware('auth')->name('listing.delete');

//User register page
Route::get('/register', [UserController::class, 'create'])->middleware('guest')->name('users.register');

//User post register
Route::post('/users', [UserController::class, 'store'])->middleware('guest')->name('users.store');

//User logout
Route::post('/logout', [UserController::class, 'logout'])->middleware('auth')->name('users.logout');


//User login page
Route::get('/login', [UserController::class, 'login'])->middleware('guest')->name('users.login');

//User login
Route::post('/user/authenticate', [UserController::class, 'authenticate'])->middleware('guest')->name('authenticate');
