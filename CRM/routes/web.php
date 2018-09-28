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

# 首页
Route::get('/', function () {
    return view('index');
});

# 角色列表
Route::get( 'role' , 'RoleController@roleList' );

# 角色编辑
Route::get( 'edit' , 'RoleController@roleEdit' );