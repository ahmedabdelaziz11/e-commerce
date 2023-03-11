<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\ProductController;
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


    Route::get('products',[ProductController::class,'index']);
    Route::get('product/{id}',[ProductController::class,'show']);
    Route::post('products',[ProductController::class,'store']);
    Route::post('products/{id}',[ProductController::class,'update'])->middleware('product.owner');
    Route::post('product/{id}',[ProductController::class,'destroy'])->middleware('product.owner');


    Route::get('carts',[CartController::class,'index']);
    Route::get('cart/{id}',[CartController::class,'show']);
    Route::post('carts',[CartController::class,'store']);
    Route::post('carts/{id}',[CartController::class,'update'])->middleware('cart.owner');
    Route::post('cart/{id}',[CartController::class,'destroy'])->middleware('cart.owner');

});