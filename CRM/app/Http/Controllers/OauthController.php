<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class oauthController extends Controller
{

    # oauth登录页面
    public function oauthLogin(){
        return view( 'oauth.oauthLogin' );
    }


    # oauth登录接口  ---- 生成code

    /**
     * @param $id 客户id
     * @param $redirect_url  回调url地址
     */
    public function oauth( Request $request ){
        # 判断是否登录
//        $user = $request -> cookie( 'userInfo' );
//
////        print_r( $user );exit;
//        if( empty( $user ) ){
//            return redirect() -> route( 'oauthLogin' );
//        }


        return view( 'Oauth.oauthApi' );
    }
}
