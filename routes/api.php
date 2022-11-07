<?php

use App\Http\Controllers\Api\V1\OrderController;
use App\Http\Controllers\Api\V1\ProductController;
use App\Http\Controllers\Api\V1\UserController;
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


Route::prefix('v1')->group(function () {

    Route::prefix('products')->group(function () {
        Route::get('list', [ProductController::class, 'index']);
        Route::get('show/{id}', [ProductController::class, 'show']);
    });

    Route::prefix('users')->group(function () {
        Route::post('register', [UserController::class, 'store']);
    });




    Route::middleware('auth:api')->group(function () {
        Route::get('/me', [UserController::class, 'me']);
        Route::prefix('users')->group(function () {
            Route::post('add-money', [UserController::class, 'addMoney']);
        });

        Route::prefix('orders')->group(function () {
            Route::get('/{id}', [OrderController::class, 'show']);
            Route::post('place', [OrderController::class, 'store']);
        });
    });
});
