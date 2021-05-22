@extends('layouts.app')

@section('title')
    <title> Home page </title>
@endsection

@section('custom_css')

    <link rel="stylesheet" href="{{asset('css/custom_css.css')}}">
@endsection


@section('content')

    <div class="col-6 py-3">
        <chess-board  position="start" draggable-pieces></chess-board>
    </div>
    <div class="col-4 px-sm-2 px-0 bg-dark text-white">
        <label>Status:</label>
        <div id="status"></div>
        <label>FEN:</label>
        <div id="fen"></div>
        <label>PGN:</label>
        <div id="pgn"></div>

        <table class="table">
            <thead class="table-light">
                <tr>
                    <th scope="col">Round</th>
                    <th scope="col">White</th>
                    <th scope="col">Black</th>
                </tr>
            </thead>
            <tbody id="taula_res">

            </tbody>
        </table>
    </div>
@endsection


@section('custom_js')
    <script>
        // NOTE: this example uses the chess.js library:
        // https://github.com/jhlywa/chess.js

        const board = document.querySelector("chess-board");
        const game = new Chess();
        const statusElement = document.querySelector("#status");
        // const fenElement = document.querySelector("#fen");
        const pgnElement = document.querySelector("#pgn");

        board.addEventListener("drag-start", (e) => {
            const { source, piece, position, orientation } = e.detail;

            // do not pick up pieces if the game is over
            if (game.game_over()) {
                e.preventDefault();
                return;
            }

            // only pick up pieces for the side to move
            if (
                (game.turn() === "w" && piece.search(/^b/) !== -1) ||
                (game.turn() === "b" && piece.search(/^w/) !== -1)
            ) {
                e.preventDefault();
                return;
            }
        });

        board.addEventListener("drop", (e) => {
            const { source, target, setAction } = e.detail;

            // see if the move is legal
            const move = game.move({
                from: source,
                to: target,
                promotion: "q", // NOTE: always promote to a queen for example simplicity
            });

            // illegal move
            if (move === null) {
                console.log(e)
                setAction("snapback");
            }
            updateStatus();
        });

        // update the board position after the piece snap
        // for castling, en passant, pawn promotion
        board.addEventListener("snap-end", (e) => {
            board.setPosition(game.fen());
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
            pgnElement.innerHTML = game.pgn();
        }

        updateStatus();
    </script>


    <script>
        $(document).ready(function(){
            console.log('adding class')
            $('#square-b2').addClass('');
        })
    </script>
@endsection
