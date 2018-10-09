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
        $type_info = [];
        $from_info = [];
        $level_info = [];
        $cate_info = [];
        foreach ( $info as $k => $v ){
            if( $v['select_type'] == 4 ){
                $position_info[] = $v;
            }elseif ( $v['select_type'] == 1 ){
                $type_info[] = $v;
            }elseif ( $v['select_type'] == 2 ){
                $from_info[] = $v;
            }elseif ( $v['select_type'] == 3 ){
                $level_info[] = $v;
            }elseif ( $v['select_type'] == 14 ){
                $cate_info[] = $v;
            }

        }

//        print_r( $type_info );exit;

        # 查询条件
            $area_where = [
                'area_parent_id' => 0
            ];

        # 查询省数据
        $area = DB::table( 'crm_area' )
            -> where( $area_where )
            -> select( 'id' , 'area_name' , 'area_parent_id' )
            -> get();

        # 转成数组格式
        $area = $this -> jsonToArray( $area );

//        print_r( $area );exit;
//        if( !empty( $area ) ){
//           $this -> success( '' , $area );
//        }


        return view( 'user.insertUser' , [
            'position' => $position_info ,
            'area' => $area,
            'type' => $type_info,
            'from' => $from_info,
            'level' => $level_info,
            'cate' => $cate_info
        ] );
    }


    # 地址数据
    public function areaUser( Request $request ){
        # 接收省市区父级id
        $id = $request -> input( 'id' );

//        echo $id;exit;

        # 查询条件
        $area_where = [
            'area_parent_id' => $id
        ];

        # 查询省数据
        $area = DB::table( 'crm_area' )
            -> where( $area_where )
            -> select( 'id' , 'area_name' , 'area_parent_id' )
            -> get();

        # 转成数组格式
        $area = $this -> jsonToArray( $area );


//        print_r( $area );exit;
        if( !empty( $area ) ){
            return $this -> success( '' , $area );
        }

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


    # 新增客户类型
    public function insertType(){
        return view( 'user.insertType' );
    }


    # 执行新增客户类型
    public function insertTypeDo( Request $request ){
        # 接收职位
        $type = $request -> input( 'type' );

//        echo $position;

        # 验证职位
        if( !$type ){
            return $this -> fail( '请输入客户类型' );
        }

        if( is_numeric( $type ) ){
            return $this -> fail( '输入的格式不正确，请重新输入' );
        }

        # 查询条件
        $where = [
            'select_name' => $type,
            'select_type' => 1
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
                'select_name' => $type,
                'select_type' => 1,
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


    # 新增客户来源
    public function insertFrom(){
        return view( 'user.insertFrom' );
    }

    # 执行新增客户来源
    public function insertFromDo( Request $request ){
        # 接收来源
        $from = $request -> input( 'from' );

//        echo $position;

        # 验证职位
        if( !$from ){
            return $this -> fail( '请输入客户来源' );
        }

        if( is_numeric( $from ) ){
            return $this -> fail( '输入的格式不正确，请重新输入' );
        }

        # 查询条件
        $where = [
            'select_name' => $from,
            'select_type' => 2
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
                'select_name' => $from,
                'select_type' => 2,
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


    # 新增客户级别
    public function insertLevel(){
        return view( 'user.insertLevel' );
    }

    # 执行新增客户级别
    public function insertLevelDo( Request $request ){
        # 接收级别
        $level = $request -> input( 'level' );

//        echo $position;

        # 验证职位
        if( !$level ){
            return $this -> fail( '请输入客户级别' );
        }

        if( is_numeric( $level ) ){
            return $this -> fail( '输入的格式不正确，请重新输入' );
        }

        # 查询条件
        $where = [
            'select_name' => $level,
            'select_type' => 3
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
                'select_name' => $level,
                'select_type' => 3,
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
