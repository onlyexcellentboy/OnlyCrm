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

    # 删除客户（修改状态）
    public function userDel( Request $request ){
        # 接收要删除的客户id
        $id = $request -> input( 'id' );

//        echo $id;

        # 判断id是否存在
        if( !$id ){
            return $this -> fail( '请选择要删除的客户' );
        }

        # 查询条件
        $where = [
            'user_id' => $id
        ];

        # 根据id查询状态是否是正常
        $info = DB::table( 'crm_user' )
            -> where( $where )
            -> select( 'status' )
            -> first();

        # 转成数组格式
        $info = $this -> jsonToArray( $info );

//        print_r( $info['status'] );

        # 判断状态是否正常
        if( $info['status'] != 1 ){
            return $this -> fail( '该客户不存在或已删除' );
        }else{
            $data = [
                'status' => 2
            ];

            # 修改状态
            if( DB::table( 'crm_user') -> where( $where ) -> update( $data ) ){
                return $this -> success();
            }else{
                return $this -> fail( '操作失败，请重试' );
            }

        }

    }


    # 新增客户
    public function insertUser(){
        # 查询条件
        $where = [
            'status' => 1
        ];

        # 执行查询下拉框数据
        $info = DB::table( 'crm_select' )
            -> where( $where )
            -> select(  'select_id' ,'select_name' , 'select_type' )
            -> get();

        # 转成数组格式
        $info = $this -> jsonToArray( $info );


        # 循环将类型变为数组的键
        $position_info = [];
        foreach ( $info as $k => $v ){
            if( $v['select_type'] == 4 ){
                $position_info[] = $v;
            }

        }



//        print_r( $position_info );exit;


        return view( 'user.insertUser' , ['position' => $position_info] );
    }

    # 新增职位
    public function insertPosition(){
        return view( 'user.insertPosition' );
    }


    # 执行新增职位
    public function insertPositionDo( Request $request ){
        # 接收职位
        $position = $request -> input( 'position' );

//        echo $position;

        # 验证职位
        if( !$position ){
            return $this -> fail( '请输入职位' );
        }

        if( is_numeric( $position ) ){
            return $this -> fail( '输入的格式不正确，请重新输入' );
        }

        # 查询条件
        $where = [
            'select_name' => $position,
            'select_type' => 4
        ];


        # 验证该职位是否已存在
        $info = DB::table( 'crm_select' )
            -> where( $where )
            -> select( 'select_id' )
            -> first();

        # 转为数组格式
        $info = $this -> jsonToArray( $info );

//        print_r( $info );exit;

        if( empty($info ) ){

            # 添加职位到数据库
            $data = [
                'select_name' => $position,
                'select_type' => 4,
                'status' => 1,
                'ctime' => time(),
                'utime' => time()
            ];

            # 执行添加
            if( DB::table( 'crm_select') -> insertGetId( $data ) ){
                return $this -> success();
            }else{
                return $this -> fail( '操作失败，请重试' );
            }
        }else{
            return $this -> fail( '该职位已存在，请勿重复操作' );
        }

    }
}
