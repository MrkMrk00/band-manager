<?php

namespace BandManager\Exception;

use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

class HttpException extends \RuntimeException implements HttpExceptionInterface
{
    public function __construct(
        private readonly int   $statusCode,
        private readonly array $headers = [],
        string                 $message = '',
        int                    $code = 0,
        ?\Throwable            $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    /**
     * @inheritDoc
     */
    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    /**
     * @inheritDoc
     */
    public function getHeaders(): array
    {
        return $this->headers;
    }
}
