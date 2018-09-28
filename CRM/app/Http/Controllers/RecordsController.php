<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RecordsController extends Controller
{
    # 展示跟单列表
    public function recordsList(){
        return view( 'records/recordsList' );
    }
}
