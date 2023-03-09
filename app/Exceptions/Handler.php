<?php

namespace App\Exceptions;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\JsonResponse;
use InvalidArgumentException;
use Symfony\Component\ErrorHandler\Error\FatalError;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<\Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<\Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function render($request, Throwable $exception)
    {
        if($exception instanceof FatalError || $exception instanceof QueryException || $exception instanceof InvalidArgumentException){
            $message = "Sorry! We are unable to process your request at this moment. Try again later";
            return $this->errorResponse(Response::HTTP_INTERNAL_SERVER_ERROR, $message);
        }
        if($exception instanceof MethodNotAllowedHttpException){
            $message = "The URL you are trying to access is not correct. Please contact the website administrator for assistance";
            return $this->errorResponse(Response::HTTP_METHOD_NOT_ALLOWED, $message);
        }
        if($exception instanceof NotFoundHttpException){
            return $this->errorResponse(Response::HTTP_NOT_FOUND, $exception->getMessage());
        }
        if($exception instanceof AuthenticationException){
            return $this->errorResponse(Response::HTTP_UNAUTHORIZED, $exception->getMessage());
        }
        return parent::render($request, $exception);
    }

    /**
     * @param integer $statusCode
     * @param string|null $message
     * @param array|null $errors
     * @return JsonResponse
     */
    protected function errorResponse(int $statusCode, ?string $message, ?array $errors = []): JsonResponse
    {
        return response()->json([
            'success' => false,
            'status' => $statusCode,
            'message' => $message,
            'errors' => $errors,
            'timestamp' => now()
        ], $statusCode);
    }
}
