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


function str_truncate(string $string, int $lengthWithoutSuffix = 10, string $suffix = '…'): string
{
    $string = trim($string);

    if (mb_strlen($string) < $lengthWithoutSuffix) {
        return $string;
    }

    return mb_substr($string, 0, $lengthWithoutSuffix - 1) . $suffix;
}
