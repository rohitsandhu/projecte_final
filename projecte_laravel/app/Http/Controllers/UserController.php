<?php

namespace App\Http\Controllers;

use App\Models\MovimentsPartida;
use App\Models\Partida;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    function home (Request $request){
        return view('home');
    }

    function historial (Request $request){
        $historial = Partida::where('b_id','=',Auth::user()->id)->orWhere('n_id','=',Auth::user()->id)->orderBy('created_at', 'desc')->get();
        return view('historial',compact('historial'));
    }

    function getMovimentsPartida(Request $request){
        $id_partida = $request->request->get('id_partida');
        $historial_partida = MovimentsPartida::where('id_partida','=',$id_partida)->get();
        return $historial_partida;
    }

}
