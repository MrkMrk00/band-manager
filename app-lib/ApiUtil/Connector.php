<?php

namespace BandManager\ApiUtil;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

abstract class Connector
{
    protected readonly Client $http;

    public function __construct()
    {
        $this->http = new Client($this->getClientOptions());
    }

    /**
     * @return array Guzzle client options {@see \GuzzleHttp\Client::__construct()}
     */
    protected function getClientOptions(): array
    {
        return [];
    }
}
