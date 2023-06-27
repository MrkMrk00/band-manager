<?php

namespace BandManager\Exception\Http;

use BandManager\Exception\HttpException;

class NotFoundException extends HttpException
{
    public function __construct()
    {
        parent::__construct(404);
    }
}
