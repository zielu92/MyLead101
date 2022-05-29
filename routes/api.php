<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\PriceController;
use App\Http\Controllers\ProductsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

//user
Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);
//products
Route::get('/product', [ProductsController::class, 'getProducts']);
Route::get('/product/{id}', [ProductsController::class, 'show']);
Route::get('/price', [PriceController::class, 'getPrices']);

Route::middleware('auth:api')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    //products with auth
    Route::post('/product', [ProductsController::class, 'store']);
    Route::delete('/product/{id}', [ProductsController::class, 'destroy']);
    Route::put('/product/{id}', [ProductsController::class, 'update']);
    //price with auth
    Route::post('/price', [PriceController::class, 'store']);
    Route::delete('/price/{id}', [PriceController::class, 'destroy']);
    Route::put('/price/{id}', [PriceController::class, 'update']);
});
