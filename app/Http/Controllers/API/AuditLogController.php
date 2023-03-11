<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController;
use App\Http\Resources\AuditLogCollection;
use App\Services\Contracts\AuditLogServiceInterface;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class AuditLogController extends BaseController
{
    /**
     * @param AuditLogServiceInterface $logService
     */
    public function __construct(private AuditLogServiceInterface $logService){}

    /**
     * @return AuditLogCollection | JsonResponse
     */
    public function index(): AuditLogCollection | JsonResponse
    {
        // Try to fetch the Audit logs for the currently authenticated user.
        try {
            $auditLogs = $this->logService->fetch(auth()->user()->id);
            return $this->successResponse('Audit logs fetched successfully', $auditLogs);
        } catch (QueryException $e) {
            // If there was an error fetching the Audit logs (e.g. a database error), log the error and return an error response.
            Log::error("Audit logs database query failed: {$e->getMessage()}");
            return $this->errorResponse("Failed to fetch Audit logs", Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
