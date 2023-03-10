<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;

class AuditLogCollection extends BaseCollection
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'data' => AuditLogResource::collection($this->collection),
            'link' => url('/api/auditlog'),
            'total' => $this->collection->count(),
        ];
    }
}
