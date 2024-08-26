<?php

use App\Http\Controllers\Api\ApiAuthController;
use App\Http\Controllers\Api\ApiCommentController;
use App\Http\Controllers\Api\ApiPostController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::post('register', [ApiAuthController::class, 'register']);
Route::post('login', [ApiAuthController::class, 'login']);



Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('posts', ApiPostController::class);
    Route::post('comments', [ApiCommentController::class, 'store']);
    Route::delete('comments/{id}', [ApiCommentController::class, 'destroy']);
});