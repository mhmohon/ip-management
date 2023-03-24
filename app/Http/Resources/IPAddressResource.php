<?php

namespace App\Http\Resources;

use App\Traits\IPAddressTrait;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
class IPAddressResource extends JsonResource
{
    use IPAddressTrait;

    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'label' => $this->label,
            'ip_address' => $this->ip_address,
            'created_at' => $this->created_at->format('d/m/Y'),
            'updated_at' => $this->updated_at->format('d/m/Y'),
        ];
    }
}
