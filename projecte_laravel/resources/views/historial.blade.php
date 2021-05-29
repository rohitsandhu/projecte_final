@extends('layouts.app')

@section('title')
    <title > Match history </title>
@endsection

@section('custom_css')

    <link rel="stylesheet" href="{{asset('css/custom_css.css')}}">
@endsection


@section('content')


    <h1>Match history</h1>
    <div class="container">


        <table class="table mt-5">
            <thead class="table-light">
            <tr>
                <th scope="col" class="text-center" style="font-size: 20px">White</th>
                <th scope="col" class="text-center" style="font-size: 20px">Black</th>
                <th scope="col" class="text-center" style="font-size: 20px">Result</th>
                <th scope="col" class="text-center" style="font-size: 20px">Date</th>
                <th scope="col" class="text-center" style="font-size: 20px">Analize</th>

            </tr>
            </thead>
            <tbody id="taula_historial" class="text-white">

            </tbody>
        </table>

    </div>


@endsection

@section('custom_js')


@endsection
