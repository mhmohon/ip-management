<?php

namespace App\Services\Contracts;

use App\Http\Resources\IPAddressCollection;
use App\Models\IPAddress;
use App\Models\User;

interface IPAddressServiceInterface
{
    /**
     * @param int $userID
     * @return IPAddressCollection
     */
    public function fetch(int $userID): IPAddressCollection;

    /**
     * @param User $user
     * @param array $requestData
     * @return IPAddress
     */
    public function create(User $user, array $requestData): IPAddress;

    /**
     * @param User $user
     * @param array $requestData
     * @param IPAddress $ipAddress
     * @return IPAddress
     */
    public function modifyFetch(User $user, array $requestData, IPAddress $ipAddress): IPAddress;
}
