<?php

use App\Http\Controllers\FeedbacksController;
use App\Http\Controllers\InstitutionsController;
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
