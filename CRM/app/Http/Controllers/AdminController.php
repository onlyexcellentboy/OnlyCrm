<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
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
        $admin_info = ['code' => 0 , 'msg' => '' , 'count' => $count , 'data' => $info ] ;

        return json_encode( $admin_info );
    }

    # 管理员编辑
    public function adminEdit(){
        return view( 'admin/adminEdit' );
    }
}
