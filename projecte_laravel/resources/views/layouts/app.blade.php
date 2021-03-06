<!doctype html>
<html lang="en">
<head>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">


    {{--    font de tota la pagina--}}
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Passion+One&display=swap" rel="stylesheet">

    <link rel="icon" href="{{asset('img/logo.png')}}">

    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@500&family=Signika+Negative:wght@700&display=swap" rel="stylesheet">

    {{-- boostrap icons import   --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">

    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
{{--    <title></title>--}}
    @yield('title')

    @yield('custom_css')
    <style>
        ::-webkit-scrollbar-track
        {
            -webkit-box-shadow: inset 0 0 6px rgba(153, 50, 50, 0.3);
            background-color: #F5F5F5;
        }

        ::-webkit-scrollbar
        {
            width: 6px;
            background-color: #F5F5F5;
            height: 7px;
        }

        ::-webkit-scrollbar-thumb
        {
            background-color: #6c6c6c;
        }

        tbody {
            display: block;
            max-height: 80vh;
            overflow: auto;
        }
        thead, tbody tr {
            display: table;
            width: 100%;
            table-layout: fixed;
        }
        thead {
            width: calc( 100% - 1em )
        }
        table {
            width: 400px;
        }

    </style>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css"
        rel="stylesheet"
        integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x"
        crossorigin="anonymous"/>
</head>
<body>
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-auto bg-dark text-white sticky-top">
            <div class="d-flex flex-sm-column flex-row bg-dark text-white flex-nowrap bg-light align-items-center sticky-top">
                <a href="{{route('home')}}" class="d-block p-3 link-dark bg-dark text-white text-decoration-none" title="" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title="Icon-only">
{{--                    <i class="bi-bootstrap fs-1"></i>--}}
                    <img src="{{asset('img/logo.png')}}" style="height: 50px; width: auto" alt="">
                </a>
                <ul class="nav nav-pills nav-flush bg-dark text-white flex-sm-column flex-row flex-nowrap mb-auto mx-auto text-center align-items-center">

                    <li class="nav-item">
                        <a href="{{route('historial',Auth::user()->id)}}" class="nav-link py-3 bg-dark text-white px-2" title="Match history" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title="Home">
                            <i class="bi bi-layout-text-sidebar-reverse h2"></i>
                        </a>
                    </li>

                    <li>
                        <a href="{{route('profile',Auth::user()->id)}}" class="nav-link py-3 px-2 bg-dark text-white" title="Profile" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title="Profile">
                            <i class="bi-person-circle h2"></i>
                        </a>
                    </li>

                </ul>
                <div class="dropdown">
                    <a href="#"  class="d-flex align-items-center justify-content-center p-3 link-dark bg-dark text-white text-decoration-none dropdown-toggle" id="dropdownUser3" data-bs-toggle="dropdown" aria-expanded="false">
                           <span  title="{{Auth::user()->name}}" style="max-width: 60px; overflow: hidden"> {{Auth::user()->name}} </span>
                    </a>
                    <ul class="dropdown-menu text-small shadow bg-dark text-white" aria-labelledby="dropd   ownUser3">
                        <li>
                            <a class="dropdown-item bg-dark text-white" href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                                 document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-sm min-vh-100">
            @yield('content')

        </div>
    </div>
</div>




{{-- import llibreria de la taula  --}}
<script type="module" src="https://unpkg.com/chessboard-element/bundled/chessboard-element.bundled.js"></script>

<script>
    console.log()
</script>

{{--  import llibreria chess.js  --}}
<script
    src="https://cdnjs.cloudflare.com/ajax/libs/chess.js/0.10.3/chess.js"
    integrity="sha512-oprzqYFJfo4Bx/nNEcSI0xo7ggJrLc+qQ6hrS3zV/Jn0C4dsg4gu+FXW/Vm0jP9CrV7e5e6dcLUYkg3imjfjbw=="
    crossorigin="anonymous">
</script>

{{--  bootstarp 5 import --}}
<script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4"
    crossorigin="anonymous"
></script>

{{--  import jquery  --}}
<script
    src="https://code.jquery.com/jquery-3.6.0.js"
    integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk="
    crossorigin="anonymous"></script>

{{--  import jquery ui  --}}
<script
    src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"
    integrity="sha256-T0Vest3yCU7pafRw9r+settMBX6JkKN06dqBnpQ8d30="
    crossorigin="anonymous"></script>

@yield('custom_js')
</body>
</html>
