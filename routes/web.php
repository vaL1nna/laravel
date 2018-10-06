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
Route::group(['middleware' => 'auth:admin', 'prefix' => 'admin', 'namespace' => 'Admin'], function () {
    Route::get('index', 'IndexController@index');
    Route::get('welcome', 'IndexController@welcome');
    Route::get('logout', 'ManagerController@logout');

    //管理员模块
    Route::group(['prefix' => 'manager'], function (){
        Route::get('list', 'ManagerController@list');
        Route::match(['get', 'post'], 'add', 'ManagerController@add');
        Route::post('del', 'ManagerController@del');
        Route::get('edit/{mg_id}', 'ManagerController@edit');
        Route::post('edit', 'ManagerController@edit');
        Route::post('/batchDel', 'ManagerController@batchDel');
    });

    //导航模块
    Route::group(['prefix' => 'nav'], function (){
        Route::get('index', 'NavController@index');
        Route::match(['get', 'post'], 'add', 'NavController@add');
        Route::get('edit/{id}', 'NavController@edit');
        Route::post('edit', 'NavController@edit');
        Route::post('del', 'NavController@del');
    });

});

//前台模块
Route::group(['namespace' => 'Home', 'prefix' => 'nav'], function (){
    Route::get('header', 'NavController@header');
    Route::get('footer', 'NavController@footer');
});


