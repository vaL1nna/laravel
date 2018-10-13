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

Route::get('register', function () {
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

    //关于我们模块
    Route::group(['prefix' => 'aboutUs'], function (){
        Route::get('list', 'AboutUsController@list');
        Route::match(['get', 'post'], 'add', 'AboutUsController@add');
        Route::get('edit/{id}', 'AboutUsController@edit');
        Route::post('edit', 'AboutUsController@edit');
        Route::post('del', 'AboutUsController@del');
        Route::post('batchUpdate', 'AboutUsController@batchUpdate');
        Route::post('batchDel', 'AboutUsController@batchDel');
    });

    //广告管理模块
    Route::group(['prefix' => 'banner'], function (){
        Route::get('list', 'BannerController@list');
        Route::match(['get', 'post'], 'add', 'BannerController@add');
        Route::get('edit/{id}', 'BannerController@edit');
        Route::post('edit', 'BannerController@edit');
        Route::post('del', 'BannerController@del');
        Route::post('batchUpdate', 'BannerController@batchUpdate');
        Route::post('batchDel', 'BannerController@batchDel');
    });

    //客户服务管理模块
    Route::group(['prefix' => 'service'], function (){
        Route::get('list', 'ServiceController@list');
        Route::match(['get', 'post'], 'add', 'ServiceController@add');
        Route::get('edit/{id}', 'ServiceController@edit');
        Route::post('edit', 'ServiceController@edit');
        Route::post('del', 'ServiceController@del');
        Route::post('batchUpdate', 'ServiceController@batchUpdate');
        Route::post('batchDel', 'ServiceController@batchDel');
    });

    //系统设置模块
    Route::group(['prefix' => 'setting'], function (){
        Route::match(['get', 'post'], 'system', 'SettingController@system');
        Route::match(['get', 'post'], 'service', 'SettingController@service');
    });
});

//前台模块
Route::group(['namespace' => 'Home'], function (){
    Route::get('index', 'IndexController@index');
});


