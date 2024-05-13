<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\RoleUserController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\RoleController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

Route::get('/posts/search', [PostController::class, 'search'])->name('posts.search');
Route::resource('posts', PostController::class);
Route::resource('posts.comments', CommentController::class)->middleware('auth');

// Route::resource('categories', CategoryController::class);
Route::resource('categories', CategoryController::class)->middleware('auth');

// Route::resource('categories', CategoryController::class);
Route::resource('roles', RoleController::class)->middleware('auth');


Route::resource('roleUsers', RoleUserController::class)
    ->middleware(['auth','role:admin,superadmin'])
    ->except(['destroy']);
Route::delete('/roleUsers/{userId}/{roleId}', [RoleUserController::class, 'destroy'])
    ->middleware('auth')
    ->name('roleUsers.destroy');


