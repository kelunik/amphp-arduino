<?php

namespace Kelunik\Arduino;

use Amp\Deferred;
use Amp\Promise;
use Carica\Io\Deferred\Promise as CaricaPromise;

function adapt(CaricaPromise $promise): Promise {
    $deferred = new Deferred;

    $promise->then(function ($value = null) use ($deferred) {
        $deferred->resolve($value);
    }, function ($exception = null) use ($deferred) {
        $exception = $exception instanceof \Throwable
            ? $exception
            : new \Exception("Non-throwable caught: {$exception}");

        $deferred->fail($exception);
    });

    return $deferred->promise();
}