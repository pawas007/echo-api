<?php

use App\Http\Controllers\NotificationsController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\FriendController;


Route::middleware(['auth:sanctum'])->group(function () {


    Route::prefix('user')->group(function () {
        Route::get('/', [UserController::class, 'users']);
        Route::get('/auth', [UserController::class, 'auth']);
        Route::put('/change/email', [UserController::class, 'changeEmail']);
    });

    Route::prefix('notifications')->group(function () {
        Route::get('', [NotificationsController::class, 'index']);
        Route::get('{id}/mark/toggle', [NotificationsController::class, 'markAsRead']);
        Route::get('{id}/destroy', [NotificationsController::class, 'destroy']);
    });

    Route::prefix('friend')->group(function () {
        Route::get('/', [FriendController::class, 'friend']);
        Route::get('pending', [FriendController::class, 'friendPending']);
        Route::get('pending/{user}/cansel', [FriendController::class, 'friendPendingCansel']);
        Route::get('request', [FriendController::class, 'friendRequest']);
        Route::get('request/{user}/accept', [FriendController::class, 'friendAccept']);
        Route::get('request/{user}/decline', [FriendController::class, 'friendDecline']);
        Route::get('{user}/add', [FriendController::class, 'friendAdd']);
        Route::get('{user}/delete', [FriendController::class, 'friendDelete']);
        Route::get('counts', [FriendController::class, 'friendCounts']);
    });

});


