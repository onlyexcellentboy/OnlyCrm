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
//            Cookie::queue( 'user' , $info , 180 );
            return json_encode( ['status' => 1000, 'msg' => '登录成功'] );
        }

    }


    # 微博登录
    public function wbLogin(){
        # 接收临时令牌
        $code = $_GET['code'];

//        echo $code;exit;

        # 请求参数
        $params = [
            'client_id' => 711488263,
            'client_secret' => '24015898a7a47a26ab937ee598ad1e7f',
            'grant_type' => 'authorization_code',
            'code' => $code,
            'redirect_uri' => 'http://www.crm.com/wbLogin'
        ];

        # 请求地址
        $url = 'https://api.weibo.com/oauth2/access_token';

        # 调用请求方法
        $data =  $this -> wbLoginDo( $url , $params );

        # 转为数组格式
        $data = json_decode(  $data , true );

//        print_r( $data );

        # 判断是否取到token   ----  查询用户信息接口
        if( !empty( $data['access_token'] ) ){

            # 取到的access_token
            $token = $data['access_token'];

            # 查询用户信息接口url
            $user_url = 'https://api.weibo.com/2/users/show.json';

//            $user_info = $this -> wbLoginDo( $user_url );

            # 调用查询用户信息接口
            $user_info = header( 'location:' . $user_url . '?access_token='.$token.'&screen_name='.'冯天乐23310' );

            print_r( $user_info );
        }else{

            return '非法请求';
        }

    }


    # 执行微博登录
    public function wbLoginDo( $url,$vars = [] ){

        $ch = curl_init();
        $params[CURLOPT_URL] = $url;    //请求url地址
        $params[CURLOPT_HEADER] = false; //是否返回响应头信息
        $params[CURLOPT_RETURNTRANSFER] = true; //是否将结果返回
        $params[CURLOPT_FOLLOWLOCATION] = true; //是否重定向
        $params[CURLOPT_USERAGENT] = 'Mozilla/5.0 (Windows NT 5.1; rv:9.0.1) Gecko/20100101 Firefox/9.0.1';

        $postfields = '';
        foreach ($vars as $key => $value){
            $postfields .= urlencode($key) . '=' . urlencode($value) . '&';
        }
        $params[CURLOPT_POST] = true;
        $params[CURLOPT_POSTFIELDS] = $postfields;

        //解决方案一 禁用证书验证
        $params[CURLOPT_SSL_VERIFYPEER] = false;
        $params[CURLOPT_SSL_VERIFYHOST] = false;

        curl_setopt_array($ch, $params); //传入curl参数
        return  curl_exec($ch); //执行
    }


}
