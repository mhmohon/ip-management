<?php

namespace App\Exceptions;

use ErrorException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\JsonResponse;
use InvalidArgumentException;
use ParseError;
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
        if($exception instanceof MethodNotAllowedHttpException){
            $message = "The URL you are trying to access is not correct. Please contact the website administrator for assistance";
            return $this->sendResponse($message, Response::HTTP_METHOD_NOT_ALLOWED);
        }
        if($exception instanceof ModelNotFoundException){
            $message = "The data you entered did not match any records in our database";
            return $this->sendResponse($message, Response::HTTP_NOT_FOUND);
        }
        if($exception instanceof NotFoundHttpException){
            return $this->sendResponse($exception->getMessage(), Response::HTTP_NOT_FOUND);
        }
        if($exception instanceof AuthenticationException || $exception instanceof AuthorizationException){
            $message = "Access denied! You are not authorized to perform this action";
            return $this->sendResponse($message, Response::HTTP_UNAUTHORIZED);
        }
        if($exception instanceof FatalError 
            || $exception instanceof QueryException 
            || $exception instanceof InvalidArgumentException
            || $exception instanceof ErrorException
            || $exception instanceof ParseError
        ){
            $message = "Sorry! There was a problem processing your request. Please try again later";
            return $this->sendResponse($message, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        return parent::render($request, $exception);
    }

    /**
     * @param string $message
     * @param integer $statusCode
     * @param array|null $errors
     * @return JsonResponse
     */
    protected function sendResponse(string $message, int $statusCode, ?array $errors = []): JsonResponse
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
