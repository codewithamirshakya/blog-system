<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\CommentController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\UserController;


Route::middleware('auth:sanctum')->group(function () {

    /** User routes */
    Route::apiResource('users', UserController::class);

    /** Post routes */
    Route::apiResource('posts', PostController::class);
    /** Category routes */
    Route::apiResource('categories', CategoryController::class);

    /** Comment routes */
    Route::get('comments/{type}/{typeId}', [CommentController::class, 'index']);
    Route::post('comments/{type}/{typeId}', [CommentController::class, 'store']);
    Route::put('comments/{id}', [CommentController::class, 'update']);
    Route::delete('comments/{type}/{typeId}/{id}', [CommentController::class, 'delete']);
});

/** Authentication routes */
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

