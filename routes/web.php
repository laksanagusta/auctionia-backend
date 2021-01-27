<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\itemsController;
use App\Http\Controllers\userController;
use App\Http\Controllers\categoriesController;
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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/items', [itemsController::class, 'index']);

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Route::prefix('dashboard')
    ->middleware(['auth:sanctum'])
    ->group(function() {
        Route::resource('users', UserController::class);
        Route::resource('categories', CategoriesController::class);
    });

Route::get('/sentry', function() {
    throw new Exception("Error Processing Request", 1);
});
