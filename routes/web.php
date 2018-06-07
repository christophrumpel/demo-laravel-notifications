<?php

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

use App\Notifications\BookWasReleased;
use App\User;

Route::get('/', function () {

    $user = User::first();
    $user->notify(new BookWasReleased());

    $user->notifications->first()->markAsRead();

});
