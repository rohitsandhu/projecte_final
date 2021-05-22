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
io.on('connection', (socket) => {
    console.log('a user connected');

    socket.on('prova', (msg) => {
        console.log('misatge arribat')
        io.emit('prova', msg); // This will emit the event to all connected sockets
    })

    socket.on('disconnect', () => {
        console.log('user disconnected');
    });



});

server.listen(3000, () => {
  console.log('listening on *:3000');
});
