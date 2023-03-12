<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\LoginRequest;
use App\Services\Contracts\AuthServiceInterface;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends BaseController
{

    public function __construct(private AuthServiceInterface $authService)
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * @param LoginRequest $request
     * @return JsonResponse
     */
    public function login(LoginRequest $request): JsonResponse
    {
        $credentials = $request->only('email', 'password');
        try {
            $data = $this->authService->login($credentials);
            if (isset($data['token'])) {
                return $this->successResponse( 'User signed in successfully', $data);
            }
            return $this->errorResponse( "Unauthorised! Credentials do not match", Response::HTTP_UNAUTHORIZED);
        } catch (QueryException $e) {
            Log::error("Database query failed: {$e->getMessage()}");
            return $this->errorResponse("Failed to sign in", Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @return JsonResponse
     */
    public function logout(): JsonResponse
    {
        try {
            if(request()->user()->currentAccessToken() !== null){
                request()->user()->currentAccessToken()->delete();
                return $this->successResponse('User signed out successfully');
            }
            return $this->errorResponse("Failed to signed out", Response::HTTP_UNAUTHORIZED);
        } catch (QueryException $e) {
            Log::error("Database query failed: {$e->getMessage()}");
            return $this->errorResponse("Failed to sign in", Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
