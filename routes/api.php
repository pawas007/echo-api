<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\FriendController;


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


Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('user', [UserController::class, 'auth']);
    Route::get('users', [UserController::class, 'users']);

    Route::prefix('friend')->group(function () {
        Route::get('/', [FriendController::class, 'friend']);
        Route::get('pending', [FriendController::class, 'friendPending']);
        Route::get('pending/{user}/cansel', [FriendController::class, 'friendPendingCansel']);
        Route::get('/{user}/add', [FriendController::class, 'friendAdd']);
        Route::get('/{user}/delete', [FriendController::class, 'friendDelete']);
    });

    //    Sockets events
    Route::post('public-chat/message', function (\Illuminate\Http\Request $request) {
        broadcast(new \App\Events\PublicChat($request->message));
    });
});


