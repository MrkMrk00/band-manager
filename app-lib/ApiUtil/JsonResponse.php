<?php

namespace BandManager\ApiUtil;

use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\Response;
use Illuminate\Contracts\Support\Arrayable;

class JsonResponse implements \ArrayAccess, Arrayable
{
    private array $jsonBody = [];
    private ?\Throwable $exception = null;

    public function __construct(
        public readonly ?Response $response,
    ) {
        if ($this->response) {
            $this->jsonBody = json_decode($this->response->getBody(), true);
        }
    }

    public static function fromException(\Throwable $e): self
    {
        if ($e instanceof RequestException && $e->hasResponse()) {
            return new self($e->getResponse());
        }

        $instance = new self(null);
        $instance->exception = $e;
        $instance->jsonBody = [
            'error' => [
                'message' => $e->getMessage(),
            ],
        ];

        return $instance;
    }

    public function hasException(): bool
    {
        return $this->exception !== null;
    }

    public function getException(): ?\Throwable
    {
        return $this->exception;
    }

    public function offsetExists(mixed $offset): bool
    {
        return isset($this->jsonBody[$offset]);
    }

    public function offsetGet(mixed $offset): mixed
    {
        return $this->jsonBody[$offset];
    }

    public function offsetSet(mixed $offset, mixed $value): void
    {
        $this->jsonBody[$offset] = $value;
    }

    public function offsetUnset(mixed $offset): void
    {
        unset($this->jsonBody[$offset]);
    }

    public function toArray(): array
    {
        return $this->jsonBody;
    }
}
