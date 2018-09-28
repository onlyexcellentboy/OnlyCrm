<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    # 展示费用列表
    public function expenseList(){
        return view( 'expense/expenseList' );
    }

    # 费用编辑
    public function expenseEdit(){
        return view( 'expense/expenseEdit' );
    }
}
