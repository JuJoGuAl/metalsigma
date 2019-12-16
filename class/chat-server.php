<?php
use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;
use WebSocket\WebSocketMessage;

    require 'vendor/autoload.php';

    $server = IoServer::factory(
        new HttpServer(
            new WsServer(
                new WebSocketMessage()
            )
        ),
        8080
    );

    $server->run();