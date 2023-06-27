<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

function csrf_verify($token): bool
{
    try {
        $request = app()->get(Request::class);
    } catch (\Throwable $e) {
        Log::error($e);
        return false;
    }

    return is_string($request->session()->token()) &&
        is_string($token) &&
        hash_equals($request->session()->token(), $token);
}
