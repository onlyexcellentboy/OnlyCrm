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
Route::get('index', function () {
    return view('index');
})->name('index');

# 角色列表
Route::get( 'role' , 'RoleController@roleList' );

# 角色编辑
Route::get( 'edit' , 'RoleController@roleEdit' );

#登录页面
Route::get( '/' , 'LoginController@login_list' );

# 登录
Route::post( 'checkLogin' , 'LoginController@checkLogin' );

# 微博登录
Route::get( 'wbLogin' , 'LoginController@wbLogin' );

# 执行微博登录
Route::get( 'wbLoginDo' , 'LoginController@wbLoginDo' );

# 查询微博用户信息
Route::get( 'userInfo' , 'LoginController@userInfo' );


# 微博登录绑定系统账号
Route::get( 'wbBinding' , 'LoginController@wbBinding' );


# 执行微博登录绑定系统账号
Route::post( 'wbBindingDo' , 'LoginController@wbBindingDo' );


# 系统菜单
Route::get( 'systemMenu' , 'SystemController@menuList' );

# 系统菜单编辑
Route::get( 'menuEdit' , 'SystemController@menuEdit' );

# 管理员列表
Route::get( 'admin' , 'AdminController@adminList' );

# 管理员数据
Route::get( 'admin_data' , 'AdminController@adminData' );

# 新增管理员
Route::get( 'insertAdmin' , 'AdminController@insertAdmin' );

# 执行新增管理员
Route::post( 'insertAdminDo' , 'AdminController@insertAdminDo' );

# 管理员编辑
Route::get( 'adminEdit' , 'AdminController@adminEdit' );

# 删除管理员
Route::get( 'adminDel' , 'AdminController@adminDel' );

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

# 客户信息
Route::get( 'userInfo' , 'UserController@userInfo' );

# 客户编辑
Route::get( 'userEdit' , 'UserController@userEdit' );

# 删除客户
Route::get( 'userDel' , 'UserController@userDel' );

# 新增客户
Route::get( 'insertUser' , 'UserController@insertUser' );


# 执行新增客户
Route::post( 'insertUserDo' , 'UserController@insertUserDo' );

# 新增职位
Route::get( 'insertPosition' , 'UserController@insertPosition' );


# 执行新增职位
Route::post( 'insertPositionDo' , 'UserController@insertPositionDo' );


# 新增客户类型
Route::get( 'insertType' , 'UserController@insertType' );


# 执行新增客户类型
Route::post( 'insertTypeDo' , 'UserController@insertTypeDo' );



# 新增客户来源
Route::get( 'insertFrom' , 'UserController@insertFrom' );


# 执行新增客户来源
Route::post( 'insertFromDo' , 'UserController@insertFromDo' );


# 新增客户级别
Route::get( 'insertLevel' , 'UserController@insertLevel' );


# 执行新增客户级别
Route::post( 'insertLevelDo' , 'UserController@insertLevelDo' );


# 查询地址
Route::get( 'areaUser' , 'UserController@areaUser' );


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

Route::get( 'test' , 'LoginController@test' );
