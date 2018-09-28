<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    # 管理员列表
    public function adminList(){
        return view( 'admin/adminList' );
    }

    # 管理员编辑
    public function adminEdit(){
        return view( 'admin/adminEdit' );
    }
}
