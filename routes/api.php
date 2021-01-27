<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\itemsController;
use App\Http\Controllers\API\categoryController;
use App\Http\Controllers\API\userController;
use App\Http\Controllers\API\favouritesController;
use App\Http\Controllers\API\bidController;
use App\Http\Controllers\API\transactionController;
use App\Http\Controllers\API\commentController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/addBarang', [itemsController::class, 'addBarang']);
    Route::post('/favourites/store', [favouritesController::class, 'store']);
    Route::post('/comments/store', [commentController::class, 'store']);
    Route::post('/bid/store', [bidController::class, 'store']);
});

Route::get('/items', [itemsController::class, 'index']);
Route::put('/items/{id}', [itemsController::class, 'updateItem']);
Route::get('/getItems/{categoryId}/{userId}', [itemsController::class, 'getItems']);
Route::get('/getItemsEtalase/{users_id}', [itemsController::class, 'getItemsEtalase']);

Route::post('/bid/index', [bidController::class, 'index']);
Route::post('/bid-in/index', [bidController::class, 'indexIn']);
Route::post('/bid-out/index', [bidController::class, 'indexOut']);
Route::get('/bid/indexBidPerItem/{itemId}', [bidController::class, 'indexBidPerItem']);

Route::get('/comments/indexCommentPerItem/{itemId}', [commentController::class, 'indexCommentPerItem']);

Route::post('/transaction/index', [bidController::class, 'transaction']);

Route::post('/register', [userController::class, 'register']);
Route::post('/login', [userController::class, 'login']);
Route::post('/users/update', [userController::class, 'update']);
Route::post('/users/updatePassword', [userController::class, 'updatePasword']);
Route::post('/users/editPicture', [userController::class, 'editPicture']);

Route::get('/category', [categoryController::class, 'index']);
