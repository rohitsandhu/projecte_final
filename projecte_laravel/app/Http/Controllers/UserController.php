<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    function home (Request $request){
        return view('home');
    }

    function historial (Request $request){
        return view('historial');
    }

}
