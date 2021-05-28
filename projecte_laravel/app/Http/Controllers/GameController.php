<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GameController extends Controller
{
    function game(Request $request){
        return view('game');
    }

    function end_game(Request $request){
        $partida = $request->request->get('partida');


        if ($partida['perdedor'] == "White"){

        }else{

        }




    }
}
