<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
class AuditLogResource extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'                => $this->id,
            'event'             => $this->event,
            'description'       => $this->description,
            'auditable_id'      => $this->auditable_id,
            'auditable_type'    => $this->auditable_type,
            'properties'        => $this->properties,
            'user_id'           => $this->user_id,
            'user_type'         => $this->user_type,
            'created_at'        => $this->created_at->format('d/m/Y'),
            'updated_at'        => $this->updated_at->format('d/m/Y'),
        ];
    }
}
