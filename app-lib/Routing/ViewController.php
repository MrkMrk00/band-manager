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

        if (property_exists($this, $method)) {
            return $this->{$method};
        }

        throw new NotFoundException();
    }

    protected function render(string $viewName, array $data = [], array $mergeData = []): Response
    {
        return new Response(\view($viewName, $data, $mergeData));
    }
}
