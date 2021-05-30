<?php

namespace App\Http\Controllers;

use App\Models\MovimentsPartida;
use App\Models\Partida;
use App\Models\User;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    function home (Request $request){
        return view('home');
    }

    function historial (Request $request, $id){
        $historial = Partida::where('b_id','=',$id)->orWhere('n_id','=',Auth::user()->id)->orderBy('created_at', 'desc')->get();
        return view('historial',compact('historial'));
    }

    function getMovimentsPartida(Request $request){
        $id_partida = $request->request->get('id_partida');
        $historial_partida = MovimentsPartida::where('id_partida','=',$id_partida)->get();
        return $historial_partida;
    }

    function profile(Request $request, $id){

        $user = User::where('id','=',$id)->first();

        return view('profile', compact('user'));

    }

    function editarPerfil(Request $request){
        $nom = $request->request->get('nom');
        if ($nom != ""){

            Auth::user()->name= $nom;
            Auth::user()->save();

            return "ok";
        }else{
            return "nop";
        }
    }

}
