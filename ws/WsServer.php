<?php

require('../vendor/autoload.php');

use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;
use Cardgame\Connection;

require('../src/Connection.php');

$server = IoServer::factory(
    new HttpServer(
        new WsServer(
            new Connection()
        )
    ),
    8080
);

$server->run();
