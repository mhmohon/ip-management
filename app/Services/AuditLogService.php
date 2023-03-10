<?php

namespace App\Services;

use App\Http\Resources\AuditLogCollection;
use App\Models\AuditLog;
use App\Services\Contracts\AuditLogServiceInterface;

class AuditLogService implements AuditLogServiceInterface
{
    /**
     * @param int $userID
     * @return AuditLogCollection
     */
    public function fetch(int $userID): AuditLogCollection
    {
        $auditLogs = AuditLog::where("user_id", $userID)
                                ->latest()
                                ->get();
        return new AuditLogCollection($auditLogs);
    }
}
