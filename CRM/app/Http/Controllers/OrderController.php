<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OrderController extends Controller
{
    # 展示订单列表
    public function orderList(){
        return view( 'order/orderList' );
    }
}
