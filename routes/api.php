<?php

use App\Http\Controllers\ApiAuthController;
use App\Http\Controllers\ProductController;
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

Route::prefix('user')->group(function () {
    Route::post('register', [ApiAuthController::class, 'register']);
    Route::post('login', [ApiAuthController::class, 'login']);
});

Route::prefix('user')->middleware('auth:sanctum')->group(function () {
    Route::get('token-info', [ApiAuthController::class, 'tokenInfo']);
});


Route::prefix('products')->middleware(['auth:sanctum'])->group(function () {
    Route::get('/', [ProductController::class, 'index'])->middleware('checkUserPermission:read')->name('products.index');
    Route::get('/{product}', [ProductController::class, 'show'])->middleware('checkUserPermission:read')->name('products.show');
    Route::post('/', [ProductController::class, 'store'])->middleware('checkUserPermission:write')->name('products.store');
    Route::post('/{product}', [ProductController::class, 'update'])->middleware('checkUserPermission:update')->name('products.update');
    Route::delete('/{product}', [ProductController::class, 'destroy'])->middleware('checkUserPermission:delete')->name('products.destroy');
});
