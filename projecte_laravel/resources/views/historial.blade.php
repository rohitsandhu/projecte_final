@extends('layouts.app')

@section('title')
    <title > Match history </title>
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



    <button type="button" class="btn btn-primary amagar" id="button_modal" data-bs-toggle="modal" data-bs-target="#exampleModal">
    </button>
    <audio id="audio" class="amagar" src="{{asset('audio/drop1.mp3')}}"></audio>
{{--    <audio id="audio" class="amagar" src="https://srv10.conversion-tool.com/dl/2/463ab6d47f9b04150175230dc32202bd/media-64cab183.mp3"></audio>--}}
    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" data-bs-backdrop="static" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog ">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Analize Match</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" onclick="refresh()" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h4 class="mb-0" id="player_black"></h4>
                    <chess-board id="board"  position="start"></chess-board>
                    <h4 style="margin-top: -12%" id="player_white"></h4>
                    <div class="w-100 d-flex justify-content-around">
                        <button class="btn btn-light" onclick="prevItem()" title="Previous Move"> <i class="bi bi-arrow-left h3 w-100 h-auto"></i></button>
                        <button class="btn btn-light" onclick="nextItem()" title="Next Move"> <i class="bi bi-arrow-right h3 w-100"></i></button>
                    </div>
                    <input type="hidden" id="res" >
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-dark" onclick="refresh()" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <h1>Match history</h1>
    <div class="container-fluid">


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
                @if(count($historial) > 0 )
                    @foreach($historial as $p)
                        <tr class="text-black m-0 text-center">
                            <td class="m-0">{{$p->b_nom}}</td>
                            <td class="m-0">{{$p->n_nom}}</td>
                            <td class="m-0">{{$p->resultat}}</td>
                            <td class="m-0">{{$p->created_at->format('Y-m-d H:i') }}</td>
                            <td class="m-0"> <button class="btn btn-dark button_analize" data-player_white="{{$p->b_nom}}" data-partida="{{$p->id}}" data-player_black="{{$p->n_nom}}" data-resultat="{{$p->resultat}}" > Analize </button> </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <th class="text-mute text-center text-dark" colspan="5">
                                No matches found
                        </th>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>


@endsection

@section('custom_js')

    <script>
        var arrayNomesMoviments = []
        var analizing = false;
        var i = -1;

         $('.button_analize').on('click',function(){
            var buto = $(this);

            console.log(buto.attr('data-player_white'));
            console.log(buto.attr('data-player_black'));
            $('#button_modal').trigger('click');
            $('#player_black').text(buto.attr('data-player_black'));
            $('#player_white').text(buto.attr('data-player_white'));
            $('#player_black').css('color','black')
            $('#player_white').css('color','black')

            $('#res').val(buto.attr('data-resultat'));

            $.ajax({
                 type:'post',
                 url: '/getMovimentsPartida',
                 data: {
                     '_token': $('meta[name="csrf-token"]').attr('content'),
                     '_method': 'post',
                     'id_partida': buto.attr('data-partida'),
                 },
                 success:function(data) {
                     console.log(data)
                     arrayNomesMoviments = data;
                     analizing= true;
                     i = -1;
                 },error: function () {
                 }
            });
            console.log(arrayNomesMoviments)
         })

        function nextItem() {



             if (i < arrayNomesMoviments.length){
                i++;
                if (i < arrayNomesMoviments.length){
                    var audio = document.getElementById("audio");
                    audio.play();
                    console.log(arrayNomesMoviments[i]);
                    $('#board').attr('position', arrayNomesMoviments[i]['fen'])
                    console.log('iterador  '+i)

                    if (i == arrayNomesMoviments.length-1){
                        if  ($('#res').val() == 'White'){
                            $('#player_black').css('color','Red')
                            $('#player_white').css('color','Green')
                        }else if($('#res').val() == 'Black'){
                            $('#player_white').css('color','Red')
                            $('#player_black').css('color','Green')
                        }else{
                            $('#player_black').css('color','Orange')
                            $('#player_white').css('color','Orange')
                        }
                    }
                }else{
                    i--;
                }
             }
        }

        function prevItem() {
             if (i >= 0){
                 $('#player_black').css('color','black')
                 $('#player_white').css('color','black')
                i--;
                 var audio = document.getElementById("audio");
                 audio.play();
              if (i == -1){
                  $('#board').attr('position', 'start');
                  console.log('iterador  '+i);
                  var audio = document.getElementById("audio");
                  audio.play();
              }else {
                  $('#board').attr('position', arrayNomesMoviments[i]['fen']);
                  console.log(arrayNomesMoviments[i]);
                  console.log('iterador  ' + i);
                  var audio = document.getElementById("audio");
                  audio.play();
              }
             }
        }

        function refresh(){
            $('#board').attr('position','start');
        }

    </script>

@endsection
