<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SystemController extends Controller
{
    # 菜单列表
    public function menuList(){
        return view( 'systemMenu' );
    }

    # 编辑菜单
    public function menuEdit(){
        return view( 'menuEdit' );
    }
}
