<?php

namespace App\Observers;

use App\Models\IPAddress;
use App\Actions\StoreAuditLog;
use App\Traits\IPAddressTrait;

class IPAddressObserver
{
    use IPAddressTrait;

    public function __construct(private StoreAuditLog $storeAuditLog)
    {
        
    }
    /**
     * Handle the IPAddress "created" event
     *
     * @param IPAddress $ipAddress
     * @return void
     */
    public function created(IPAddress $ipAddress): void
    {
        $properties = [
            'old' => [],
            'attributes' => [
                'label'         => $ipAddress->label,
                'ip_address'    => $this->convertToReadable($ipAddress->ip_address),
            ]
        ];
        $data = $this->initialValues($ipAddress, 'stored');
        $data['properties'] = json_encode($properties);

        $this->storeAuditLog->handle($data);
    }

    /**
     * Handle the IPAddress "updated" event
     * 
     * @param IPAddress $ipAddress
     * @return void
     */
    public function updated(IPAddress $ipAddress): void
    {
        $properties = [
            'old' => [
                'label'    => $ipAddress->getOriginal()['label'],
            ],
            'attributes' => [
                'label'    => $ipAddress->getAttributes()['label'],
            ]
        ];
        $data = $this->initialValues($ipAddress, 'updated');
        $data['properties'] = json_encode($properties);

        $this->storeAuditLog->handle($data);
    }

    /**
     * @param IPAddress $ipAddress
     * @param [type] $type
     * @return array
     */
    public function initialValues(IPAddress $ipAddress, $type): array
    {
        $data = [
            'event_name' => ucfirst($type),
            'description' => 'IP addresses '.$type.' successfully',
            'auditable_id' => $ipAddress->id,
            'auditable_type' => get_class($ipAddress),
        ];
        return $data;
    }
}
