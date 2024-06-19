let ws = new WebSocket('ws://192.168.100.49:2346');
ws.onopen = function() {
    console.log('Соединение по вебсокетам');
};

ws.onmessage = function(event) {
    let delta = JSON.parse(event.data);
    quill.updateContents(delta);
};

quill.on('text-change', function(delta, oldDelta, source) {
    if (source === 'user') ws.send(JSON.stringify(delta));
});