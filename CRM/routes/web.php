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

#登录页面
Route::get( 'login_list' , 'LoginController@login_list' );

# 系统菜单
Route::get( 'systemMenu' , 'SystemController@menuList' );

# 系统菜单编辑
Route::get( 'menuEdit' , 'SystemController@menuEdit' );

# 管理员列表
Route::get( 'admin' , 'AdminController@adminList' );

# 管理员编辑
Route::get( 'adminEdit' , 'AdminController@adminEdit' );

# 订单列表
Route::get( 'order' , 'OrderController@orderList' );

# 合同列表
Route::get( 'pact' , 'PactController@pactList' );

# 跟单列表
Route::get( 'records' , 'RecordsController@recordsList' );

# 跟单编辑
Route::get( 'recordsEdit' , 'RecordsController@recordsEdit' );

# 客户管理
Route::get( 'user' , 'UserController@userList' );

# 客户编辑
Route::get( 'userEdit' , 'UserController@userEdit' );

# 售后管理
Route::get( 'sale' , 'SaleController@saleList' );

# 售后编辑
Route::get( 'saleEdit' , 'SaleController@saleEdit' );

# 费用管理
Route::get( 'expense' , 'ExpenseController@expenseList' );

# 费用编辑
Route::get( 'expenseEdit' , 'ExpenseController@expenseEdit' );

# 权限列表
Route::get( 'power' , 'PowerController@powerList' );

# 权限编辑
Route::get( 'powerEdit' , 'PowerController@powerEdit' );
