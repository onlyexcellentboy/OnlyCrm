<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SaleController extends Controller
{
    # 展示售后列表
    public function saleList(){
        return view( 'sale/saleList' );
    }


    # 编辑售后
    public function saleEdit(){
        return view( 'sale/saleEdit' );
    }
}
