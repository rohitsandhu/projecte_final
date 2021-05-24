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

    socket.on('game', (msg) => {
        console.log('misatge arribat')
        socket.broadcast.emit('game', msg); // This will emit the event to all connected sockets
    })

    socket.on('disconnect', () => {

        console.log('user disconnected '+socket.id);
    });

    socket.on('crearPartida', function (partida_creador) {

        // partides.push({
        //     'game_name': "name",
        //     'game_pass': "pass",
        //     'player1_id' : "id",
        //     'player1_name' : "name2",
        //     'player2_id' : '',
        //     'player2_name' : ''
        // })

        var newArray = partides.filter(function (el) {
            return  el['game_name']  === partida_creador['game_name'] &&
                    el['game_pass']  === partida_creador['game_pass'];
        });

        console.log(newArray)


        if (newArray.length <1){
            partides.push({
                'game_name': partida_creador['game_name'],
                'game_pass': partida_creador['game_pass'],
                'player1_id' : partida_creador['user_id'],
                'player1_name' : partida_creador['user_name'],
                'player2_id' : '',
                'player2_name' : '',
            })
        }else{
            console.log("ja existeix")
        }

        socket.emit('goGame',  {
            'game_name': partida_creador['game_name'],
            'game_pass': partida_creador['game_pass'],
            'player1_id' : partida_creador['user_id'],
            'player1_name' : partida_creador['user_name'],
            'player2_id' : '',
            'player2_name' : '',
        })

    });


    socket.on('joinGame', function (credencials) {

        // partides.push({
        //     'game_name': "name",
        //     'game_pass': "pass",
        //     'player1_id' : "id",
        //     'player1_name' : "name2",
        //     'player2_id' : '',
        //     'player2_name' : ''
        // })

        console.log(partides)
        var newArray = partides.filter(function (el) {
            return  el['game_name']  === credencials['game_name'] &&
                el['game_pass']  === credencials['game_pass'];
        });

        console.log(newArray)


        if (newArray.length <1){
            console.log("partida no trobada")
        }else{
            console.log("partida trobada")

            if (newArray[0]['player2_id'] !== ''){
                console.log(newArray)
                console.log("partida ocupada")
            }else{
                socket.emit('goGame',  {
                    'game_name': newArray[0]['game_name'],
                    'game_pass': newArray[0]['game_pass'],
                    'player1_id' : newArray[0]['user_id'],
                    'player1_name' : newArray[0]['user_name'],
                    'player2_id' : credencials['user_name'],
                    'player2_name' : credencials['user_id'],
                })
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
