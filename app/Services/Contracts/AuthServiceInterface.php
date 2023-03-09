<?php

namespace App\Services\Contracts;

use Illuminate\Http\JsonResponse;

interface AuthServiceInterface
{
    /**
     * @param array $credentials
     * @return array | bool
     */
    public function login(array $credentials): array | bool;
}
