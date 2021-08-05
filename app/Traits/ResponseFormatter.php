<?php

namespace App\Traits;

trait ResponseFormatter{

    protected function viewResponseFormatter($data, $result='success', $message = null, $code = 200): array
    {
        return [
            'result'=> $result,
            'message' => $message,
            'data' => $data,
            'status' => $code
        ];
    }

    protected function apiResponseFormatter($data, $result='success', $message = null, $code = 200): string
    {
        return json_encode([
            'result'=> $result,
            'message' => $message,
            'data' => $data
        ], $code);
    }
}
