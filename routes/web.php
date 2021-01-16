<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\itemsController;
use App\Http\Controllers\userController;
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
        // Route::get('/', [DashboardController::class, 'index'])->name('admin-dashboard');
        // Route::resource('food', FoodController::class);
        Route::resource('users', UserController::class);

        // Route::get('transactions/{id}/status/{status}', [TransactionController::class, 'changeStatus'])->name('transactions.changeStatus');
        // Route::resource('transactions', TransactionController::class);
    });
