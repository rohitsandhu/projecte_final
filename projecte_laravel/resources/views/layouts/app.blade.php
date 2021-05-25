<!doctype html>
<html lang="en">
<head>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="preconnect" href="https://fonts.gstatic.com">
{{--    <link href="https://fonts.googleapis.com/css2?family=Pattaya&display=swap" rel="stylesheet">--}}
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Passion+One&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <title></title>
    @yield('title')
    @yield('custom_css')

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css"
        rel="stylesheet"
        integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x"
        crossorigin="anonymous"/>
</head>
<body>
<div class="container-fluid">
    <div class="row flex-nowrap">
        <div class="col-2 col-md-2 col-xl-2 px-sm-2 px-0 bg-dark">
            <div
                class="
              d-flex
              flex-column
              align-items-center align-items-sm-start
              px-3
              pt-2
              text-white
              min-vh-100
            "
            >
                <a
                    href="/"
                    class="
                d-flex
                align-items-center
                pb-3
                mb-md-0
                me-md-auto
                text-white text-decoration-none
              "
                >
                    <span class="fs-5 d-none d-sm-inline">Menu</span>
                </a>
                <ul
                    class="
                nav nav-pills
                flex-column
                mb-sm-auto mb-0
                align-items-center align-items-sm-start
              "
                    id="menu"
                >
                    <li class="nav-item">
                        <a href="#" class="nav-link align-middle px-0">
                            <i class="fs-4 bi-house"></i>
                            <span class="ms-1 d-none d-sm-inline">Home</span>
                        </a>
                    </li>
                    <li>
                        <a
                            href="#submenu1"
                            data-bs-toggle="collapse"
                            class="nav-link px-0 align-middle"
                        >
                            <i class="fs-4 bi-speedometer2"></i>
                            <span class="ms-1 d-none d-sm-inline">Dashboard</span>
                        </a>
                        <ul
                            class="collapse show nav flex-column ms-1"
                            id="submenu1"
                            data-bs-parent="#menu"
                        >
                            <li class="w-100">
                                <a href="#" class="nav-link px-0">
                                    <span class="d-none d-sm-inline">Item</span> 1
                                </a>
                            </li>
                            <li>
                                <a href="#" class="nav-link px-0">
                                    <span class="d-none d-sm-inline">Item</span> 2
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="#" class="nav-link px-0 align-middle">
                            <i class="fs-4 bi-table"></i>
                            <span class="ms-1 d-none d-sm-inline">Orders</span></a
                        >
                    </li>
                    <li>
                        <a
                            href="#submenu2"
                            data-bs-toggle="collapse"
                            class="nav-link px-0 align-middle"
                        >
                            <i class="fs-4 bi-bootstrap"></i>
                            <span class="ms-1 d-none d-sm-inline">Bootstrap</span></a
                        >
                        <ul
                            class="collapse nav flex-column ms-1"
                            id="submenu2"
                            data-bs-parent="#menu"
                        >
                            <li class="w-100">
                                <a href="#" class="nav-link px-0">
                                    <span class="d-none d-sm-inline">Item</span> 1</a
                                >
                            </li>
                            <li>
                                <a href="#" class="nav-link px-0">
                                    <span class="d-none d-sm-inline">Item</span> 2</a
                                >
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a
                            href="#submenu3"
                            data-bs-toggle="collapse"
                            class="nav-link px-0 align-middle"
                        >
                            <i class="fs-4 bi-grid"></i>
                            <span class="ms-1 d-none d-sm-inline">Products</span>
                        </a>
                        <ul
                            class="collapse nav flex-column ms-1"
                            id="submenu3"
                            data-bs-parent="#menu"
                        >
                            <li class="w-100">
                                <a href="#" class="nav-link px-0">
                                    <span class="d-none d-sm-inline">Product</span> 1</a
                                >
                            </li>
                            <li>
                                <a href="#" class="nav-link px-0">
                                    <span class="d-none d-sm-inline">Product</span> 2</a
                                >
                            </li>
                            <li>
                                <a href="#" class="nav-link px-0">
                                    <span class="d-none d-sm-inline">Product</span> 3</a
                                >
                            </li>
                            <li>
                                <a href="#" class="nav-link px-0">
                                    <span class="d-none d-sm-inline">Product</span> 4</a
                                >
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="#" class="nav-link px-0 align-middle">
                            <i class="fs-4 bi-people"></i>
                            <span class="ms-1 d-none d-sm-inline">Customers</span>
                        </a>
                    </li>
                </ul>
                <hr />
                <div class="dropdown pb-4">
                    <a
                        href="#"
                        class="
                  d-flex
                  align-items-center
                  text-white text-decoration-none
                  dropdown-toggle
                "
                        id="dropdownUser1"
                        data-bs-toggle="dropdown"
                        aria-expanded="false"
                    >
                        <img
                            src="https://github.com/mdo.png"
                            alt="hugenerd"
                            width="30"
                            height="30"
                            class="rounded-circle"
                        />
                        <span class="d-none d-sm-inline mx-1">{{Auth::user()->name}}</span>
                    </a>

                    <ul class="dropdown-menu dropdown-menu-dark text-small shadow"
                        aria-labelledby="dropdownUser1">
                        <li><a class="dropdown-item" href="#">New project...</a></li>
                        <li><a class="dropdown-item" href="#">Settings</a></li>
                        <li><a class="dropdown-item" href="#">Profile</a></li>
                        <li>
                            <hr class="dropdown-divider" />
                        </li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <a class="dropdown-item" href="route('logout')"
                                                 onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                    {{ __('LogOut') }}
                                </a>
                            </form>


                        </li>
                    </ul>
                </div>
            </div>
        </div>

        @yield('content')

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
