<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Models\IPAddress;
use App\Models\User;
use App\Traits\IPAddressTrait;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class IPAddressTest extends TestCase
{
    use RefreshDatabase;
    use IPAddressTrait;
    // https://medium.com/@wanmigs/laravel-common-php-unit-testing-crud-made-easy-8bd8d20f5c92
    public function setUp(): void
    {
        parent::setUp();

        $this->setBaseRoute('ip-address');
        $this->setBaseModel(IPAddress::class);
    }
    /**
     * Unauthenticated user cant create task and redirect to login get route
     */
    public function test_unauthenticated_user_cant_create_ip_address(): void
    {
        $attributes = [
            "label" => "test ip",
            "ip_address" => "103.14.72.92",
        ];

        $this->create($attributes);
    }
    /**
     * authenticated user can create ip address
     */
    public function test_authenticated_user_can_create_ip_address(): void
    {
        $attributes = [
            "label" => "test ip",
            "ip_address" => "103.14.72.92",
        ];
        $dbAttributes = [
            "label" => "test ip",
            "ip_address" => $this->convertToBinary($attributes["ip_address"]),
        ];
        $this->signIn();
        $this->create($attributes, $dbAttributes);
    }
}
