<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\IPAddressRequest;
use App\Http\Resources\IpAddressCollection;
use App\Http\Resources\IPAddressResource;
use App\Models\IPAddress;
use App\Services\Contracts\IPAddressServiceInterface;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class IPAddressController extends BaseController
{
    public function __construct(private IPAddressServiceInterface $ipService)
    {

    }

   /**
    * @return IpAddressCollection | JsonResponse
    */
    public function index(): IpAddressCollection | JsonResponse
    {
        // Try to fetch all IP addresses for the current authenticated user.
        try {
            $ipAddresses = $this->ipService->fetch(auth()->user()->id);
            return $this->successResponse('IP addresses fetched successfully', $ipAddresses);
        } catch (QueryException $e) {
            // If there was an error fetching the IP addresses (e.g. a database error), log the error and return an error response.
            Log::error("Database query failed: {$e->getMessage()}");
            return $this->errorResponse("Failed to fetch IP addresses", Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @param IPAddressRequest $request
     * @return IPAddressResource | JsonResponse
     */
    public function store(IPAddressRequest $request): IPAddressResource | JsonResponse
    {
        // Try to create a new IP address for the currently authenticated user using the validated data from the request.
        try {
            $ipAddress = $this->ipService->create(auth()->user(), $request->validated());
            return $this->successResponse("IP addresses stored successfully", $this->convertToResource($ipAddress));
        } catch (QueryException $e) {
            // If there was an error creating the IP address (e.g. a database error), log the error and return an error response.
            Log::error("Database query failed: {$e->getMessage()}");
            return $this->errorResponse("Failed to stored IP addresses", Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @param IPAddress $ipAddress
     * @return IPAddressResource | JsonResponse
     */
    public function show(IPAddress $ipAddress): IPAddressResource | JsonResponse
    {
        // Try to featch a new IP address for the currently authenticated user using the validated data from the request.
        try {
            if(auth()->user()->id != $ipAddress->user_id){
                return $this->errorResponse("Access denied! You are not authorized to perform this action", Response::HTTP_UNAUTHORIZED);
            }
            return $this->successResponse("IP addresses fetched successfully", $this->convertToResource($ipAddress));
        } catch (QueryException $e) {
            // If there was an error creating the IP address (e.g. a database error), log the error and return an error response.
            Log::error("Database query failed: {$e->getMessage()}");
            return $this->errorResponse("Failed to fetched IP addresses", Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @param IPAddressRequest $request
     * @param IPAddress $ipAddress
     * @return IPAddressResource | JsonResponse
     */
    public function update(IPAddressRequest $request, IPAddress $ipAddress): IPAddressResource | JsonResponse
    {
        // Try to create a new IP address for the currently authenticated user using the validated data from the request.
        try {
            $updateData = $this->ipService->modifyFetch(auth()->user(), $request->validated(), $ipAddress);
            return $this->successResponse("IP addresses updated successfully", $this->convertToResource($updateData));
        } catch (QueryException $e) {
            // If there was an error creating the IP address (e.g. a database error), log the error and return an error response.
            Log::error("Database query failed: {$e->getMessage()}");
            return $this->errorResponse("Failed to updated IP addresses", Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @param IPAddress $ipAddress
     * @return IPAddressResource
     */
    public function convertToResource(IPAddress $ipAddress): IPAddressResource
    {
        return new IPAddressResource($ipAddress);
    }
}
