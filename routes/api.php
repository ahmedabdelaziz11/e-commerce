<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\StoreController;
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

Route::group(['middleware' => 'api','prefix' => 'auth'], function ($router) {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
    Route::get('/user-profile', [AuthController::class, 'userProfile']);    
});

Route::middleware(['jwt.verify'])->group(function () {

    Route::get('stores',[StoreController::class,'index']);
    Route::get('store/{id}',[StoreController::class,'show']);
    Route::post('stores',[StoreController::class,'store']);
    Route::post('stores/{id}',[StoreController::class,'update'])->middleware('store.owner');
    Route::post('store/{id}',[StoreController::class,'destroy'])->middleware('store.owner');

});