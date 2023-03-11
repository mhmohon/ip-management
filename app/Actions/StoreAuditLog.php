<?php

namespace App\Actions;

use App\Models\AuditLog;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;

class StoreAuditLog
{
    /**
     * @param array $data
     * @return void
     */
    public function handle(array $data): void
    {
        try {
            AuditLog::create([
                'event'             => $data['event_name'] ?? null,
                'description'       => $data['description'] ?? null,
                'auditable_id'      => $data['auditable_id'] ?? null,
                'auditable_type'    => $data['auditable_type'] ?? null,
                'properties'        => $data['properties'] ?? null,
                'user_id'           => auth()->user()->id ?? null,
                'user_type'         => !empty(auth()->user()) ? get_class(auth()->user()) : null,
            ]);
        } catch (QueryException $e) {
            // If there was an error fetching the IP addresses (e.g. a database error), log the error and return an error response.
            Log::error("Failed to create audit log: {$e->getMessage()}");
        }
    }
}