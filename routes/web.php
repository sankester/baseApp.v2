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

Route::prefix('base')->group(function () {
    Route::get('manage/home', 'Manage\HomeController@index')->name('base.manage.home');
    Route::resource('manage/portal', 'Manage\PortalController', ['except' => 'show', 'as' => 'manage']);
});