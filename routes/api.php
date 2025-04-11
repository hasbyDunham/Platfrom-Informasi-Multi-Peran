<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CategorieController;
use App\Http\Controllers\Api\InformationController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// ROUTE AUTH
Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('logout', [AuthController::class, 'logout']);
    Route::resource('categorie', CategorieController::class)->except(['edit', 'create']);
    Route::resource('information', InformationController::class)->except(['edit', 'create']);
    Route::resource('profile', UserController::class)->except(['edit', 'create']);
});

// Route::resource('tag', TagController::class)->except(['edit', 'create']);
// Route::resource('user', UserController::class)->except(['edit', 'create']);
// Route::resource('berita', BeritaController::class)->except(['edit', 'create']);
