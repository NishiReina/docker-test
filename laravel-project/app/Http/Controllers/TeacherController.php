<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


class TeacherController extends Controller
{
    
    public function unique_id(Request $request){

        // 文字列発行　頭(0)から8文字
        // dd(substr(sha1(uniqid(rand(), true)), 0, 8));
        return substr(sha1(uniqid(rand(), true)), 0, 8);
        
    }
}
