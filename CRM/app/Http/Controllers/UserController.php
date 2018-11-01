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

        # 循环将省市区赋给一维数
        $area = [];
        foreach ( $info as $k => $v ){
            $area[] = $v['province'];
            $area[] = $v['city'];
            $area[] = $v['area'];
        }

//        print_r( $area );exit;
        # 根据用户中的省市区id查询数据
        $area_info = DB::table( 'crm_area' )
            -> whereIn( 'id' , $area )
            -> select( 'id' , 'area_name' )
            -> get();

        # 转成数组格式
        $area_info = $this -> jsonToArray( $area_info );


//        print_r( $area_info );exit;
        # 将省市区的id变为下标
        $arr = [];
        foreach ( $area_info as $kk => $vv ){
            $arr[$vv['id']] = $vv['area_name'];
        }

//        print_r( $info );exit;

        # 循环将客户类型赋给一维数组
        $type = [];
        foreach ($info as $down => $up ){
            $type[] = $up['user_type'];
        }

//        print_r( $type );exit;

        # 根据用户数据中的客户类型id查询对应的数据
        $user_type = DB::table( 'crm_select')
            -> whereIn( 'select_id' , $type )
            -> where( ['select_type' => 1 ] )
            -> select( 'select_name' , 'select_id' )
            -> get();

//        print_r( $user_type );exit;
        # 转为数组格式
        $user_type = $this -> jsonToArray( $user_type );

        # 循环将类型放入一维数组中
        $userType = [];
        foreach ( $user_type as $kkk => $vvv ){
            $userType [$vvv['select_id']] = $vvv['select_name'];
        }

//        print_r( $userType );exit;

        # 循环将客户来源id放入一维数组
        $form = [];
        $place = [];
        foreach ( $info as $i => $t ){
            $form [] = $t['user_from'];
            $place [] = $t['place'];
        }

//        print_r( $form );exit;

        # 根据客户来源id查询对应的数据
        $formInfo = DB::table( 'crm_select' )
            -> whereIn( 'select_id' , $form )
            -> select( 'select_id' , 'select_name' )
            -> get();

        # 转成数组格式
        $formInfo = $this -> jsonToArray( $formInfo );

//        print_r( $formInfo );exit;

        # 循环将id变为下标
        $userForm = [];
        foreach ( $formInfo as $kkkk => $vvvv ){
            $userForm [$vvvv['select_id']] = $vvvv['select_name'];
        }

//        print_r( $place );exit;
        # 根据职位id查询对应的数据
        $placeInfo = DB::table( 'crm_select' )
            -> whereIn( 'select_id' , $place )
            -> select( 'select_id' , 'select_name' )
            -> get();

        # 转为数组格式
        $placeInfo = $this -> jsonToArray( $placeInfo );

//        print_r( $placeInfo );exit;

        # 循环将职位id变为下标
        $userPlace = [];
        foreach ( $placeInfo as $id => $name ){
            $userPlace [$name['select_id']] = $name['select_name'];
        }

//        print_r( $userPlace );exit;

        foreach ( $info as $key => $value ){
            if( $value['user_type'] == $userType[$value['user_type']] ){
                $info[$key]['user_type'] = $userType[$value];
            }

            if( $value['user_from'] == $userForm[$value['user_from']] ){
                $info[$key]['user_from'] = $userForm[$value];
            }

            if( $value['place'] == $userPlace[$value['place']] ){
                $info[$key]['place'] = $userPlace[$value];
            }

            if( $value['province'] == $arr[$value['province']] ){
                $info[$key]['province'] = $arr[$value];
            }

            if( $value['city'] == $arr[$value['city']] ){
                $info[$key]['city'] = $arr[$value];
            }

            if( $value['area'] == $arr[$value['area']] ){
                $info[$key]['area'] = $arr[$value];
            }

            $info[$key]['province'] = $arr[$value['province']];
            $info[$key]['city'] = $arr[$value['city']];
            $info[$key]['area'] = $arr[$value['area']];
            $info[$key]['user_type'] = $userType[$value['user_type']];
            $info[$key]['user_from'] = $userForm[$value['user_from']];
            $info[$key]['place'] = $userPlace[$value['place']];
        }

//        print_r( $info );exit;
        return $this -> show( $count , $info );
    }


    # 编辑客户
    public function userEdit(){

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


        return view( 'user.userEdit' , [
            'position' => $position_info ,
            'area' => $area,
            'type' => $type_info,
            'from' => $from_info,
            'level' => $level_info,
            'cate' => $cate_info
        ] );

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


    # 执行新增客户
    public function insertUserDo( Request $request ){
        # 接收客户名称
        $info['user_name'] = $request -> input( 'name' );

        # 判断客户名称是否合法
        if( !$info['user_name'] ){
            return $this -> fail( '请输入客户名称' );
        }

        # 接收省份
        $info['province'] = $request -> input( 'province' );

        if( !$info['province'] ){
            return $this -> fail( '请选择省份' );
        }


        # 接收市区
        $info['city'] = $request -> input( 'city' );

        if( !$info['city'] ){
            return $this -> fail( '请选择市区' );
        }


        # 接收县/区
        $info['area'] = $request -> input( 'area' );

        if( !$info['area'] ){
            return $this -> fail( '请选择县/区' );
        }


        # 接收详细地址
        $info['area_detail'] = $request -> input( 'detail' );

        if( !$info['area_detail'] ){
            return $this -> fail( '请输入详细地址' );
        }


        # 接收联系人
        $info['admin_name'] = $request -> input( 'contact' );

        if( !$info['admin_name'] ){
            return $this -> fail( '请输入联系人' );
        }


        # 接收职位
        $info['place'] = $request -> input( 'position' );

        if( !$info['place'] ){
            return $this -> fail( '请选择职位' );
        }


        # 接收联系电话    ----  管理员的电话
        $info['admin_phone'] = $request -> input( 'contact_tel' );

        if( !$info['admin_phone'] ){
            return $this -> fail( '请输入联系电话' );
        }


        # 接收手机号码    ----  客户的手机号码
        $info['user_phone'] = $request -> input( 'phone' );

        if( !$info['user_phone'] ){
            return $this -> fail( '请输入手机号码' );
        }


        # 接收产品分类
        $info['cate'] = $request -> input( 'cate' );

        if( !$info['cate'] ){
            return $this -> fail( '请选择产品分类' );
        }


        # 接收客户类型
        $info['user_type'] = $request -> input( 'type' );

        if( !$info['user_type'] ){
            return $this -> fail( '请选择客户类型' );
        }


        # 接收客户来源
        $info['user_from'] = $request -> input( 'from' );

        if( !$info['user_from'] ){
            return $this -> fail( '请选择客户来源' );
        }


        # 接收客户级别
        $info['user_level'] = $request -> input( 'level' );

        if( !$info['user_level'] ){
            return $this -> fail( '请选择客户级别' );
        }


        # 接收备注
        $info['user_remark'] = $request -> input( 'remark' );

        if( !$info['user_remark'] ){
            return $this -> fail( '请选择备注' );
        }

        $info['status'] = 1;
        $info['ctime'] = time();
        $info['utime'] = time();

//        print_r( $info );

        # 先查询数据库判断客户是否已存在

        # 查询条件
        $where = [
            'user_name' => $info['user_name']
        ];

        # 执行查询数据库
        $user_info = DB::table( 'crm_user' )
            -> where( $where )
            -> orWhere( 'user_phone' , '=' , $info['user_phone'])
            -> select( 'user_id' )
            -> first();

        # 转为数组格式
        $user_info = $this -> jsonToArray( $user_info );

//        print_r( $user_info );

        # 判断数组是否为空  --  如果不为空说明该客户或手机号已经存在
        if( !empty( $user_info ) ){
            return $this -> fail( '该客户名称或手机号已经存在' );
        }


        # 执行添加客户
        if( DB::table( 'crm_user') -> insertGetId( $info ) ){
            return $this -> success();
        }else{
            return $this -> fail( '操作失败，请重试' );
        }

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
