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

//登陆模块
Route::match(["get", "post"], "admin/login", "Admin\ManagerController@login")->name('login');

//后台模块
Route::group(['middleware' => 'auth:admin'], function () {
    Route::get('admin/index', 'Admin\IndexController@index');
    Route::get('admin/welcome', 'Admin\IndexController@welcome');
    Route::get('admin/logout', 'Admin\ManagerController@logout');

    Route::get('admin/manager/list', 'Admin\ManagerController@list');
    Route::match(['get', 'post'], 'admin/manager/add', 'Admin\ManagerController@add');
    Route::post('admin/manager/del', 'Admin\ManagerController@del');
});

