<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;

trait BaseTraits
{
    /**
     * JSON template for response API.
     */
    public function response($status = 200, $message = 'Success.', $data = [], array $headers = []): JsonResponse
    {
        return response()->json([
            'status' => $status < 400,
            'statusCode' => $status,
            'message' => $message,
            'data' => $data
        ], $status, $headers);
    }

    /**
     * Get role name in bahasa.
     */
    public function getPeran(int $level)
    {
        return config('api.peran')[$level];
    }

    /**
     * Get role name for token abilities.
     */
    public function getRole(int $level)
    {
        return config('api.roles')[$level];
    }

}
