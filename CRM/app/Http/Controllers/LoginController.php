<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    //登录页面
    public function login_list(){
        return view('login');
    }

}
