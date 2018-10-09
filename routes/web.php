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
})->name('register');

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
        Route::post('batchDel', 'ManagerController@batchDel');
    });

    //导航模块
    Route::group(['prefix' => 'nav'], function (){
        Route::get('list', 'NavController@list');
        Route::match(['get', 'post'], 'add', 'NavController@add');
        Route::get('edit/{id}', 'NavController@edit');
        Route::post('edit', 'NavController@edit');
        Route::post('del', 'NavController@del');
        Route::post('batchDel', 'NavController@batchDel');
    });

    //新闻模块
    Route::group(['prefix' => 'news'], function (){
        Route::get('list', 'NewsController@list');
        Route::match(['get', 'post'], 'add', 'NewsController@add');
        Route::get('edit/{id}', 'NewsController@edit');
        Route::post('edit', 'NewsController@edit');
        Route::post('del', 'NewsController@del');
        Route::post('batchUpdate', 'NewsController@batchUpdate');
        Route::post('batchDel', 'NewsController@batchDel');
    });

    //产品模块
    Route::group(['prefix' => 'product'], function (){
        Route::get('list', 'ProductController@list');
        Route::match(['get', 'post'], 'add', 'ProductController@add');
        Route::get('edit/{id}', 'ProductController@edit');
        Route::post('edit', 'ProductController@edit');
        Route::post('del', 'ProductController@del');
        Route::post('batchUpdate', 'ProductController@batchUpdate');
        Route::post('batchDel', 'ProductController@batchDel');
    });

    //应该领域模块
    Route::group(['prefix' => 'application'], function (){
        Route::get('list', 'ApplicationController@list');
        Route::match(['get', 'post'], 'add', 'ApplicationController@add');
        Route::get('edit/{id}', 'ApplicationController@edit');
        Route::post('edit', 'ApplicationController@edit');
        Route::post('del', 'ApplicationController@del');
        Route::post('batchUpdate', 'ApplicationController@batchUpdate');
        Route::post('batchDel', 'ApplicationController@batchDel');
    });
});

//前台模块
Route::group(['namespace' => 'Home', 'prefix' => 'nav'], function (){
    Route::get('header', 'NavController@header');
    Route::get('footer', 'NavController@footer');
});


