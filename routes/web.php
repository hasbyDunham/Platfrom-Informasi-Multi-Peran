<?php

use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategorieController;
use App\Http\Controllers\WriterController;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// ================== ADMIN ROUTES ===================
Route::group(['prefix' => 'admin', 'middleware' => ['auth', 'role:Admin']], function () {
    Route::get('/', [AdminController::class, 'index'])->name('admin.index');

    // Resource routes untuk mengelola data
    Route::resource('users', UserController::class);
    Route::resource('roles', RolesController::class);
    Route::resource('categories', CategorieController::class);
});

// ================== WRITER ROUTES ===================
Route::middleware(['auth', 'role:Writer'])->prefix('writer')->group(function () {
    Route::get('/', [WriterController::class, 'index'])->name('writer.index');
});
// Route::group(['prefix' => 'writer', 'middleware' => ['auth', 'role:Writer']], function () {
//     Route::get('/', [WriterController::class, 'index'])->name('writer.index');

//     // Tambahkan route lain yang hanya bisa diakses oleh Writer
//     // Route::resource('posts', PostController::class);
// });

// ================== USER ROUTES ===================
Route::group(['prefix' => 'user', 'middleware' => ['auth', 'role:User']], function () {
    Route::post('/comment', [UserController::class, 'comment'])->name('user.comment');
});


    // Route::group(['middleware'=> ['auth']], function() {
    //     Route::resource('roles', RolesController::class);
    //     Route::resource('user', UserController::class);
    //     Route::resource('categorie', CategorieController::class);
    // });
