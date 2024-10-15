<?php

use App\Jobs\SendEmailJob;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TagController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\ChannelController;
use App\Http\Controllers\ChatgptController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\PrivacyController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TagPostController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\RoleUserController;
use App\Http\Controllers\TagAuditLogController;
use App\Http\Controllers\CategoryPostController;
use App\Http\Controllers\PostAuditLogController;
use App\Http\Controllers\FriendRequestController;
use App\Http\Controllers\CommentAuditLogController;
use App\Http\Controllers\CategoryAuditLogController;

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
    Route::post('/posts/{post}/like', [PostController::class, 'like'])->name('posts.like');
    Route::delete('/posts/{post}/unlike', [PostController::class, 'unlike'])->name('posts.unlike');
    Route::post('/posts/{post}/share', [PostController::class, 'share'])->name('posts.share');
    Route::post('/posts/{post}/pin', [PostController::class, 'pin'])->name('posts.pin');
    Route::post('/posts/{post}/unpin', [PostController::class, 'unpin'])->name('posts.unpin');

    Route::post('/friends/request', [FriendRequestController::class, 'sendRequest'])->name('friends.sendRequest');
    Route::post('/friends/accept/{friendRequest}', [FriendRequestController::class, 'acceptRequest'])->name('friends.acceptRequest');
    Route::get('/profile/{username}', [UserController::class, 'profile'])->name('users.profile');
});

// auth, verified, admin, superadmin endpoints
Route::middleware(['auth', 'verified', 'role:admin,superadmin'])->group(function () {

    Route::get('/role-user/search', [RoleUserController::class, 'search'])->name('role-user.search');
    Route::resource('role-user', RoleUserController::class)->except(['destroy']);
    Route::delete('/role-user/{userId}/{roleId}', [RoleUserController::class, 'destroy'])
        ->name('role-user.destroy');

    Route::get('/categories/deleted', [CategoryController::class, 'showDeleted'])
        ->name('categories.deleted'); //should be above the resource (using softdelete)
    Route::post('/categories/restore/{id}', [CategoryController::class, 'restore'])
        ->name('categories.restore'); //should be above the resource (using softdelete)
    Route::get('/categories/search', [CategoryController::class, 'search'])->name('categories.search');
    Route::resource('categories', CategoryController::class);

    Route::get('/category-post/search', [CategoryPostController::class, 'search'])->name('category-post.search');
    Route::resource('category-post', CategoryPostController::class);
    Route::delete('/category-post/{postId}/{categoryId}', [CategoryPostController::class, 'destroy'])
        ->name('category-post.destroy');

    Route::get('/tags/deleted', [TagController::class, 'showDeleted'])
        ->name('tags.deleted'); //should be above the resource (using softdelete)
    Route::post('/tags/restore/{id}', [TagController::class, 'restore'])
        ->name('tags.restore'); //should be above the resource (using softdelete)
    Route::get('/tags/search', [TagController::class, 'search'])->name('tags.search');
    Route::resource('tags', TagController::class);

    Route::get('/tag-post/search', [TagPostController::class, 'search'])->name('tag-post.search');
    Route::resource('tag-post', TagPostController::class);
    Route::delete('/tag-post/{postId}/{tagId}', [TagPostController::class, 'destroy'])
        ->name('tag-post.destroy');

    Route::get('/roles/search', [RoleController::class, 'search'])->name('roles.search');
    Route::resource('roles', RoleController::class);

    Route::get('/users/deleted', [UserController::class, 'showDeleted'])
        ->name('users.deleted'); //should be above the resource otherwise not found (using softdelete)
    Route::post('/users/restore/{id}', [UserController::class, 'restore'])
        ->name('users.restore'); //should be above the resource otherwise not found (using softdelete)
    Route::get('/users/search', [UserController::class, 'search'])->name('users.search');
    Route::resource('users', UserController::class);

    Route::get('/privacies/search', [PrivacyController::class, 'search'])->name('privacies.search');
    Route::resource('privacies', PrivacyController::class);

    Route::get('/post-audit-logs/search', [PostAuditLogController::class, 'search'])->name('post-audit-logs.search');
    Route::get('/post-audit-logs', [PostAuditLogController::class, 'index'])
        ->name('post-audit-logs.index');

    Route::get('/comment-audit-logs/search', [CommentAuditLogController::class, 'search'])->name('comment-audit-logs.search');
    Route::get('/comment-audit-logs', [CommentAuditLogController::class, 'index'])
        ->name('comment-audit-logs.index');

    Route::get('/category-audit-logs/search', [CategoryAuditLogController::class, 'search'])->name('category-audit-logs.search');
    Route::get('/category-audit-logs', [CategoryAuditLogController::class, 'index'])
        ->name('category-audit-logs.index');

    Route::get('/tag-audit-logs/search', [TagAuditLogController::class, 'search'])->name('tag-audit-logs.search');
    Route::get('/tag-audit-logs', [TagAuditLogController::class, 'index'])
        ->name('tag-audit-logs.index');

    Route::get('/chatgpts/search', [ChatgptController::class, 'search'])->name('chatgpts.search');
    Route::resource('chatgpts', ChatgptController::class);

    Route::get('/channels/search', [ChannelController::class, 'search'])->name('channels.search');
    Route::resource('channels', ChannelController::class);
    // Route::resource('chatgpts.channels', ChannelController::class);

    Route::resource('email', EmailController::class);

    // dispatch email using queue
    Route::get('/send-email', function () {
        $details = ['email' => 'user@example.com'];
        SendEmailJob::dispatch($details);

        return "Email is being sent in the background!";
    })->name('send-email.index');

});
