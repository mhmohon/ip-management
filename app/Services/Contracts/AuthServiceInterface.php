<?php

namespace App\Services\Contracts;

interface AuthServiceInterface
{
    /**
     * @param array $credentials
     * @return array | bool
     */
    public function login(array $credentials): array | bool;
}
