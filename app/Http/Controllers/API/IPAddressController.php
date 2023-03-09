<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\IPAddressRequest;
use App\Http\Resources\IpAddressCollection;
use App\Http\Resources\IPAddressResource;
use App\Models\IpAddress;
use App\Services\Contracts\IPAddressServiceInterface;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class IPAddressController extends BaseController
{
    private IPAddressServiceInterface $IPservice;

    public function __construct(IPAddressServiceInterface $IPservice)
    {
        $this->IPservice = $IPservice;
    }

   /**
    * @return IpAddressCollection | JsonResponse
    */
    public function index(): IpAddressCollection | JsonResponse
    {
        // Try to fetch the IP addresses for the currently authenticated user.
        try {
            $ipAddresses = $this->IPservice->fetch(auth()->user()->id);
            return $this->successResponse('IP addresses fetched successfully', $ipAddresses);
        } catch (QueryException $e) {
            // If there was an error fetching the IP addresses (e.g. a database error), log the error and return an error response.
            Log::error("Database query failed: {$e->getMessage()}");
            return $this->errorResponse("Failed to fetch IP addresses", Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @param IPAddressRequest $request
     * @return void
     */
    public function store(IPAddressRequest $request): IPAddressResource | JsonResponse
    {
        // Try to create a new IP address for the currently authenticated user using the validated data from the request.
        try {
            $ipAddresses = $this->IPservice->create(auth()->user(), $request->validated());
            return $this->successResponse('IP addresses stored successfully', $ipAddresses);
        } catch (QueryException $e) {
            // If there was an error creating the IP address (e.g. a database error), log the error and return an error response.
            Log::error("Database query failed: {$e->getMessage()}");
            return $this->errorResponse("Failed to stored IP addresses", Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(IPAddressRequest $request, IpAddress $ipAddress)
    {
        // Try to create a new IP address for the currently authenticated user using the validated data from the request.
        try {
            $updateData = $this->IPservice->modifyFetch(auth()->user(), $request->validated(), $ipAddress);
            return $this->successResponse('IP addresses stored successfully', $updateData);
        } catch (QueryException $e) {
            // If there was an error creating the IP address (e.g. a database error), log the error and return an error response.
            Log::error("Database query failed: {$e->getMessage()}");
            return $this->errorResponse("Failed to stored IP addresses", Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
