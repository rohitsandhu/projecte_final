@extends('layouts.app')

@section('title')
    <title > Home page </title>
@endsection

@section('custom_css')

    <link rel="stylesheet" href="{{asset('css/custom_css.css')}}">
@endsection


@section('content')

<div class="row">


    <div class="col" id="div_home">
        <h1 class="m-2">HOME</h1>

        <input type="hidden" id="id_user_logged" value="{{ Auth::user()->id }}">
        <div class="container">

            <div class="card text-center my-5">
                <div class="card-header">
                    <h4 class="mt-2"> Create new game </h4>
                </div>
                <div class="card-body">
                    <div class="form-floating mb-3">
                        <input type="hidden" id="name_user" value="{{Auth::user()->name}}">
                        <input type="hidden" id="id_user" value="{{Auth::user()->id}}">

                        <div class="form-floating">
                            <input type="text" class="form-control" id="game_name" placeholder="Game name">
                            <label for="game_name">Game name</label>
                        </div>
                        <div class="form-floating mt-1">
                            <input type="text" class="form-control" id="game_password" placeholder="Game password">
                            <label for="game_password">Game password</label>
                        </div>

                        <button onclick="crearPartida()" class="btn btn-lg btn-dark my-2"> Create </button>
                        <p class="text-danger amagar mt-2" style="font-size: 20px" id="error_create_fill"> Fill all the fields!! </p>
                        <p class="text-danger amagar mt-2" style="font-size: 20px" id="error_create_exists"> Game with same name already exists!! </p>
                    </div>
                </div>
            </div>

            <div class="card text-center">
                <div class="card-header">
                    <h4 class="mt-2"> Join game </h4>
                </div>
                <div class="card-body">
                    <div class="form-floating mb-3">
                        <input type="hidden" id="name_user2" value="{{Auth::user()->name}}">
                        <input type="hidden" id="id_user2" value="{{Auth::user()->id}}">

                        <div class="form-floating">
                            <input type="text" class="form-control" id="game_name2" placeholder="Game name">
                            <label for="game_name2">Game name</label>
                        </div>
                        <div class="form-floating mt-1">
                            <input type="text" class="form-control" id="game_password2" placeholder="Game password">
                            <label for="game_password2">Game password</label>
                        </div>
                        <button onclick="entrarPartida()" class="btn btn-lg btn-dark m-2"> Join </button>
                        <p class="text-danger amagar mt-2" style="font-size: 20px" id="error_join_fill"> Fill all the fields!! </p>
                        <p class="text-danger amagar mt-2" style="font-size: 20px" id="error_join_credentials"> Game with these credencials not found!! </p>
                        <p class="text-danger amagar mt-2" style="font-size: 20px" id="error_join_full"> Game is full!! </p>

                    </div>
                </div>
            </div>
        </div>

    </div>
{{--    draggable-pieces--}}
    <div class="col-1 amagar" id="div_fake_1"></div>
    <div class="col-lg-6 col-md-10 col-sm-10 py-3 pt-0 amagar" id="div2">
{{--        <p style="font-size: 20px"> You vs. Hikaru Nakamura</p>--}}
<div class="container-fluid d-flex justify-center">
    <h3 class="m-0 text-center"> GAME NAME: dsjfksdjfkldsj </h3>
</div>
        <input type="hidden" id="b_id">
        <input type="hidden" id="n_id">
        <input type="hidden" id="partida_token">
        <h4 id="enemy_name" class="mb-0"> ??? </h4>

        <chess-board id="taula"  position="start">
        </chess-board>
        <h4 id="my_name" style="margin-top: -12%"> {{ Auth::user()->name }} </h4>
        <input type="hidden" id="token_sala">
    </div>
    <div class="col-1 amagar" id="div_fake_2"></div>
    <div class="col-lg-4 px-sm-2 px-0 bg-dark text-white amagar" id="div1">
        <hr class="text-white">
        <label style="font-size: 20px">Game status:</label>
        <div id="status" class="mt-1"></div>
        <hr class="text-white">

        <table class="table">
            <thead class="table-light">
            <tr>
                <th scope="col">Round</th>
                <th scope="col">White</th>
                <th scope="col">Black</th>
            </tr>
            </thead>
            <tbody id="taula_res" class="text-white">

            </tbody>
        </table>
    </div>

</div>
@endsection

@section('custom_js')

    <script src="http://{{request()->getHttpHost()}}:3000/socket.io/socket.io.js"></script>

    <script>
        var socket = io("//{{request()->getHttpHost()}}:3000");
    </script>

    <script src="{{asset('js/game_n_sockets.js')}}"></script>
@endsection
