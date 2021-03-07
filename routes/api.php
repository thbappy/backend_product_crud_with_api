<?php

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

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::post('register', [\App\Http\Controllers\Api\Auth\UserController::class, 'register']);
Route::post('login', [\App\Http\Controllers\Api\Auth\UserController::class, 'login']);
//without Authentication
Route::get('product/all', [\App\Http\Controllers\Api\ProductController::class, 'index']);
Route::middleware('auth:api')->group(function () {
    Route::post('logout', [\App\Http\Controllers\Api\Auth\UserController::class, 'logout']);

    //product with Authentication
    Route::get('product/list', [\App\Http\Controllers\Api\ProductController::class, 'index']);
    Route::post('product/create', [\App\Http\Controllers\Api\ProductController::class, 'create']);
    Route::post('product/update/{id}', [\App\Http\Controllers\Api\ProductController::class, 'update']);
    Route::post('product/delete/{id}', [\App\Http\Controllers\Api\ProductController::class, 'destroy']);

});
