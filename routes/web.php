<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers;
use App\Http\Controllers\ThreadController;

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

Route::redirect('/', '/thread');

Route::resource('/thread', 'App\Http\Controllers\ThreadController');
//Route::resource('/thread', [App\Http\Controllers\ThreadController::class, 'index']);

Route::resource('/reply', 'App\Http\Controllers\ReplyController');
Route::post('/thread/search', 'App\Http\Controllers\ThreadController@search')->name('thread.search');

/*
Route::redirect('/', '/thread');
Route::resource('/thread', ThreadController::class);
Route::resource('/reply', ReplyController::class);
Route::post('/thread/search', [ThreadController::class, 'search'])->name('thread.search');
*/
