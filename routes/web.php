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
    // portal
    Route::resource('manage/portal', 'Manage\PortalController', ['except' => 'show', 'as' => 'manage']);
    // role
    Route::resource('manage/role', 'Manage\RoleController', ['as' => 'manage']);
    Route::post('/manage/role/search', 'Manage\RoleController@search')->name('manage.role.search');
    // menu
    Route::resource('manage/menu', 'Manage\MenuController', ['except' => ['create', 'edit', 'update'],'as' => 'manage']);
    Route::get('/manage/menu/{portal}/create', 'Manage\MenuController@create')->name('manage.menu.create');
    Route::get('/manage/menu/{portal}/{menu}/edit', 'Manage\MenuController@edit')->name('manage.menu.edit');
    Route::patch('/manage/menu/{menu}', 'Manage\MenuController@update')->name('manage.menu.update');
    Route::put('/manage/menu/{portal}/sortable', 'Manage\MenuController@sortable')->name('manage.menu.sortable');
});