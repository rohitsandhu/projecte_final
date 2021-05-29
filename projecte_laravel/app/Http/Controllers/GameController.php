<?php

namespace App\Http\Controllers;

use App\Models\Partida;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class GameController extends Controller
{
    function game(Request $request){
        return view('game');
    }

    function end_game(Request $request){
        $partida = $request->request->get('partida');
        $game = new Partida();
        $game->moviments_partida = "";
        $game->b_id = $partida['player1_id'];
        $game->n_id = $partida['player2_id'];
        $game->b_nom = $partida['player1_name'];
        $game->n_nom = $partida['player2_name'];
        $game->token= $partida['game_token'];

        if ($partida['res'] == "White"){
            $game->resultat = "Black";
            $game->save();

        }else if($partida['res'] == "Black"){
            $game->resultat = "White";
            $game->save();
        }else{
            $game->resultat = "Draw";
            $game->save();
        }

        $partides =  Partida::where("token","=",$game->token)->get();

        if (count($partides) > 1){
            $p = Partida::where("token","=",$game->token)->first();
            $p->delete();
        }
    }
}
