<?php

namespace Tests\Feature;

use App\Models\IPAddress;
use App\Models\User;
use App\Traits\IPAddressTrait;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class IPAddressTest extends TestCase
{
    use RefreshDatabase;
    use IPAddressTrait;

    private $user;

    public function setUp(): void
    {
        parent::setUp();

        $this->setBaseRoute('ip-address');
        $this->setBaseModel(IPAddress::class);
        $this->user = $this->createModelData(User::class);
    }

    /**
     * Unauthenticated user cant fetch all ip address
     * @test
     */
    public function unauthenticated_user_cant_fetch_all_ip_address(): void
    {
        $this->show();
    }

    /**
     * Unauthenticated user cant create ip address
     * @test
     */
    public function unauthenticated_user_cant_create_ip_address(): void
    {
        $attributes = [
            "label" => "test ip",
            "ip_address" => "103.14.72.92",
        ];

        $this->create($attributes);
    }

    /**
     * Unauthenticated user cant update single ip address
     * @test
     */
    public function unauthenticated_user_cant_update_single_ip_address(): void
    {
        $attributes = [
            "label" => "new test ip",
        ];
        $this->update($attributes);
    }

    /**
     * authenticated user cant create ip address for form validation
     * @test
     */
    public function authenticated_user_cant_create_ip_address_form_validation(): void
    {
        $attributes = ["label" => "test ip"];
        $validationAttr = ["ip_address"];

        $this->signIn();
        $this->checkFormValidation($attributes, $validationAttr, '/api/ip-address');
    }

    /**
     * authenticated user cant create ip address for wrong ip format
     * @test
     */
    public function authenticated_user_cant_create_ip_address_wrong_ip_format(): void
    {
        $attributes = [
            "label" => "test ip",
            "ip_address" => "103.14.72.92566",
        ];
        $validationAttr = ["ip_address"];

        $this->signIn();
        $this->checkFormValidation($attributes, $validationAttr, '/api/ip-address');
    }

    /**
     * authenticated user can fetch all ip address
     * @test
     */
    public function authenticated_user_can_fetch_all_ip_address(): void
    {
        $this->signIn();
        $this->show([], "IP addresses fetched successfully");
    }

    /**
     * authenticated user can create ip address
     * @test
     */
    public function authenticated_user_can_create_ip_address(): void
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

    /**
     * authenticated user cant update ip address of other user's
     * @test
     */
    public function authenticated_user_cant_update_ip_address_of_other_user(): void
    {
        $attributes = [
            "label" => "test ip",
            "ip_address" => $this->convertToBinary("103.14.72.92"),
            "user_id" => $this->user->id,
        ];
        $dbAttributes = [
            "label" => "gifts.ad-group.com.au",
        ];
        $ipAddress = $this->createModelData(IPAddress::class, $attributes);
        $response = $this->signIn()->putJson(route("{$this->baseRoute}.update", $ipAddress->id), $dbAttributes);
        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
    }
    
    /**
     * authenticated user can update ip address
     * @test
     */
    public function authenticated_user_can_update_ip_address(): void
    {
        $attributes = [
            "label" => "test ip",
            "ip_address" => $this->convertToBinary("103.14.72.92"),
            "user_id" => $this->user->id,
        ];
        $dbAttributes = [
            "label" => "gifts.ad-group.com.au",
        ];
        $this->signIn($this->user);
        $this->update($attributes, $dbAttributes);
    }
}
