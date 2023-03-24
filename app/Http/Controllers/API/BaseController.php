<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller as Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class BaseController extends Controller
{

    /**
     * @param callable $callback
     * @return JsonResponse
     */
    protected function tryCatchBlock(callable $callback): JsonResponse
    {
        try {
            return call_user_func($callback);
        } catch (\Throwable $th) {
            Log::error("Database query failed: {$th->getMessage()}");
            return $this->errorResponse("Failed to fetch the record", Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @param string $message
     * @param mixed $payload
     * @param integer $statusCode
     * @return JsonResponse
     */
    protected function successResponse(string $message, mixed $payload = [], int $statusCode = Response::HTTP_OK): JsonResponse
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
     * @param string $message
     * @param integer $statusCode
     * @param array|null $errors
     * @return JsonResponse
     */
    protected function errorResponse(string $message, int $statusCode, ?array $errors = []): JsonResponse
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