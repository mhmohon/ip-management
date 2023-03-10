<?php

namespace App\Providers;

use App\Services\AuditLogService;
use App\Services\AuthService;
use App\Services\Contracts\AuditLogServiceInterface;
use App\Services\Contracts\AuthServiceInterface;
use App\Services\Contracts\IPAddressServiceInterface;
use App\Services\IPAddressService;
use Illuminate\Support\ServiceProvider;

class ServicePatternProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(AuthServiceInterface::class, AuthService::class);
        $this->app->bind(IPAddressServiceInterface::class, IPAddressService::class);
        $this->app->bind(AuditLogServiceInterface::class, AuditLogService::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
