<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RoleController extends Controller
{
    # 展示角色列表
    public function roleList(){
        return view( 'role/roleList' );
    }


    # 编辑角色
    public function roleEdit(){
        return view( 'role/roleEdit' );
    }
}
