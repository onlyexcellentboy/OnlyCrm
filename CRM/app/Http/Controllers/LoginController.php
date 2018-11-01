<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

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
            'admin_name' => $account,
            'admin_status' => 2
        ];

        # 根据输入的用户名查询数据库
        $info = DB::table( 'crm_admin' )
            -> where( $where )
            -> select( 'admin_name' , 'admin_pas' )
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
//            $request -> cookie( 'userInfo' , $info )
//            print_r( $info );exit;
//            if( Session::put( 'userInfo' , $info ) ){

                return json_encode( ['status' => 1000, 'msg' => '登录成功'] );
//            }

        }

    }


    # 微博登录
    public function wbLogin( Request $request ){
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
        $data =  $this -> curl( $url , $params );

        # 转为数组格式
        $data = json_decode(  $data , true );

//        print_r( $data );

        # 判断是否取到token   ----  查询用户信息接口
        if( !empty( $data['access_token'] ) ){

            # 取到的access_token
            $token = $data['access_token'];

            # 查询用户信息接口url
            $user_url = 'https://api.weibo.com/2/users/show.json?access_token='.$token.'&uid='.$data['uid'];

            # 调用查询用户信息接口
            $user_info = $this -> wbLoginDo( $user_url );

            # 调用查询用户信息接口
//            $user_info = header( 'location:' . $user_url . '?access_token='.$token.'&uid='.$data['uid'] );


            # 将用户信息转为数组
            $user_info = json_decode( $user_info , true );
//            print_r( $user_info );

            # 判断用户信息不为空的情况下选择绑定账号
            if( !empty( $user_info['id'] && $user_info['screen_name'] ) ){
//              return  redirect() -> route('wbBinding');
                return $this -> wbBinding( $user_info['id'] , $user_info['screen_name'] );
            }else{
                return '该用户不存在';
            }
        }else{

            return '非法请求';
        }

    }


    # curl 请求 --- 1
    public function wbLoginDo( $url,$data = '' ){

        $ch = curl_init();
        $params[CURLOPT_URL] = $url;    //请求url地址
        $params[CURLOPT_HEADER] = false; //是否返回响应头信息
        $params[CURLOPT_RETURNTRANSFER] = true; //是否将结果返回
        $params[CURLOPT_FOLLOWLOCATION] = true; //是否重定向
        $params[CURLOPT_TIMEOUT] = 30; //超时时间
        if(!empty($data)){
            $params[CURLOPT_POST] = true;
            $params[CURLOPT_POSTFIELDS] = $data;
        }
        $params[CURLOPT_SSL_VERIFYPEER] = false;//请求https时设置,还有其他解决方案
        $params[CURLOPT_SSL_VERIFYHOST] = false;//请求https时,其他方案查看其他博文
        curl_setopt_array($ch, $params); //传入curl参数
        $content = curl_exec($ch); //执行
        curl_close($ch); //关闭连接
        return $content;
    }


    # curl 请求 ---- 2
    public function curl( $url,$vars ){
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

        $postfields = rtrim( $postfields , '&' );

        $params[CURLOPT_POST] = true;
        $params[CURLOPT_POSTFIELDS] = $postfields;

        //解决方案一 禁用证书验证
        $params[CURLOPT_SSL_VERIFYPEER] = false;
        $params[CURLOPT_SSL_VERIFYHOST] = false;

        curl_setopt_array($ch, $params); //传入curl参数
        $res = curl_exec($ch); //执行

//        print_r( $res );
        return $res;
    }


    public function test( Request $request ){
        return $request -> header();
    }


    # 微博登录绑定系统账号
    public function wbBinding( $id , $name ){
//        echo $id;
//
//        echo $name;

        # 先根据接到的微博id查询数据库

        # 查询条件
        $where = [
            'wb_id' => $id
        ];

        # 执行查询
        $info = DB::table( 'crm_admin' )
            -> where( $where )
            -> select( 'admin_id' , 'wb_id' , 'wb_name' )
            -> first();

        # 转成数组格式
        $info = json_decode( json_encode( $info ) , true );

//         print_r( $info );

        if( empty( $info['wb_id'] && $info['wb_name'] ) ){
            return view( 'login.wbBinding' , ['id' => $id , 'name' => $name] );
        }else{
            return redirect() -> route('index' );
        }


    }


    # 执行微博登录绑定系统账号
    public function wbBindingDo( Request $request ){
        # 接收微博id
        $wb_id = $request -> input( 'wb_id' );

        # 验证微博id
        if( !$wb_id ){
            return json_encode( ['status' => 100 , 'msg' => '操作有误'] );
        }

        # 接收微博昵称
        $wb_name = $request -> input( 'wb_name' );

        # 验证微博昵称
        if( !$wb_name ){
            return json_encode( ['status' => 100 , 'msg' => '非法操作'] );
        }


        # 接收用户名
        $user = $request -> input( 'username' );

        # 验证用户名
        if( !$user ){
            return json_encode( ['status' => 100 , 'msg' => '请输入用户名'] );
        }


        # 接收密码
        $psd = $request -> input( 'psd' );

        # 验证密码
        if( !$psd ){
            return json_encode( ['status' => 100 , 'msg' => '请输入密码'] );
        }


        # 先根据接到的用户名查询是否有该用户    再验证密码是否正确

        # 查询条件
        $where = [
            'admin_name' => $user
        ];

        # 查询用户信息
        $user_info = DB::table( 'crm_admin' )
            -> where( $where )
            -> select( 'admin_id' , 'admin_pas' )
            -> first();

        # 转为数组格式
        $user_info = json_decode( json_encode( $user_info ) , true );

//        print_r( $user_info );

        # 判断数据是否为空
        if( empty( $user_info ) ){
            return  json_encode( ['status' => 100 , 'msg' => '该用户不存在，请确认输入是否正确'] );
        }

        # 验证密码是否正确

        # 生成密码
        $pwd = md5( $psd . $user );

//        echo $pwd;

        # 验证密码是否正确
        if( $pwd != $user_info['admin_pas'] ){

            return  json_encode( ['status' => 100 , 'msg' => '用户名或密码不正确'] );
        }else{

            # 要入库的数据
            $data = [
                'wb_id' => $wb_id,
                'wb_name' => $wb_name
            ];

            # 条件
            $save_where = [
                'admin_id' => $user_info['admin_id']
            ];

//            print_r( $data );exit;

            if( DB::table( 'crm_admin') -> where( $save_where ) -> update( $data ) ){
                return  json_encode( ['status' => 1000 , 'msg' => 'success'] );
            }else{
                return  json_encode( ['status' => 100 , 'msg' => '操作失败，请重试'] );
            }

        }

    }


    # 第三方登录
    public function elseLogin(){
        # 接收临时令牌
        $code = $_GET['code'];

        # 请求参数
        $params = [
            'appid' => 1952145219,
            'app_secret' => '1974sa521v4b25g4b12g5b1h421bgvg9',
            'type' => 'oauth',
            'code' => $code,
            'rederect_url' => 'http://www.crm.com/elseLogin'
        ];

        # 请求地址
        $url = 'http://188.131.133.134/createToken';

        # 调用接口
        $token = $this -> wbLoginDo( $url , $params );

        # 将返回的数据转为数组格式
        $token = json_decode( $token , true );

//        print_r( $token );

        # 判断返回的数据中存在token并且不为空
        if( !empty( $token['access_token'] ) ){
            # 请求地址
            $user_url = 'http://188.131.133.134/showUser?access_token='.$token['access_token'] . '&uid=' . $token['uid'];

            # 调用查询用户信息接口
            $userInfo = $this -> wbLoginDo( $user_url );


            # 转成数组形式
            $userInfo = json_decode( $userInfo , true );

//            print_r( $userInfo );

            # 判断返回的数据不为空
            if( !empty( $userInfo['user_phone'] ) ){
                #添加到数据库
                if( DB::table( 'crm_user' ) -> insert( $userInfo) ){
                    return redirect() -> route( 'index' );
                }

            }

        }

    }

}
