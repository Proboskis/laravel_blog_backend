<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TagController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PostMetaController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Public routes

// Login and post related public routes
Route::post('/register', [UserController::class, 'register']);
Route::post('/login', [UserController::class, 'login']);
Route::get('/posts/{id}', [PostController::class, 'show']);
Route::get('/posts/search/{title}', [PostController::class, 'search']);

// Categories related public routes
Route::get('/categories', [CategoryController::class, 'index']);
Route::get('/categories/{id}', [CategoryController::class, 'show']);
Route::get('/categories/search/{title}', [CategoryController::class, 'search']);

// Tags related public routes
Route::get('/tags', [TagController::class, 'index']);
Route::get('/tags/{id}', [TagController::class, 'show']);
Route::get('/tags/search/{title}', [TagController::class, 'search']);

// Comments related public routes
Route::get('/comments', [CommentController::class, 'index']);
Route::get('/comments/{id}', [CommentController::class, 'show']);

// Post Metas related public routes
Route::get('/post-meta', [PostMetaController::class, 'index']);
Route::get('/post-meta/{id}', [PostMetaController::class, 'show']);

// Protected routes
Route::group(['middleware' => 'custom.auth'], function() {

    // Login and post related private routes
    Route::get('/posts', [PostController::class, 'index']);
    Route::post('/logout', [UserController::class, 'logout']);
    Route::post('/posts', [PostController::class, 'store']);
    Route::put('/posts/{id}', [PostController::class, 'update']);
    Route::delete('/posts/{id}', [PostController::class, 'destroy']);

    // Categories related private routes
    Route::post('/categories', [CategoryController::class, 'store']);
    Route::put('/categories/{id}', [CategoryController::class, 'update']);
    Route::delete('/categories/{id}', [CategoryController::class, 'destroy']);

    // Tags related private routes
    Route::post('/tags', [TagController::class, 'store']);
    Route::put('/tags/{id}', [TagController::class, 'update']);
    Route::delete('/tags/{id}', [TagController::class, 'destroy']);

    // Comments related private routes
    Route::post('/comments', [CommentController::class, 'store']);
    Route::put('/comments/{id}', [CommentController::class, 'update']);
    Route::delete('/comments/{id}', [CommentController::class, 'destroy']);

    // Post Meta related private routes
    Route::post('/post-meta', [PostMetaController::class, 'store']);
    Route::put('/post-meta/{id}', [PostMetaController::class, 'update']);
    Route::delete('/post-meta/{id}', [PostMetaController::class, 'destroy']);
});
