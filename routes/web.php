<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('home');
});

Auth::routes();

Route::view('chat', 'chat')->name('publicChat');
Route::view('contacts', 'contacts')->name('contacts');
Route::view('messages', 'messages')->name('messages');

Route::post('message', function (\Illuminate\Http\Request $request) {
    broadcast(new \App\Events\PublicChat($request->message));
});
