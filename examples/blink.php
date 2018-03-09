<?php

use Aerys\Root;
use Aerys\Router;
use Aerys\Server;
use Aerys\Websocket\Websocket;
use Carica\Firmata;
use Carica\Io\Event\Loop\Factory as LoopFactory;
use Kelunik\Arduino\PinController;
use function Amp\asyncCall;
use function Kelunik\Arduino\adapt;

/** @var Firmata\Board $board */
$board = require __DIR__ . '/../bootstrap.php';

asyncCall(function () use ($board) {
    yield adapt($board->activate());

    echo "Firmata " . $board->version . " active\n";

    $pin = $board->pins[13];
    $pin->mode = Firmata\Pin::MODE_OUTPUT;

    $pinController = new PinController($pin);

    $router = new Router;
    $router->addRoute('GET', '/control', new Websocket($pinController));
    $router->setFallback(new Root(__DIR__ . '/../public'));

    $server = new Server($router);
    $server->expose('127.0.0.1', 4321);
    $server->expose('::1', 4321);
    yield $server->start();
});

LoopFactory::run();


