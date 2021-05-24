<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GameController extends Controller
{
    function game(Request $request){
        return view('game');
    }
}
