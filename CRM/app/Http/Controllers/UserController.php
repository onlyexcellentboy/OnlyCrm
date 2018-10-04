<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends CommonController
{
    # 展示客户列表
    public function userList(){
        return view( 'user/userList' );
    }

    # 客户数据
    public function userInfo(){
        # 查询数据条件
        $where = [
            'status' => 1
        ];

        # 执行查询数据
        $info = DB::table( 'crm_user' )
            -> where( $where )
            -> get();

        # 转成数组格式
        $info = json_decode( $info , true );

        # 查询总条数
        $count = DB::table( 'crm_user' )
            -> where( $where )
            -> count();

//        print_r( $info );
        return $this -> show( $count , $info );
    }


    # 编辑客户
    public function userEdit(){
        return view( 'user/userEdit' );
    }
}
