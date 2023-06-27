<?php

namespace BandManager\ApiUtil;

use GuzzleHttp\Exception\GuzzleException;

trait JsonConnector
{
    protected function getJson(string $url, array $options = []): JsonResponse
    {
        return $this->__jsonRequest('GET', $url, $options);
    }

    protected function postJson(string $url, array|\stdClass|string $body = [], array $options = []): JsonResponse
    {
        if ($parsedBody = $this->__parseRequestBody($body)) {
            $options['body'] += $parsedBody;
        }

        return $this->__jsonRequest('POST', $url, $options);
    }

    protected function putJson(string $url, array|\stdClass|string $body = [], array $options = []): JsonResponse
    {
        if ($parsedBody = $this->__parseRequestBody($body)) {
            $options['body'] += $parsedBody;
        }

        return $this->__jsonRequest('PUT', $url, $options);
    }

    private function __jsonRequest(string $method, string $url, array $options): JsonResponse
    {
        if (!isset($options['headers']['Accept'])) {
            $options['headers']['Accept'] = 'application/json;charset=utf-8';
        }

        try {
            $response = $this->http->request($method, $url, $options);
        } catch (GuzzleException $e) {
            return JsonResponse::fromException($e);
        }

        return new JsonResponse($response);
    }

    private function __parseRequestBody(array|\stdClass|string $body): ?array
    {
        if (is_string($body)) {
            $body = json_encode($body);
        }

        if ($body instanceof \stdClass) {
            $body = (array) $body;
        }

        return empty($body) ? null : $body;
    }
}
