<?php

namespace App\Http\Responses;

use Illuminate\Http\JsonResponse;

class ApiResponse extends JsonResponse
{
    public function __construct($data = null, $status = 200, $message = 'Sukses.', $headers = [], $options = 0)
    {
        $formattedResponse = [
            'status' => $status < 400,
            'statusCode' => $status,
            'message' => $message,
            'data' => $data
        ];

        parent::__construct($formattedResponse, $status, $headers, $options);
    }
}
