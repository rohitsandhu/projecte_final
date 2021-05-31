const express = require('express');
const app = express();
const http = require('http');
const server = http.createServer(app);
const ok = true;

const { Server } = require("socket.io");
// const io = new Server(server);

const io = new Server(server, {
    cors: {
        // origin: "http://localhost",
        origin: "http://100.26.154.198",
        methods: ["GET", "POST"],
    }
});

var partides = [];

// for (var i = 0; i<10; i++){
//     partides.push({
//         'game_token': i,
//         'game_name': 'aoksdfjdslñakjdflkasd',
//         'game_pass': 'aoksdfjdslñakjdflkasd',
//         'player1_id' : 'aoksdfjdslñakjdflkasd',
//         'player1_name' : 'aoksdfjdslñakjdflkasd',
//         'socket_id_player1': 'aoksdfjdslñakjdflkasd',
//         'player2_id' : 'aoksdfjdslñakjdflkasd',
//         'player2_name' : 'aoksdfjdslñakjdflkasd',
//         'socket_id_player2': 'aoksdfjdslñakjdflkasd',
//         'estat': 'waiting players',
//     })
// }


io.on('connection', (socket) => {
    console.log('a user connected '+socket.id);

    socket.on('game', (moviment) => {

        console.log('misatge arribat')
        console.log("el moviment a fer i el token de la sala son els seguent ->>>>")
        console.log(moviment)

        for (var p in partides){
            if (partides[p]['game_token'] === moviment['game_token']){
                partides[p]['moviments_partida'].push(moviment['fen']);
            }
        }


        socket.broadcast.emit('game', moviment);
    })

    socket.on('disconnect', () => {

        console.log('user disconnected '+socket.id);

        console.log("mirant si el jugador desconnectat estava en alguna partida:")
        console.log("resultats de la cerca ->>>")
        var newArray = partides.filter(function (el) {
            return  el['socket_id_player1']  === socket.id ||
                el['socket_id_player2']  === socket.id;
        });

        console.log(newArray);

        if (newArray.length > 0){
            console.log("el usuari desconnectat estava en partida")

            console.log(" esperant 30 segons per veure si es torna a connectar ")
            var timeleft = 3;
            var downloadTimer = setInterval(function(){
                if(timeleft <= 0){
                    clearInterval(downloadTimer);
                }
                // document.getElementById("progressBar").value = 10 - timeleft;
                console.log(3-timeleft)
                timeleft -= 1;

                if (3-timeleft === 3 ){

                    console.log("#####################################################################")
                    console.log(" arr partides abans de borrar ->>>>")
                    console.log("#####################################################################")
                    console.log(partides)


                    if (newArray['socket_id_player1'] == socket.id){

                        var partidaa = {
                            'game_token': newArray[0]['game_token'],
                            'game_name': newArray[0]['game_name'],
                            'game_pass': newArray[0]['game_pass'],
                            'player1_id': newArray[0]['player1_id'],
                            'player1_name': newArray[0]['player1_name'],
                            'socket_id_player1': newArray[0]['socket_id_player1'],
                            'player2_id' :  newArray[0]['player2_id'],
                            'player2_name' :  newArray[0]['player2_name'],
                            'socket_id_player2':  newArray[0]['socket_id_player2'],
                            'estat': newArray[0]['estat'],
                            'moviments_partida': newArray[0]['moviments_partida'],
                            'res': 'White',
                        }
                        socket.broadcast.emit("contrincant_abandonat",partidaa);
                    }else{
                        var partidaa = {
                            'game_token': newArray[0]['game_token'],
                            'game_name': newArray[0]['game_name'],
                            'game_pass': newArray[0]['game_pass'],
                            'player1_id': newArray[0]['player1_id'],
                            'player1_name': newArray[0]['player1_name'],
                            'socket_id_player1': newArray[0]['socket_id_player1'],
                            'player2_id' :  newArray[0]['player2_id'],
                            'player2_name' :  newArray[0]['player2_name'],
                            'socket_id_player2':  newArray[0]['socket_id_player2'],
                            'estat': newArray[0]['estat'],
                            'moviments_partida': newArray[0]['moviments_partida'],
                            'res': 'Black',
                        }
                        socket.broadcast.emit("contrincant_abandonat",partidaa);
                    }



                    partides = borrarPartidaPerSocketId(partides, socket.id);

                    console.log("#####################################################################")
                    console.log(" arr partides despres de borrar partida on hi ha el jugador desconnectat");
                    console.log("#####################################################################")
                    console.log(partides)

                }

            }, 1000);
        }else{
            console.log("el usuari desconnectat no estava en partida")
        }
    });

    // socket.on('secondplayerfound', function (partida) {
    //
    //     console.log('sending second player credentials to first player ')
    //     console.log(partida)
    //     socket.broadcast.emit('secondplayerfound',partida)
    // })
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
            console.log(token)

            partides.push({
                'game_token': token,
                'game_name': partida_creador['game_name'],
                'game_pass': partida_creador['game_pass'],
                'player1_id' : partida_creador['user_id'],
                'player1_name' : partida_creador['user_name'],
                'socket_id_player1': socket.id,
                'player2_id' : '',
                'player2_name' : '',
                'socket_id_player2': '',
                'estat': '',
                'moviments_partida': [],
            })

            socket.emit('goGame',  {
                'game_token': token,
                'game_name': partida_creador['game_name'],
                'game_pass': partida_creador['game_pass'],
                'player1_id' : partida_creador['user_id'],
                'player1_name' : partida_creador['user_name'],
                'socket_id_player1': socket.id,
                'player2_id' : '',
                'player2_name' : '',
                'socket_id_player2': '',
                'estat': 'waiting players',
                'moviments_partida': [],
            })

        }else{
            console.log("ja existeix partida amb el mateix nom go next ")

            socket.emit('game_exists',(partida_creador['user_id']));
        }
    });


    socket.on("partida_acabada_amb_guanyador", function(partida){
        console.log("@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@")
        console.log(partida)
        console.log("@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@")

        var newArray = partides.filter(function (el) {
            return  el['game_token']  === partida['partida_token'];
        });

        console.log("%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%")
        console.log(newArray)
        console.log("%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%")

        if (newArray.length > 0){

            partidaa = {
                'game_token': newArray[0]['game_token'],
                'game_name': newArray[0]['game_name'],
                'game_pass': newArray[0]['game_pass'],
                'player1_id': newArray[0]['player1_id'],
                'player1_name': newArray[0]['player1_name'],
                'socket_id_player1': newArray[0]['socket_id_player1'],
                'player2_id' :  newArray[0]['player2_id'],
                'player2_name' :  newArray[0]['player2_name'],
                'socket_id_player2':  newArray[0]['socket_id_player2'],
                'estat': newArray[0]['estat'],
                'moviments_partida': newArray[0]['moviments_partida'],
                'res': partida['perdedor'],
            }

            console.log('????????????????????????????????????????????????????????')
            console.log(partidaa)
            console.log('????????????????????????????????????????????????????????')
            socket.emit("acabar_partida_amb_guanyador",(partidaa));
        }


    })
    socket.on("partida_acabada_amb_empat", function(partida){

        var newArray = partides.filter(function (el) {
            return  el['game_token']  === partida['partida_token'];
        });

        if (newArray.length > 0){
            partidaa = {
                'game_token': newArray[0]['game_token'],
                'game_name': newArray[0]['game_name'],
                'game_pass': newArray[0]['game_pass'],
                'player1_id': newArray[0]['player1_id'],
                'player1_name': newArray[0]['player1_name'],
                'socket_id_player1': newArray[0]['socket_id_player1'],
                'player2_id' :  newArray[0]['player2_id'],
                'player2_name' :  newArray[0]['player2_name'],
                'socket_id_player2':  newArray[0]['socket_id_player2'],
                'estat': newArray[0]['estat'],
                'moviments_partida': newArray[0]['moviments_partida'],
                'res': "draw",
            }
            socket.emit("acabar_partida_amb_empat",(partidaa));
        }
    })

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
                        partides[p]['socket_id_player2'] = socket.id;
                    }
                }

                var arrReturn = {
                    'game_token': newArray[0]['game_token'],
                    'game_name': newArray[0]['game_name'],
                    'game_pass': newArray[0]['game_pass'],
                    'player1_id': newArray[0]['player1_id'],
                    'player1_name': newArray[0]['player1_name'],
                    'socket_id_player1': newArray[0]['socket_id_player1'],
                    'player2_id': credencials['user_id'],
                    'player2_name': credencials['user_name'],
                    'socket_id_player2': socket.id,
                    'estat': 'waiting players',
                    'moviments_partida':newArray[0]['moviments_partida']
                };

                console.log("array a return amb tu com a segon jugador ->>>>")
                console.log(arrReturn)
                socket.emit('goGame', arrReturn)
                socket.broadcast.emit('secondplayerfound', arrReturn)
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



function borrarPartidaPerSocketId(partides, socket_id) {

    return partides.filter(function(ele){
        return ele['socket_id_player1'] != socket_id  && ele['socket_id_player2'] != socket_id ;
    });
}
