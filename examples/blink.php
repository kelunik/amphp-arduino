<?php

use Amp\Delayed;
use Carica\Firmata;
use Carica\Io\Event\Loop\Factory as LoopFactory;
use function Amp\asyncCall;
use function Kelunik\Arduino\adapt;

/** @var Firmata\Board $board */
$board = require __DIR__ . '/../bootstrap.php';

asyncCall(function () use ($board) {
    yield adapt($board->activate());

    echo "Firmata " . $board->version . " active\n";

    $pin = $board->pins[13];
    $pin->mode = Firmata\Pin::MODE_OUTPUT;

    while (true) {
        $pin->digital = !$pin->digital;

        echo 'LED: ' . ($pin->digital ? 'on' : 'off') . "\n";
        yield new Delayed(1000);
    }
});

LoopFactory::run();


