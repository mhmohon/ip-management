<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\LoginRequest;
use App\Services\Contracts\AuthServiceInterface;
use Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends BaseController
{
    private AuthServiceInterface $authService;

    public function __construct(AuthServiceInterface $authService)
    {
        $this->authService = $authService;
        $this->middleware('guest')->except('logout');
    }

    public function login(LoginRequest $request): JsonResponse
    {
        $credentials = $request->only('email', 'password');
        try {
            $data = $this->authService->login($credentials);
            if (isset($data['token'])) {
                return $this->successResponse( 'User signed in successfully', $data);
            }
            return $this->errorResponse( "Unauthorised! Credentials do not match", Response::HTTP_UNAUTHORIZED);
        } catch (Exception $e) {
            return $this->errorResponse( $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @return void
     */
    public function logout(): JsonResponse
    {
        request()->user()->currentAccessToken()->delete();
        return $this->successResponse( 'User signed out successfully');
    }
}
