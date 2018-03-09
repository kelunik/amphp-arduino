<?php

namespace Kelunik\Arduino;

final class ConnectionConfig {
    /** @var int */
    private $baud = 57600;

    /** @var string */
    private $device;

    /** @var string|null */
    private $remoteHost;

    /** @var int|null */
    private $remotePort;

    public function __construct(string $device) {
        $this->device = $device;
    }

    public function withBaud(int $baud): self {
        $clone = clone $this;
        $clone->baud = $baud;

        return $clone;
    }

    public function getBaud(): int {
        return $this->baud;
    }

    public function withDevice(string $device): self {
        $clone = clone $this;
        $clone->device = $device;

        return $clone;
    }

    public function getDevice(): string {
        return $this->device;
    }

    public function withRemote(string $host, int $port): self {
        $clone = clone $this;
        $clone->remoteHost = $host;
        $clone->remotePort = $port;

        return $clone;
    }

    public function getRemoteHost(): ?string {
        return $this->remoteHost;
    }

    public function getRemotePort(): ?int {
        return $this->remotePort;
    }
}