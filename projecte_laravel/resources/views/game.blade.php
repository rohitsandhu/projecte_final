@extends('layouts.app')

@section('title')
    <title> Home page </title>
@endsection

@section('custom_css')

    <link rel="stylesheet" href="{{asset('css/custom_css.css')}}">
@endsection


@section('content')

    <div class="col-6 py-3">
        <chess-board  position="start" draggable-pieces style="margin-bottom: -200px"></chess-board>
    </div>
    <div class="col-4 px-sm-2 px-0 bg-dark text-white">
        <label>Game status:</label>
        <div id="status"></div>

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
@endsection


@section('custom_js')

    <script src="http://{{request()->getHttpHost()}}:3000/socket.io/socket.io.js"></script>
    <script>

        var socket = io("//{{request()->getHttpHost()}}:3000");

        socket.on('prova', function(msg) {
            console.log(msg)
            //consonle.log(board)
            //console.log(game)
            board.setPosition(msg['fen']);
            const move = game.move({
                from: msg['source'],
                to: msg['target'],
                promotion: 'q' // NOTE: en cas de ser un peo i arribal al final ho premou a reina sempre
            });
            updateStatus();

        });
    </script>
    <script>
        // crear la taula d'escacs
        const board = document.querySelector('chess-board');
        // crea la partida
        const game = new Chess();

        console.log(game)

        const statusElement = document.querySelector("#status");
        // const fenElement = document.querySelector("#fen");
        const pgnElement = document.querySelector("#pgn");
        const highlightStyles = document.createElement('style');
        document.head.append(highlightStyles);

        // els colors marcats al terra depenents de sobre quin color sigui el quadrat
        // // const whiteSquareGrey = '#a9a9a9';
        // // const blackSquareGrey = '#696969';
        const whiteSquareGrey = '#d6d2d2';
        const blackSquareGrey = '#aba4a4';


        //funcio borrar el quadrats marcats
        function removeGreySquares() {
            highlightStyles.textContent = '';
        }

        // funcio marcar el quadrat
        function greySquare(square) {
            // el color del quadrat
            const highlightColor = (square.charCodeAt(0) % 2) ^ (square.charCodeAt(1) % 2)
                ? whiteSquareGrey
                : blackSquareGrey;

            highlightStyles.textContent += `
                chess-board::part(${square}) {
                  background-color: ${highlightColor};
                }
            `;
        }

        // listener de guan començes a moure la peça
        board.addEventListener('drag-start', (e) => {
            const {source, piece , position, orientation } = e.detail;

            // en cas de que la partida hagi acabat no deixa arrastar la peça
            if (game.game_over()) {
                e.preventDefault();
                return;
            }

            // en cas de que no sigui el trorn del color que estas aarastant no diexa moure
            if ((game.turn() === 'w' && piece.search(/^b/) !== -1) ||
                (game.turn() === 'b' && piece.search(/^w/) !== -1)) {
                e.preventDefault();
                return;
            }
        });

        // listener de quan deixes la peça caure sobre una posicio
        board.addEventListener('drop', (e) => {
            const {source, target, setAction} = e.detail;


            // treure els moviments marcats
            removeGreySquares();

            // mira si el moviment es legal
            const move = game.move({
                from: source,
                to: target,
                promotion: 'q' // NOTE: en cas de ser un peo i arribal al final ho premou a reina sempre
            });

            console.log("updating...")


            updateStatus();
            // // illegal move
            // if (move === null) {
            //     setAction('snapback');
            // }

            // proves
            if (move === null) {
                setAction('snapback');
                console.log("bacck to normal")
            }else{

                console.log('this is the socket id'+socket.id)
                console.log('this is the socket id'+socket.id)
                console.log('this is the socket id'+socket.id)
                console.log('this is the socket id'+socket.id)
                socket.emit('prova', {
                    'source': source,
                    'target': target,
                    'promotion': 'q',
                    'fen': game.fen()
                });
                console.log("canvi de posicio")
            }
        });


        // listener al de fet hover sobre el quadradet
        board.addEventListener('mouseover-square', (e) => {
            const {square, piece} = e.detail;

            //console.log("quadrat -> "+square)
            //console.log("peça -> "+piece)

            // llistat de posibles mobiments per quadrat
            const moves = game.moves({
                square: square,
                verbose: true
            });

            // si no ha trobat posibles moviments per el quadrat surt de la funció
            if (moves.length === 0) {
                return;
            }

            // remarca el quadrat on es fa hover
            greySquare(square);

            // remarca els posibles moviments
            for (const move of moves) {
                greySquare(move.to);
            }
        });

        // treure els moviments marcats al treure el hover
        board.addEventListener('mouseout-square', (e) => {
            removeGreySquares();
        });

        board.addEventListener('snap-end', (e) => {
            board.setPosition(game.fen())
            console.log('moviment ---->>'+game.fen())
        });

        function updateStatus() {
            let status = "";

            let moveColor = "White";
            if (game.turn() === "b") {
                moveColor = "Black";
            }

            if (game.in_checkmate()) {
                // checkmate?
                status = `Game over, ${moveColor} is in checkmate.`;
                console.log("has guanyat crack")
            } else if (game.in_draw()) {
                // draw?
                status = "Game over, drawn position";
                console.log("heu empatat cracks")
            } else {
                // game still on
                status = `${moveColor} to move`;
                console.log("et toca moure"+status)

                // check?
                if (game.in_check()) {
                    status += `, ${moveColor} is in check`;
                    console.log("estas en jaque crack")
                }
            }

            statusElement.innerHTML = status;
            // fenElement.innerHTML = game.fen();
            //pgnElement.innerHTML = game.pgn();
            console.log(game.pgn())


            var split = game.pgn().split(' ');

            var iteration = 0;
            $('#taula_res').empty()
            for (var xd in split){
                if (iteration === 0){
                    var tr = document.createElement('tr');
                    // let td = document.createElement('td');
                    // td.innerText = split[xd];
                    // tr.append(td)
                }

                let td = document.createElement('td');
                td.innerText = split[xd];

                tr.append(td);
                console.log(split[xd])
                $('#taula_res').append(tr)
                iteration++;
                if (iteration > 2){
                    $('#taula_res').append(tr)
                    console.log('next round ')
                    iteration = 0;
                }
            }
            console.log(split)
        }


        updateStatus();

        // $(document).ready(function(){
            console.log($('#dragged-pieces'))

        // })
    </script>




@endsection
