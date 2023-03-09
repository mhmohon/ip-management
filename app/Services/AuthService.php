<?php

namespace App\Services;

use App\Models\User;
use App\Services\Contracts\AuthServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Hash;

class AuthService implements AuthServiceInterface
{
    /**
     * @param array $credentials
     * @return array
     */
    public function login(array $credentials): array | bool
    {
        if(Auth::guard('web')->attempt($credentials)){
            $authUser = Auth::guard('web')->user(); 
            $res['token'] =  $authUser->createToken('ipAddressAuth')->plainTextToken; 
            $res['user'] =  $authUser;
            return $res;
        }
        return false;
    }

}
