<?php

namespace App\Services\Contracts;

use App\Http\Resources\AuditLogCollection;

interface AuditLogServiceInterface
{
    /**
     * @param int $userID
     * @return AuditLogCollection
     */
    public function fetch(int $userID): AuditLogCollection;
}
