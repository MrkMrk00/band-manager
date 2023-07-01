<?php

namespace BandManager\Routing;

use BandManager\Exception\Http\NotFoundException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

class ViewController extends Controller
{
    protected Request $request;

    public function __invoke(Request $request)
    {
        $this->request = $request;
        $method = strtoupper($request->method());

        if (method_exists($this, $method)) {
            return $this->{$method}();
        }

        throw new NotFoundException();
    }

    protected function render(string $viewName, array $data = [], array $mergeData = []): Response
    {
        return new Response(\view($viewName, $data, $mergeData));
    }

    protected function json(string|array|\stdClass|\JsonSerializable $content, int $status = 200, array $headers = []): Response
    {
        return new Response(
            content: json_encode($content),
            status: $status,
            headers: array_merge(
                ['Content-Type' => 'application/json'],
                $headers,
            ),
        );
    }
}
