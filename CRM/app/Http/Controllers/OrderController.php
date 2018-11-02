<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends CommonController
{
    # 展示订单列表
    public function orderList(){
        return view( 'order/orderList' );
    }


    # 查询订单数据
    public function orderInfo(){
        # 查询订单信息
        $orderInfo = DB::table( 'crm_order' )
            -> get();

        # 转为数组格式
        $orderInfo = $this -> jsonToArray( $orderInfo );


        # 查询总条数
        $count = DB::table( 'crm_order' )
            -> count();

//        print_r( $count );exit;

        # 循环取出操作员id
        $admin_id = [];
        foreach ( $orderInfo as $k => $v ){
            $admin_id[] = $v['admin_id'];
        }

        # 根据操作员id查询名称
        $where = [
            'admin_id' => $admin_id,
            'admin_status' => 2
        ];

        # 执行查询管理员数据
        $adminInfo = DB::table( 'crm_admin' )
            -> where( $where )
            -> select( 'admin_id' , 'admin_name' )
            ->get();

        # 转为数组格式
        $adminInfo = $this -> jsonToArray( $adminInfo );

//        print_r( $adminInfo );

        # 循环将查出来的管理员id变为下标
        $adminId = [];
        foreach ( $adminInfo as $key => $value ){
            $adminId [$value['admin_id']] = $value['admin_name'];
        }

//        print_r( $adminId );exit;

        foreach ( $orderInfo as $kk => $vv ){
            if( $vv['admin_id'] == $adminId[$vv['admin_id']] ){
                $orderInfo[$kk]['admin_id'] = $adminId[$vv];
            }


            if( $orderInfo[$kk]['status'] == 1 ){
                $orderInfo[$kk]['status'] = '订单未完成';
            }else{
                $orderInfo[$kk]['status'] = '订单完成';
            }

            $orderInfo[$kk]['admin_id'] = $adminId[$vv['admin_id']];

            # 将时间转为日期格式
            $orderInfo[$kk]['create_time'] = date( 'Y-m-d H:i:s' , $vv['create_time'] );
            $orderInfo[$kk]['submit_time'] = date( 'Y-m-d H:i:s' , $vv['submit_time'] );
            $orderInfo[$kk]['ctime'] = date( 'Y-m-d H:i:s' , $vv['ctime'] );
            $orderInfo[$kk]['utime'] = date( 'Y-m-d H:i:s' , $vv['utime'] );
        }

//        print_r( $orderInfo );

            return $this -> show( $count , $orderInfo );
    }


    # 新增订单
    public function insertOrder( Request $request ){
        # 取出session中的用户数据
        $user_info[] = $request -> session() -> get( 'user_info' );

//        print_r( $user_info );exit;

        return view( 'order.addOrder' , [ 'user_info' => $user_info ] );
    }


    # 执行新增订单
    public function insertOrderDo( Request $request ){
        # 接收订单名称
        $data['order_name'] = $request -> input( 'order_name' );

        # 判断订单名称是否为空
        if( empty( $data['order_name'] ) ){
            return $this -> fail( '请填写订单名称' );
        }

        # 接收订单联系人
        $data['admin_id'] = $request -> input( 'admin_id' );

        # 判断订单联系人是否为空
        if( empty( $data['admin_id'] ) ){
            return $this -> fail( '请选择订单联系人' );
        }

        # 判断订单联系人是否为整型
        if( !is_numeric( $data['admin_id'] ) ){
            return $this -> fail( '订单联系人格式有误' );
        }

        # 接收下单日期
        $data['create_time'] = $request -> input( 'create_time' );

        # 判断下单日期是否为空
        if( empty( $data['create_time'] ) ){
            return $this -> fail( '请选择下单日期' );
        }

        # 将日期转为时间戳
        $data['create_time'] = strtotime( $data['create_time'] );

//        echo $data['create_time'];
        # 判断是否为时间戳
        if( !is_numeric( $data['create_time']) && strlen( $data['create_time'] != 11 ) ){
            return $this -> fail( '请选择正确的下单日期' );
        }


        # 接收交单日期
        $data['submit_time'] = $request -> input( 'submit_time' );

        # 判断交单日期是否为空
        if( empty( $data['submit_time'] ) ){
            return $this -> fail( '请选择交单日期' );
        }

        # 将日期转为时间戳
        $data['submit_time'] = strtotime( $data['submit_time'] );

//        echo $data['create_time'];
        # 判断是否为时间戳
        if( !is_numeric( $data['submit_time'] ) && strlen( $data['submit_time'] ) != 10 ){
            return $this -> fail( '请选择正确的交单日期' );
        }



    }

}
