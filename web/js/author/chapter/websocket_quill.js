let ws = new WebSocket('ws://192.168.100.49:2346'),
    client_id = null,
    deltas = [];

ws.onopen = function() {
    // Отправляем все отложенные дельты
    while (deltas.length > 0) {
        let delta = deltas.shift();
        sendDelta(delta);
    }
};

ws.onmessage = function(event) {
    let message = JSON.parse(event.data);
    console.log(message)

    // Получаем идентификатор клиента, если его еще нет
    if (!client_id && message.client_id) {
        client_id = message.client_id;
        return;
    }

    console.log(message.client_id, client_id);
    // Применяем изменения только если они пришли от другого клиента
    if (message.client_id !== client_id) {
        let delta = message.delta;
        quill.updateContents(delta);
    }
};

quill.on('text-change', function(delta, oldDelta, source) {
    if (source === 'user') {
        let message = {
            delta: delta,
            client_id: client_id
        };

        if (ws.readyState === WebSocket.OPEN) sendDelta(message);
        else deltas.push(message);
    }
});



function sendDelta(message) {
    ws.send(JSON.stringify(message));
}