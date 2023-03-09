<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller as Controller;
use Illuminate\Http\JsonResponse;

class BaseController extends Controller
{
    /**
     * @param integer $statusCode
     * @param string|null $message
     * @param array|null $payload
     * @return JsonResponse
     */
    protected function successResponse(int $statusCode, ?string $message, ?array $payload = []): JsonResponse
    {
        $response = [
            'success'   => true,
            'status'    => $statusCode,
            'message'   => $message,
            'timestamp' => now()
        ];
        if(!empty($payload)){
            $response['payload'] = $payload;
        }
        return response()->json($response, $statusCode);
    }

    /**
     * @param integer $statusCode
     * @param string|null $message
     * @param array|null $errors
     * @return JsonResponse
     */
    protected function errorResponse(int $statusCode, ?string $message, ?array $errors = []): JsonResponse
    {
        $response = [
            'success'   => false,
            'status'    => $statusCode,
            'message'   => $message,
            'timestamp' => now()
        ];
        if(!empty($errors)){
            $response['errors'] = $errors;
        }
        return response()->json($response, $statusCode);
    }
}