<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DishController;
use App\Http\Controllers\FeedbacksController;
use App\Http\Controllers\InstitutionsController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use App\Http\Middleware\CheckDeliveryTime;
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

Route::get('/institutions', [InstitutionsController::class, 'get']);
Route::get('/institutions/{id}', [InstitutionsController::class, 'getById']);
Route::get('/institutions/main/page', [InstitutionsController::class, 'getMainPageInfo']);

Route::post('/feedbacks', [FeedbacksController::class, 'create']);

Route::group(['prefix' => 'dishes'], function () {
    Route::get('index', [DishController::class, 'index'])->name('dish.index');
    Route::get('show/{dish}', [DishController::class, 'show'])->name('dish.show');
});

Route::group(['prefix' => 'categories'], function () {
    Route::get('index', [CategoryController::class, 'index'])->name('category.index');
    Route::get('show/{category}', [CategoryController::class, 'show'])->name('category.show');
});

Route::post('order', [OrderController::class, 'create'])->middleware(CheckDeliveryTime::class)->name('order.create');

Route::group(['prefix' => 'payment'], function () {
    Route::post('callback', [PaymentController::class, 'callback']);
});
