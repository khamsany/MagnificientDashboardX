const express = require('express');
const app = express();
const bodyParser = require('body-parser');
const port = 4567;
server = app.listen(port, function () {
    console.log(`Server Initialize listening to port ${port}!`)
});
const io = require('socket.io')(server);

app.use(bodyParser.json());

app.get('/', function (req, res) {
    res.send('Hello World!')
});

app.post('/payload', function (req, res) {

    io.emit('payload-update', req.body);
});


// Set socket.io listeners.
io.on('connection', (socket) => {
    console.log('a user connected');
    socket.on('disconnect', () => {
        console.log('user disconnected');
    });
});