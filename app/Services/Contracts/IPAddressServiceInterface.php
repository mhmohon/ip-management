<?php

namespace App\Services\Contracts;

use App\Http\Resources\IpAddressCollection;
use App\Models\IPAddress;
use App\Models\User;

interface IPAddressServiceInterface
{
    /**
     * @param int $userID
     * @return IpAddressCollection
     */
    public function fetch(int $userID): IpAddressCollection;

    /**
     * @param array $reqestData
     * @param integer $userID
     * @return IPAddress
     */
    public function create(User $user, array $requestData): IPAddress;

    /**
     * @param array $reqestData
     * @param integer $userID
     * @return IPAddress
     */
    public function modifyFetch(User $user, array $requestData, IPAddress $ipAddress): IPAddress;
}
