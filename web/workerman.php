<?php

use Workerman\Worker;
use Workerman\Lib\Timer;
use Workerman\Autoloader;

require_once __DIR__ . '/../vendor/autoload.php';

// Создаем вебсокет-сервер
$ws_worker = new Worker("websocket://0.0.0.0:2346");

// Количество процессов
$ws_worker->count = 1;

// При подключении нового клиента
$ws_worker->onConnect = function ($connection) {
    echo "New connection\n";
};

// При получении сообщения от клиента
$ws_worker->onMessage = function ($connection, $data) use ($ws_worker) {
    // Рассылаем сообщение всем клиентам
    foreach ($ws_worker->connections as $client) {
        $client->send($data);
    }
};

// При отключении клиента
$ws_worker->onClose = function ($connection) {
    echo "Connection closed\n";
};

// Запуск сервера
Worker::runAll();