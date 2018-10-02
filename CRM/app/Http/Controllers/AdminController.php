<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends CommonController
{
    # 管理员列表
    public function adminList(){
        return view( 'admin/adminList' );
    }

    # 查询管理员数据
    public function adminData(){
        # 查询数据条件
        $where = [
            'admin_status' => 1
        ];

        # 执行查询数据
        $info = DB::table( 'crm_admin' )
            -> where( $where )
            -> select( 'admin_id' , 'admin_account' , 'admin_phone' , 'last_login' )
            -> get();

        # 查询总条数
        $count = DB::table( 'crm_admin' )
            -> where( $where )
            -> count();

        # 转成数组格式
        $info = json_decode( json_encode( $info ) , true );


//        print_r( $info );
        # 拼接返回的json数据
        $admin_info = $this -> show( $count , $info ) ;

        return json_encode( $admin_info );
    }


    # 新增管理员
    public function insertAdmin(){
        return view( 'admin/addAdmin' );
    }

    # 执行新增管理员
    public function insertAdminDo( Request $request ){
        # 接收数据

        # 接收账号
        $account = $request -> input( 'account' );

        # 判断用户名不为空
        if( !$account ){
            return $this -> fail( '请填写用户名' );
        }

        # 接收密码
        $psd = $request -> input( 'psd' );

        # 判断密码不为空
        if( !$psd ){
            return $this -> fail( '请输入登录密码' );
        }

        # 接收确认密码
        $confirm_psd = $request -> input( 'confirm_psd' );

        # 判断确认密码不为空
        if( !$confirm_psd ){
            return $this -> fail( '请输入确认密码' );
        }

        # 判断密码是否和密码一致
        if( $psd != $confirm_psd ){
            return $this -> fail( '确认密码必须和密码一致' );
        }

        # 接收手机号
        $phone = $request -> input( 'tel' );

        # 判断手机号不为空
        if( !$phone ){
            return $this -> fail( '请填写手机号' );
        }

        # 判断手机号为整型
        if( !is_numeric( $phone ) ){
            return $this -> fail( '格式有误，请输入数字' );
        }

        # 判断手机号为11位
       $num = strlen( $phone );
        if( $num != 11 ){
            return $this -> fail( '请输入正确的手机号码' );
        }

//        echo $num;exit;

        # 接收是否实名
        $is_real = $request -> input( 'is_real' );

        # 判断是否实名不为空
        if( !$is_real ){
            return $this -> fail( '请选择是否实名' );
        }


        # 接收是否启用
        $show = $request -> input( 'show' );

        # 判断是否启用不为空
        if( !$show ){
            return $this -> fail( '请选择是否启用' );
        }
//        echo $show;

        # 查询数据库条件
        $where = [
            'admin_account' => $account
        ];

        # 查询数据库
        $data = DB::table( 'crm_admin' )
            -> where( $where )
            -> orWhere( 'admin_phone' , $phone  )
            -> select( 'admin_account' )
            -> first();

//        print_r( $data );

        # 判断该用户名或手机号是否添加过是否
        if( !empty( $data ) ){
            return $this -> fail( '该用户名或手机号已被注册，换一个试试吧' );
        }

        # 生成管理员加密密码 md5（生成规则：密码 + 用户名 ）
        $password = md5( $confirm_psd.$account.time() );

//        echo $password;exit;

        # 添加数据到数据库
        $info['admin_account'] = $account;
        $info['admin_pas'] = $password;
        $info['admin_phone'] = $phone;
        $info['is_real_name'] = $is_real;
        $info['admin_status'] = 1;
        $info['ctime'] = time();
        $info['utime'] = time();

        # 执行添加数据库
        if( DB::table( 'crm_admin') -> insert( $info ) ){
            return $this -> success();
        }else{
            return $this -> fail( '添加失败，请重试' );
        }

    }

    # 管理员编辑
    public function adminEdit( Request $request ){
        # 接受要编辑的管理员id
        $id = $request -> input( 'id' );

        # 查询条件
        $where = [
            'admin_id' => $id
        ];

        # 根据接到的id查询一条数据
//        $info = DB::table( 'crm_admin' )
//            -> where( $where )
//            -> select( 'admin_account' , '')
        return view( 'admin/adminEdit' );
    }

    # 管理员删除（修改状态）
    public function adminDel( Request $request ){
        # 接收要删除的管理员id
        $id = $request -> input( 'id' );

//        echo $id;
        # 判断id不为空
        if( !$id ){
            return $this -> fail( '请选择要删除的管理员' );
        }

        # 根据接收到的id进行修改状态
        $where = [
            'admin_id' => $id
        ];

        $data = [
            'admin_status' => 2
        ];

        # 执行修改状态
        $res = DB::table( 'crm_admin' )
            -> where( $where )
            -> update( $data );

        if( $res ){
            return $this -> success( '删除成功' );
        }else{
            return $this -> fail( '请求失败，请重试' );
        }

    }

}
