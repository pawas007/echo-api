<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;


Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('public-chat/message', function (Request $request) {
        broadcast(new \App\Events\PublicChatMessageEvent($request->message));
    });
});
