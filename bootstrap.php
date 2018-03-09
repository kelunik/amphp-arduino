<?php

require __DIR__ . '/vendor/autoload.php';

use Amp\ReactAdapter\ReactAdapter;
use Carica\Firmata;
use Carica\Io;
use Kelunik\Arduino\ConnectionConfig;

if (!file_exists(__DIR__ . '/config.php')) {
    die('You must provide a file named "config.php" that returns a ConnectionConfig object.');
}

/** @var ConnectionConfig $config */
$config = require __DIR__ . '/config.php';

$reactLoop = new Carica\Io\Event\Loop\React;
$reactLoop->loop(ReactAdapter::get());
Io\Event\Loop\Factory::set($reactLoop);

if ($config->getRemotePort()) {
    return new Firmata\Board(
        new Io\Stream\Tcp($config->getRemoteHost(), $config->getRemotePort())
    );
}

return new Firmata\Board(
    Io\Stream\Serial\Factory::create($config->getDevice(), $config->getBaud())
);