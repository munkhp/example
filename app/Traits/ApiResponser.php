<?php

namespace App\Traits;

trait ApiResponser
{

    protected function success($data, $message, $code = 200)
    {
        return response()->json([
            'status' => 'Success',
            'message' => $message,
            'data' => $data
        ], $code);
    }

    protected function error($message, $error, $code)
    {
        return response()->json([
            'status' => 'Error',
            'message' => $message,
            'error' => $error,
        ], $code);
    }
}
