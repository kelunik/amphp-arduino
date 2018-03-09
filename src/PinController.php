<?php

namespace Kelunik\Arduino;

use Aerys\Request;
use Aerys\Response;
use Aerys\Websocket\Application;
use Aerys\Websocket\Endpoint;
use Aerys\Websocket\Message;
use Carica\Firmata\Pin;

final class PinController implements Application {
    /** @var Endpoint */
    private $endpoint;

    /** @var Pin */
    private $pin;

    public function __construct(Pin $pin) {
        $this->pin = $pin;
    }

    public function onStart(Endpoint $endpoint) {
        $this->endpoint = $endpoint;
    }

    public function onHandshake(Request $request, Response $response) {
        if ($request->getHeader('origin') !== 'http://localhost:4321') {
            $response->setStatus(400);
        }

        return $response;
    }

    public function onOpen(int $clientId, Request $request) {
        // do nothing
    }

    public function onData(int $clientId, Message $message) {
        /** @var string $payload */
        $payload = yield $message->buffer();

        $data = json_decode($payload, true);

        if ($data['state'] === 'on') {
            $this->pin->digital = true;
        } else {
            $this->pin->digital = false;
        }
    }

    public function onClose(int $clientId, int $code, string $reason) {
        // do nothing
    }

    public function onStop() {
        // do nothing
    }
}