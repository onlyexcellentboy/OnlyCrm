<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;

class LoginController extends Controller
{
    //登录页面
    public function login_list(){
        return view('login/login');
    }

    # 登录
    public function checkLogin( Request $request ){
        # 接收用户名
        $account = $request -> input( 'account' );

        # 判断用户名不为空
        if( !$account ){
            return json_encode( ['status' => 100, 'msg' => '请输入用户名'] );
        }

        # 接收密码
        $psd = $request -> input( 'psd' );

        # 判断密码不为空
        if( !$psd ){
            return json_encode( ['status' => 100, 'msg' => '请输入密码'] );
        }

        # 查询条件
        $where = [
            'admin_account' => $account,
            'admin_status' => 1
        ];

        # 根据输入的用户名查询数据库
        $info = DB::table( 'crm_admin' )
            -> where( $where )
            -> select( 'admin_account' , 'admin_pas' )
            -> first();

//        print_r( $info );
        # 转成数组格式
        $info = json_decode( json_encode( $info ) , true );

        # 判断数据是否为空
        if( empty( $info) ){
            return  json_encode( ['status' => 100, 'msg' => '该用户不存在或已删除'] );
        }

        # 将接收到的密码按照 md5（密码 + 用户名 ）跟查询出来密码进行匹配
        $password = md5( $psd.$account );

//        echo $password;exit;

        # 判断密码是否正确
        if( $password != $info['admin_pas'] ){
            return json_encode( ['status' => 100, 'msg' => '用户名或密码有误'] );
        }else{
            Cookie::queue( 'user' , $info );
            return json_encode( ['status' => 1000, 'msg' => '登录成功'] );
        }

    }

}
