<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\GalleryController;
use Illuminate\Http\Request;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::controller(GalleryController::class)->group(function () {
    Route::get('/galleries', 'index');
    Route::get('/galleries/{id}','show');
    Route::post('/galleries', 'store')->middleware('auth');
    Route::put('/galleries/{id}', 'update')->middleware('auth');
    Route::delete('/galleries/{id}', 'destroy')->middleware('auth');
});

Route::controller(AuthController::class)->group(function () {
    Route::post('/login', 'login');
    Route::post('/register', 'register');
    Route::post('/logout', 'logout')->middleware('auth');
    Route::get('/authors/{id}', 'getMyGalleries')->middleware('auth');
});

Route::controller(CommentController::class)->group(function () {
    Route::post('/galleries/{id}/comments', 'store')->middleware('auth');
    Route::delete('/comments/{id}', 'destroy')->middleware('auth');
});
