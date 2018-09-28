<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    # 展示客户列表
    public function userList(){
        return view( 'user/userList' );
    }


    # 编辑客户
    public function userEdit(){
        return view( 'user/userEdit' );
    }
}
