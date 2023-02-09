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
        Route::get('request', [FriendController::class, 'friendRequest']);
        Route::get('request/{user}/accept', [FriendController::class, 'friendAccept']);
        Route::get('request/{user}/decline', [FriendController::class, 'friendDecline']);
        Route::get('{user}/add', [FriendController::class, 'friendAdd']);
        Route::get('{user}/delete', [FriendController::class, 'friendDelete']);
        Route::get('counts', [FriendController::class, 'friendCounts']);


    });

    //    Sockets events
    Route::post('public-chat/message', function (\Illuminate\Http\Request $request) {
        broadcast(new \App\Events\PublicChatMessageEvent($request->message));
    });

});


