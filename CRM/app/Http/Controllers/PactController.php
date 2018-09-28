<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PactController extends Controller
{
    # 展示订单列表
    public function pactList(){
        return view( 'pact/pactList' );
    }
}
