<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PowerController extends Controller
{
    # 展示权限列表
    public function powerList(){
        return view( 'power/powerList' );
    }

    # 权限编辑
    public function powerEdit(){
        return view( 'power/powerEdit' );
    }
}
