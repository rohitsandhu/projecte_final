<?php

use App\Http\Controllers\GameController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\CheckLogged;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [UserController::class, "home"])->name("home")->middleware(CheckLogged::class);

Route::get('game', [GameController::class, "game"])->name("game")->middleware(CheckLogged::class);

Route::post('end_game',[GameController::class,"end_game"])->name('end_game')->middleware(CheckLogged::class);

Route::get('historial',[UserController::class,'historial'])->name('historial')->middleware(CheckLogged::class);

Route::post('getMovimentsPartida',[UserController::class,'getMovimentsPartida'])->name('getMovimentsPartida')->middleware(CheckLogged::class);

//Route::get('/dashboard', function () {
//    return view('dashboard');
//})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';

