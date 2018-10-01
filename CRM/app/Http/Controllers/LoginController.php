<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

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



        echo $psd;
    }

}
