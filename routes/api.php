<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\WishlistController;
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

Route::middleware('auth:api', 'admin')->get('/admin', function (Request $request) {
    return $request->user();
});

Route::controller(GalleryController::class)->group(function () {
    Route::get('/galleries', 'index');
    Route::get('/galleries/{id}','show');
    Route::post('/galleries', 'store')->middleware('auth');
    Route::get('/my-profile', 'getMyProfile');
    Route::put('/galleries/{gallery}', 'update')->middleware('auth');
    Route::delete('/galleries/{gallery}', 'destroy')->middleware('auth');
});

Route::controller(AuthController::class)->group(function () {
    Route::post('/login', 'login');
    Route::post('/register', 'register');
    Route::post('/logout', 'logout')->middleware('auth');
    Route::get('/authors/{id}', 'getMyGalleries');
    Route::post('/refresh', 'refresh');
});

Route::controller(AdminController::class)->group(function(){
    Route::get('/admin/users', 'listOfAllUsers')->middleware('admin');
    Route::post('/admin/users/{id}', 'manageAdminPrivileges')->middleware('admin');
});

Route::controller(CommentController::class)->group(function () {
    Route::post('/galleries/{gallery}/comments', 'store')->middleware('auth');
    Route::get('/galleries/{gallery}/comments', 'show');
    Route::post('/comments/{id}/like', 'like')->middleware('auth');
    Route::post('/comments/{id}/dislike', 'dislike')->middleware('auth');
    Route::delete('/comments/{id}', 'destroy')->middleware('auth');
});

Route::controller(WishlistController::class)->group(function () {
    Route::get('/wishlist', 'index');
    Route::post('/galleries/{id}/wishlist', 'store')->middleware('auth');
    Route::delete('/wishlist/{id}', 'destroy')->middleware('auth');
});

Route::controller(TransactionController::class)->group(function () {
    Route::post('/galleries/{gallery}/buy', 'buyGallery')->middleware('auth');
    Route::post('/deposit', 'deposit')->middleware('auth');
});
