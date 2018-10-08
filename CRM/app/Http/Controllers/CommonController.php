<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CommonController extends Controller
{
    # 封装成功提示
    public function success( $msg = '' , $data = []){
        return json_encode( ['status' => 1000 , 'msg' => $msg , 'data' => $data ] );
    }

    # 封装失败提示
    public function fail( $msg = '' ){
        return json_encode( ['status' => 100 , 'msg' => $msg ] );
    }

    # 封装展示的数据
    public function show( $count , $info ){
        return  ['code' => 0 , 'msg' => '' , 'count' => $count , 'data' => $info ];
    }

    # 封装转数组格式方法
    public function jsonToArray( $data = '' ){
        return json_decode( json_encode( $data ) , true );
    }
}
