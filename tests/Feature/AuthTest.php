<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    private $model;
    private $user;

    public function setUp(): void
    {
        parent::setUp();

        $this->model = User::class;
        $this->user = $this->createModelData(User::class);
    }

    /**
     * @test
     */
    public function check_auth_route(): void
    {
        $this->get('api/login')->assertSuccessful();
    }

    /**
     * @test
     */
    public function user_cant_login_without_email_field(): void
    {
        $attributes = [
            "password" => "password"
        ];

        $response = $this->postJson('/api/login', $attributes);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJson([
            "status" => Response::HTTP_UNPROCESSABLE_ENTITY,
            "success" => false,
            "message" => "Validation errors",
        ]);
        $response->assertJsonValidationErrors("email");
    }

    /**
     * @test
     */
    public function user_cant_login_without_password_field(): void
    {
        $attributes = [
            "email" => "abc@gmail.com"
        ];

        $response = $this->postJson('/api/login', $attributes);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJson([
            "status" => Response::HTTP_UNPROCESSABLE_ENTITY,
            "success" => false,
            "message" => "Validation errors",
        ]);
        $response->assertJsonValidationErrors("password");
    }

    /**
     * @test
     */
    public function user_cant_login_with_wrong_email_field(): void
    {
        $attributes = [
            "email" => "abc@",
            "password" => "password"
        ];

        $response = $this->postJson('/api/login', $attributes);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJson([
            "status" => Response::HTTP_UNPROCESSABLE_ENTITY,
            "success" => false,
            "message" => "Validation errors",
        ]);
        $response->assertJsonValidationErrors(["email"]);
    }

    /**
     * @test
     */
    public function user_cant_login_with_wrong_credentials(): void
    {
        $attributes = [
            "email" => "abc@gmail.com",
            "password" => "password"
        ];

        $response = $this->postJson('/api/login', $attributes);
        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
        $response->assertJson([
            "status" => Response::HTTP_UNAUTHORIZED,
            "success" => false,
            "message" => "Unauthorised! Credentials do not match",
        ]);
    }

    /**
     * @test
     */
    public function user_can_login_with_right_credentials(): void
    {
        $attributes = [
            "email" => $this->user->email,
            "password" => "password"
        ];

        $response = $this->postJson('/api/login', $attributes);
        $response->assertStatus(Response::HTTP_OK);
        $response->assertJson([
            "status" => Response::HTTP_OK,
            "success" => true,
            "message" => "User signed in successfully",
        ]);
    }
}
