<?php

namespace Tests\Feature;

use App\Models\AuditLog;
use App\Models\IPAddress;
use App\Models\User;
use App\Traits\IPAddressTrait;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuditLogTest extends TestCase
{
    use RefreshDatabase;
    use IPAddressTrait;

    private $model;
    private $user;

    public function setUp(): void
    {
        parent::setUp();

        $this->model = AuditLog::class;
        $this->user = $this->createModelData(User::class);
    }

    /**
     * Unauthenticated user cant fetch all auditlog
     * @test
     */
    public function unauthenticated_user_cant_fetch_all_auditlog(): void
    {
        $this->show([],"", 'api.auditlogs');
    }

    /**
     * authenticated user can fetch all auditlog
     * @test
     */
    public function authenticated_user_can_fetch_all_auditlog(): void
    {
        $this->signIn();
        $this->show([], "Audit logs fetched successfully", 'api.auditlogs');
    }

    /**
     * @test
     */
    public function log_will_create_when_user_login(): void
    {
        $attributes = [
            "email" => $this->user->email,
            "password" => "password"
        ];

        $response = $this->postJson('/api/login', $attributes);

        $model = new $this->model;
        $this->assertDatabaseHas($model->getTable(), [
            'event' => 'Login',
        ]);
    }

    /**
     * A log will create when any new ip address created
     * @test
     */
    public function log_will_create_when_any_new_ip_address_created(): void
    {
        $attributes = [
            "label" => "test ip 2",
            "ip_address" => "103.14.72.92",
        ];
        $dbAttributes = [
            "label" => "test ip 2",
            "ip_address" => $this->convertToBinary($attributes["ip_address"]),
        ];
        $this->signIn();
        $this->create($attributes, $dbAttributes, 'ip-address.store', IPAddress::class);

        $model = new $this->model;
        $this->assertDatabaseHas($model->getTable(), [
            'event' => 'Stored',
            'description' => 'IP addresses stored successfully'
        ]);
    }

    /**
     * A log will create when any ip address updated
     * @test
     */
    public function log_will_create_when_any_ip_address_updated(): void
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
        $this->update($attributes, $dbAttributes,'ip-address.update', IPAddress::class);

        $model = new $this->model;
        $this->assertDatabaseHas($model->getTable(), [
            'event' => 'Updated',
            'description' => 'IP addresses updated successfully'
        ]);
    }
}
