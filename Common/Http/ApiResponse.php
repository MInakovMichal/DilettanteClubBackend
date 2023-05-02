<?php

namespace Common\Http;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Facade;

class ApiResponse extends Facade
{
    /**
     * @param array<mixed>|mixed $data
     * @param string|null $message
     * @param int $code
     * @return JsonResponse
     */
    public static function successResponse(
        $data,
        string $message = null,
        int $code = 200
    ): JsonResponse {
        return new JsonResponse([
            'status' => 'Success',
            'message' => $message,
            'data' => $data,
        ], $code);
    }

    public static function errorResponse(int $code, string $message = null): JsonResponse
    {
        return new JsonResponse([
            'status' => 'Error',
            'message' => $message,
            'data' => null,
        ], $code);
    }
}
