<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;

class IPAddressCollection extends BaseCollection
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'data' => IPAddressResource::collection($this->collection),
            'link' => url('/ip-address'),
            'total' => $this->collection->count(),
        ];
    }
}
