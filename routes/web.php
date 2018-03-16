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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

/*
|--------------------------------------------------------------------------
| Threads Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::prefix('threads')->group(function () {

    Route::get('/', 'ThreadsController@index')
        ->name('threads.index');

    Route::get('/create', 'ThreadsController@create')
        ->name('threads.create');

    Route::get('/{channel?}', 'ThreadsController@index');

    Route::get('/{channel}/{thread}', 'ThreadsController@show')
        ->name('threads.show');

    Route::delete('/{channel}/{thread}', 'ThreadsController@destroy')
        ->name('threads.delete');

    Route::post('/', 'ThreadsController@store')
        ->name('threads.store');

    Route::post('/{channel}/{thread}/replies', 'RepliesController@store')
        ->name('thread.replies.store');
});

Route::patch('replies/{reply}', 'RepliesController@update');
Route::delete('replies/{reply}', 'RepliesController@destroy');

Route::post('replies/{reply}/favorites', 'FavoritesController@store')
    ->name('favorites.store');

Route::delete('replies/{reply}/favorites', 'FavoritesController@destroy');

Route::get('profiles/{user?}', 'ProfilesController@show')
    ->name('profile');