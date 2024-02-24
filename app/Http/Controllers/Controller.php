<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function response($status = 200, $message = 'Success.', $data = [], array $headers = []): JsonResponse
    {
        return response()->json([
            'status' => $status < 400,
            'statusCode' => $status,
            'message' => $message,
            'data' => $data
        ], $status, $headers);
    }
}
