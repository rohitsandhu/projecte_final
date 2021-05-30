
@extends('layouts.app')

@section('title')
    <title > Profile </title>
@endsection

@section('custom_css')

    <link rel="stylesheet" href="{{asset('css/custom_css.css')}}">
    <style>
        td{
            overflow: hidden;
        }
    </style>
@endsection


@section('content')



    <!-- Button trigger modal -->
    <button type="button" class="btn btn-primary amagar" id="button_editar_perfil" data-bs-toggle="modal" data-bs-target="#exampleModal">

    </button>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit profile</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <label for="email_m" class="col-sm-6 col-form-label">Email</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control-plaintext text-start" readonly id="email_m"  value="{{$user->email}}">
                        </div>
                    </div>
                    <div class="row">
                        <label for="name_m" class="col-sm-6 col-form-label">Name</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control text-start" id="name_m"  value="{{$user->name}}">
                        </div>
                    </div>
                    <div class="row">
                        <label for="created_at_m" class="col-sm-6 col-form-label">Account created at:</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control-plaintext text-start" readonly id="email_m" value="{{$user->created_at->format('d-m-Y H:i')}}" >
                        </div>
                    </div>
                </div>
                <div class="w-100 justify-center d-flex">
                    <p class="text-danger amagar" id="error">The name can't be empty.</p>
                </div>

                <div class="modal-footer">
                    <button type="button" id="close" class="btn btn-dark" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="editar()">Edit profile</button>
                </div>
            </div>
        </div>
    </div>

    <h1> {{ $user->name }}'s profile </h1>
    <div class="container-fluid">

        <div class="card text-center">
            <div class="card-body">
                <div class="row">
                    <label for="email" class="col-sm-6 col-form-label">Email</label>
                    <div class="col-sm-6">
                        <p class="form-control-plaintext text-start" id="email" > {{$user->email}} </p>
                    </div>
                </div>
                <div class="row">
                    <label for="name" class="col-sm-6 col-form-label">Name</label>
                    <div class="col-sm-6">
                        <p class="form-control-plaintext text-start" id="name" > {{$user->name}} </p>
                    </div>
                </div>
                <div class="row">
                    <label for="created_at" class="col-sm-6 col-form-label">Account created at:</label>
                    <div class="col-sm-6">
                        <p class="form-control-plaintext text-start" id="created_at" > {{$user->created_at->format('d-m-Y H:i')}} </p>
                    </div>
                </div>
            </div>
            <div class="card-footer bg-white text-muted d-flex justify-content-between">

                @if(Auth::user()->id === $user->id)
                    <a class="btn btn-primary" onclick="editarPerfil()">Edit</a>
                @endif
                    <a class="btn btn-dark" href="{{route('historial',$user->id)}}" >Check Match History</a>
            </div>
        </div>

    </div>

@endsection

@section('custom_js')

    <script>
        function editarPerfil(){
            $('#button_editar_perfil').trigger('click');
        }

        function editar(){
            $('#error').addClass("amagar")
            $.ajax({
                type:'post',
                url: '/editarPerfil',
                data: {
                    '_token': $('meta[name="csrf-token"]').attr('content'),
                    '_method': 'post',
                    'nom': $('#name_m').val(),
                },
                success:function(data) {
                    if (data === "ok"){
                        $('#close').trigger('click');
                        $('#name').text($('#name_m').val())
                    }else{
                        $('#error').removeClass("amagar");
                    }
                },error: function () {
                }
            });
        }
    </script>

@endsection




