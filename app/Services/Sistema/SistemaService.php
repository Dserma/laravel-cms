<?php

namespace App\Services\Sistema;

class SistemaService
{
    public static function jsonR(Int $code, String $status, String $message, String $url = null, Int $redirect = 1)
    {
        return response()->json(['response' => $status, 'message' => $message, 'url' => $url, 'redirect' => $redirect], $code);
    }

    public static function jsonP(Int $code, String $status, String $message, String $url, String $url2)
    {
        return response()->json(['response' => $status, 'message' => $message, 'url' => $url, 'url2' => $url2, 'redirect' => 9], $code);
    }
}
