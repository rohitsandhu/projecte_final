const express = require('express');
const app = express();
const http = require('http');
const server = http.createServer(app);

const { Server } = require("socket.io");
// const io = new Server(server);

const io = new Server(server, {
    cors: {
        origin: "http://localhost",
        methods: ["GET", "POST"],
    }
});

var partides = [];

io.on('connection', (socket) => {
    console.log('a user connected '+socket.id);

    socket.on('game', (moviment) => {
        console.log('misatge arribat')
        console.log("el moviment a fer i el token de la sala son els seguent ->>>>")
        console.log(moviment)
        socket.broadcast.emit('game', moviment);
    })

    socket.on('disconnect', () => {

        console.log('user disconnected '+socket.id);
    });

    socket.on('crearPartida', function (partida_creador) {

        var newArray = partides.filter(function (el) {
            return  el['game_name']  === partida_creador['game_name'] &&
                    el['game_pass']  === partida_creador['game_pass'];
        });

        console.log("partides trobades ->>")
        console.log(newArray)

        if (newArray.length <1){

            console.log("no hi han partides amb el mateix nom ara mateix")

            console.log("creant token per a la partida nova")
            console.log("token ->>>>")

            var rand = function() {
                return Math.random().toString(36).substr(2); // remove `0.`
            };

            var bigToken = function() {
                return rand() + rand(); // to make it longer
            };

            var token = bigToken(rand())

            console.log(token)

            partides.push({
                'game_token': token,
                'game_name': partida_creador['game_name'],
                'game_pass': partida_creador['game_pass'],
                'player1_id' : partida_creador['user_id'],
                'player1_name' : partida_creador['user_name'],
                'player2_id' : '',
                'player2_name' : '',
            })

            socket.emit('goGame',  {
                'game_token': token,
                'game_name': partida_creador['game_name'],
                'game_pass': partida_creador['game_pass'],
                'player1_id' : partida_creador['user_id'],
                'player1_name' : partida_creador['user_name'],
                'player2_id' : '',
                'player2_name' : '',
            })

        }else{
            console.log("ja existeix partida amb el mateix nom go next ")

            socket.emit('game_exists',(partida_creador['user_id']));
        }
    });


    socket.on('joinGame', function (credencials) {

        console.log(partides)
        var newArray = partides.filter(function (el) {
            return  el['game_name']  === credencials['game_name'] &&
                el['game_pass']  === credencials['game_pass'];
        });

        console.log("buscar partides amb el mateix nom i la contrasenya a l'hora de unir-se")

        console.log("partides trobades -->>>>")
        console.log(newArray)

        if (newArray.length <1){
            console.log("l'hora de unir-se partida amb les credencials no trobada")
            socket.emit('game_notfound',(credencials['user_id']));
        }else{
            console.log("partida trobada trobada amb les credencials indicades")


            console.log("mirar si aquesta partida no té segon jugador")
            if (newArray[0]['player2_id'] !== ''){

                console.log("la partida ja té dos jugadors actualment")
                socket.emit('game_full',(credencials['user_id']));
            }else {

                console.log("partida trobada i no té dos jugadors acutalment")

                console.log("afegin-te com a segon jugador")

                for (var p in partides){
                    if (partides[p]['game_token'] === newArray[0]['game_token']){
                        partides[p]['player2_id'] = credencials['user_id'];
                        partides[p]['player2_name'] = credencials['user_name'];
                    }
                }

                var arrReturn = {
                    'game_token': newArray[0]['game_token'],
                    'game_name': newArray[0]['game_name'],
                    'game_pass': newArray[0]['game_pass'],
                    'player1_id': newArray[0]['user_id'],
                    'player1_name': newArray[0]['user_name'],
                    'player2_id': credencials['user_id'],
                    'player2_name': credencials['user_name'],
                };

                console.log("array a return amb tu com a segon jugador ->>>>")
                console.log(arrReturn)
                socket.emit('goGame', arrReturn)
            }
        }
    });

});

server.listen(3000, () => {
  console.log('listening on *:3000');
});


/////////////////////// crear game token
// var rand = function() {
//     return Math.random().toString(36).substr(2); // remove `0.`
// };
//
// var token = function() {
//     return rand() + rand(); // to make it longer
// };
