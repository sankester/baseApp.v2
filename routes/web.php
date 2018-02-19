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
    // set forbidden access
    Route::get('forbidden/page/{code}/{nav_id?}','Manage\ForbiddenAccess@page')->name('base.forbidden');
    // home
    Route::get('manage/home', 'Manage\HomeController@index')->name('base.manage.home');
    // portal
    Route::resource('manage/portal', 'Manage\PortalController', ['as' => 'manage']);
    // role
    Route::resource('manage/role', 'Manage\RoleController', ['as' => 'manage']);
    Route::post('manage/role/search', 'Manage\RoleController@search')->name('manage.role.search');
    Route::put('/manage/role/sort/process', 'Manage\RoleController@sortProccess')->name('manage.role.sort');
    Route::post('/manage/role/getListPermission', 'Manage\RoleController@getListPermissionAjax')->name('manage.role.getPermission');
    // menu
    Route::resource('manage/menu', 'Manage\MenuController', ['except' => ['create', 'edit', 'update'],'as' => 'manage']);
    Route::get('/manage/menu/{portal}/create', 'Manage\MenuController@create')->name('manage.menu.create');
    Route::get('/manage/menu/{portal}/{menu}/edit', 'Manage\MenuController@edit')->name('manage.menu.edit');
    Route::get('/manage/menu/detail/{menu}', 'Manage\MenuController@detail')->name('manage.menu.detail');
    Route::patch('/manage/menu/{menu}', 'Manage\MenuController@update')->name('manage.menu.update');
    Route::put('/manage/menu/{portal}/sortable', 'Manage\MenuController@sortable')->name('manage.menu.sortable');
    Route::post('/manage/menu/getListMenu', 'Manage\MenuController@getListMenu')->name('manage.menu.getlistmenu');
    // permission
    Route::resource('manage/permission', 'Manage\PermissionController', ['as' => 'manage']);
    Route::post('/manage/permission/search', 'Manage\PermissionController@search')->name('manage.permission.search');
    // user
    Route::resource('manage/user', 'Manage\UserController', ['as' => 'manage']);
    Route::post('manage/user/search', 'Manage\UserController@search')->name('manage.user.search');
    // profile
    Route::get('user/profile', 'User\BaseProfileController@show')->name('base.user.profile');
    Route::put('user/profile', 'User\BaseProfileController@update')->name('base.user.profile.update');
});