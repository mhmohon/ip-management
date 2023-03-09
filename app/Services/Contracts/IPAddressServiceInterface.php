<?php

namespace App\Services\Contracts;

use App\Http\Resources\IpAddressCollection;
use App\Http\Resources\IPAddressResource;
use App\Models\IPAddress;
use App\Models\User;
use Illuminate\Http\Resources\Json\ResourceCollection;

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
     * @return IPAddressResource
     */
    public function create(User $user, array $requestData): IPAddressResource;

    /**
     * @param array $reqestData
     * @param integer $userID
     * @return IPAddressResource
     */
    public function modifyFetch(User $user, array $requestData, IPAddress $ipAddress): IPAddressResource;
}
