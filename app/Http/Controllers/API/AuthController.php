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
        $credentials = $request->safe()->only('email', 'password');
        try {
            $data = $this->authService->login($credentials);
            if (isset($data['token'])) {
                return $this->successResponse(Response::HTTP_OK, 'User signed in successfully', $data);
            }
            return $this->errorResponse(Response::HTTP_UNAUTHORIZED, "Unauthorised! Credentials doesn't match");
        } catch (Exception $e) {
            return $this->errorResponse(Response::HTTP_INTERNAL_SERVER_ERROR, $e->getMessage());
        }
    }

    /**
     * @return void
     */
    public function logout(): JsonResponse
    {
        request()->user()->currentAccessToken()->delete();
        return $this->successResponse(Response::HTTP_OK, 'User signed out successfully');
    }
}
