var server = require('http').Server();

var io = require('socket.io')(server);

var Redis = require('ioredis');
var redis = new Redis();

redis.subscribe('game-channel');

redis.on('message', function(channel, message) {
    message = JSON.parse(message);
    console.log(channel + ':' + message.event, message.data);

    io.emit(channel + ':' + message.event, message.data);
});

io.on('connection', function(socket){
    socket.on('chat message', function(msg){
        io.emit('chat message', msg);
    });
});

server.listen(3000);
