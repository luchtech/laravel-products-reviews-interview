<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\StoreReviewController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('products/{product}/reviews', StoreReviewController::class)->name('reviews.store');
Route::apiResource('products', ProductController::class);
