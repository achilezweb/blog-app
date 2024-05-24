<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\RoleUserController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\CategoryAuditLogController;
use App\Http\Controllers\CategoryPostController;
use App\Http\Controllers\PrivacyController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\TagAuditLogController;
use App\Http\Controllers\TagPostController;
use App\Http\Controllers\PostAuditLogController;
use App\Http\Controllers\CommentAuditLogController;
use App\Jobs\SendEmailJob;
use App\Http\Controllers\EmailController;

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

// public endpoints
Route::get('/posts/search', [PostController::class, 'search'])->name('posts.search');
Route::resource('posts', PostController::class);

// auth, verified endpoints
Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('posts.comments', CommentController::class);
    Route::post('posts/{post}/like', [PostController::class, 'like'])->name('posts.like');
    Route::delete('posts/{post}/unlike', [PostController::class, 'unlike'])->name('posts.unlike');

});

// auth, verified, admin, superadmin endpoints
Route::middleware(['auth', 'verified', 'role:admin,superadmin'])->group(function () {
    Route::resource('role-user', RoleUserController::class)->except(['destroy']);
    Route::delete('/role-user/{userId}/{roleId}', [RoleUserController::class, 'destroy'])
        ->name('role-user.destroy');

    Route::get('/categories/deleted', [CategoryController::class, 'showDeleted'])
        ->name('categories.deleted'); //should be above the resource (using softdelete)
    Route::post('/categories/restore/{id}', [CategoryController::class, 'restore'])
        ->name('categories.restore'); //should be above the resource (using softdelete)
    Route::resource('categories', CategoryController::class);

    Route::resource('category-post', CategoryPostController::class);
    Route::delete('/category-post/{postId}/{categoryId}', [CategoryPostController::class, 'destroy'])
        ->name('category-post.destroy');

    Route::get('/tags/deleted', [TagController::class, 'showDeleted'])
        ->name('tags.deleted'); //should be above the resource (using softdelete)
    Route::post('/tags/restore/{id}', [TagController::class, 'restore'])
        ->name('tags.restore'); //should be above the resource (using softdelete)
    Route::resource('tags', TagController::class);

    Route::resource('tag-post', TagPostController::class);
    Route::delete('/tag-post/{postId}/{tagId}', [TagPostController::class, 'destroy'])
        ->name('tag-post.destroy');

    Route::resource('roles', RoleController::class);
    Route::resource('privacies', PrivacyController::class);

    Route::get('/post-audit-logs', [PostAuditLogController::class, 'index'])
        ->name('post-audit-logs.index');
    Route::get('/comment-audit-logs', [CommentAuditLogController::class, 'index'])
        ->name('comment-audit-logs.index');
    Route::get('/category-audit-logs', [CategoryAuditLogController::class, 'index'])
        ->name('category-audit-logs.index');
    Route::get('/tag-audit-logs', [TagAuditLogController::class, 'index'])
        ->name('tag-audit-logs.index');

    Route::resource('email', EmailController::class);

    // dispatch email using queue
    Route::get('/send-email', function () {
        $details = ['email' => 'user@example.com'];
        SendEmailJob::dispatch($details);

        return "Email is being sent in the background!";
    })->name('send-email.index');

});
