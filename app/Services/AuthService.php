<?php

namespace App\Services;

use App\Http\Resources\UserResource;
use App\Services\Contracts\AuthServiceInterface;
use Illuminate\Support\Facades\Auth;

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
            $res['user'] =  new UserResource($authUser);
            return $res;
        }
        return false;
    }
}
