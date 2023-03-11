<?php

namespace App\Services;

use App\Actions\StoreAuditLog;
use App\Http\Resources\IPAddressCollection;
use App\Http\Resources\IPAddressResource;
use App\Models\IPAddress;
use App\Models\User;
use App\Services\Contracts\IPAddressServiceInterface;
use App\Traits\IPAddressTrait;

class IPAddressService implements IPAddressServiceInterface
{
    use IPAddressTrait;

    /**
     * @param int $userID
     * @return IPAddressCollection
     */
    public function fetch(int $userID): IPAddressCollection
    {
        $ipAddress = IPAddress::where("user_id", $userID)
                                ->latest()
                                ->get();
        return new IPAddressCollection($ipAddress);
    }

    /**
     * @param User $user
     * @param array $requestData
     * @return IPAddress
     */
    public function create(User $user, array $requestData): IPAddress
    {
        $ipAddress = $user->ipAddresses()->create([
            'label'         => $requestData['label'],
            'ip_address'    => $this->convertToBinary($requestData['ip_address']),
        ]);
        return $ipAddress;
    }

    /**
     * @param User $user
     * @param array $requestData
     * @param IPAddress $ipAddress
     * @return IPAddress
     */
    public function modifyFetch(User $user, array $requestData, IPAddress $ipAddress): IPAddress
    {
        $ipAddress->update([
            'label' => $requestData['label']
        ]);
        return $ipAddress;
    }
}
