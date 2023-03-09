<?php

use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\NotificationsController;
use App\Http\Controllers\UserSettingController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\FriendController;

Route::post('/verify/email', [VerificationController::class, 'verifyEmail']);

Route::middleware(['auth:sanctum'])->group(function () {
    Route::prefix('user')->group(function () {
        Route::get('/', [UserController::class, 'users']);
        Route::get('auth', [UserController::class, 'auth']);
        Route::put('update/email', [UserController::class, 'updateEmail']);
        Route::put('update/password', [UserController::class, 'updatePassword']);
        Route::put('profile', [UserController::class, 'updateProfile']);
        Route::post('avatar', [UserController::class, 'updateAvatar']);
        Route::post('send-verify/email', [VerificationController::class, 'sendVerificationEmail']);
        Route::post('send-verify/phone', [VerificationController::class, 'sendVerificationPhone']);
        Route::post('verify/phone', [VerificationController::class, 'verifyPhone']);
        Route::post('settings', [UserSettingController::class, 'updateSettings']);

    });

    Route::prefix('notifications')->group(function () {
        Route::get('', [NotificationsController::class, 'index']);
        Route::put('{id}/mark/toggle', [NotificationsController::class, 'markAsRead']);
        Route::delete('{id}/destroy', [NotificationsController::class, 'destroy']);
    });

    Route::prefix('friend')->group(function () {
        Route::get('/', [FriendController::class, 'friend']);
        Route::get('pending', [FriendController::class, 'friendPending']);
        Route::delete('pending/{user}/cansel', [FriendController::class, 'friendPendingCansel']);
        Route::get('request', [FriendController::class, 'friendRequest']);
        Route::post('request/{user}/accept', [FriendController::class, 'friendAccept']);
        Route::delete('request/{user}/decline', [FriendController::class, 'friendDecline']);
        Route::post('{user}/add', [FriendController::class, 'friendAdd']);
        Route::delete('{user}/delete', [FriendController::class, 'friendDelete']);
        Route::get('counts', [FriendController::class, 'friendCounts']);
    });

});


