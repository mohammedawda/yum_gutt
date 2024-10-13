<?php

/**
 * return response of all project api's
 * @param  boolean $status
 * @param  string $message
 * @param  array $data
 * @param  int $code
 * @return json
 */
if (!function_exists('sendResponse')) {
    function sendResponse($status, $message, $data, $debug = "", $code = 200){
        return response()->json([
            "status"  => $status,
            "message" => $message,
            "data"    => $data,
            "debug"   => $debug,
        ], (int)$code);
    }
}

/**
 * return response of all project api's
 * @param  boolean $status
 * @param  string $message
 * @param  int $code
 * @return json
 */
if (!function_exists('sendMessage')) {
    function sendMessage($status, $message, $debug = "", $code = 200): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            "status"  => $status,
            "message" => $message,
            "debug"   => $debug,
        ], (int)$code);
    }
}

/**
 * return response of all project api's
 * @param  boolean $status
 * @param  string $message
 * @param  int $count
 * @param  int $total
 * @param  array $data
 * @param  int $code
 * @return json
 */
if (!function_exists('sendListResponse')) {
    function sendListResponse($status, $message, $count, $total, $data, $code = 200) {
        return response()->json([
            "status"  => $status,
            "message" => $message,
            "total"   => $total,
            "count"   => $count,
            "data"    => $data,
        ], $code);
    }
}
