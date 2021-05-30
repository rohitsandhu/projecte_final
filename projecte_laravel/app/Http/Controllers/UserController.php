<?php

namespace App\Http\Controllers;

use App\Models\Partida;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    function home (Request $request){
        return view('home');
    }

    function historial (Request $request){

        $historial = Partida::where('b_id','=',Auth::user()->id)->orWhere('n_id','=',Auth::user()->id)->get();
        return view('historial',compact('historial'));
    }

}
