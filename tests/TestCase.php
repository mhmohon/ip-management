<?php

namespace Tests;

use App\Models\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Symfony\Component\HttpFoundation\Response;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    use RefreshDatabase;

    protected $baseRoute = null;
    protected $baseModel = null;


    protected function setBaseRoute(string $route)
    {
        $this->baseRoute = $route;
    }

    protected function setBaseModel(string $model)
    {
        $this->baseModel = $model;
    }
    
    protected function createModelData(string $class, array $attributes = []): mixed
    {
        return $class::factory()->create($attributes);
    }

    protected function signIn(mixed $user = null)
    {
        $user = $user ?? $this->createModelData(User::class);
        $this->actingAs($user, 'sanctum');
        return $this;
    }

    protected function initialRequest(
        ?array $attributes, 
        string $route, 
        ?string $requestType = 'post', 
        ?string $model = ''
    ): mixed
    {
        $this->withoutExceptionHandling();

        $model = $this->baseModel ?? $model;

        if(! auth()->user()){
            $this->expectException(AuthenticationException::class);
        }
        return $this->$requestType($route, $attributes);
    }

    protected function checkFormValidation(
        ?array $attributes, 
        ?array $validationAttr, 
        string $route, 
        ?string $requestType = 'post', 
        ?string $model = ''
    ): mixed
    {
        $response = $this->initialRequest($attributes, $route, $requestType);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJson([
            "status" => Response::HTTP_UNPROCESSABLE_ENTITY,
            "success" => false,
            "message" => "Validation errors",
        ]);
        $response->assertJsonValidationErrors($validationAttr);
        return $response;
    }

    protected function create(
        array $attributes = [], 
        ?array $dbAttributes = [], 
        ?string $route = '', 
        ?string $model = ''
    ): mixed
    {
        $this->withoutExceptionHandling();

        $model = $this->baseModel ?? $model;
        $route = $this->baseRoute ? "{$this->baseRoute}.store" : $route;

        if(! auth()->user()){
            $this->expectException(AuthenticationException::class);
        }
        $response = $this->postJson(route($route), $attributes);
        $response->assertStatus(Response::HTTP_OK);

        $response->assertJson([
            "success" => true,
            "status" => Response::HTTP_OK,
            "payload" => $attributes,
        ]);

        $model = new $model;
        $dbAttributes = !empty($dbAttributes) ? $dbAttributes : $attributes;

        $this->assertDatabaseHas($model->getTable(), $dbAttributes);
        return $response;
    }

    protected function show(
        ?array $attributes = [], 
        ?string $message = '',
        ?string $route = '', 
        ?string $model = ''
    ): mixed
    {
        $this->withoutExceptionHandling();

        $model = $this->baseModel ?? $model;
        $route = $this->baseRoute ? "{$this->baseRoute}.store" : $route;

        if(! auth()->user()){
            $this->expectException(AuthenticationException::class);
        }
        $response = $this->getJson(route($route));
        $response->assertStatus(Response::HTTP_OK);
        $response->assertJson([
            "success" => true,
            "status" => Response::HTTP_OK,
            "message" => $message,
        ]);
        return $response;
    }

    protected function update(
        array $attributes = [], 
        array $dbAttributes = [], 
        ?string $route = '', 
        ?string $model = ''
    ): mixed
    {
        $this->withoutExceptionHandling();

        $model = $this->baseModel ?? $model;
        $route = $this->baseRoute ? "{$this->baseRoute}.update" : $route;
        
        $model = $this->createModelData($model, $attributes);
        if(! auth()->user()){
            $this->expectException(AuthenticationException::class);
        }
        $response = $this->patchJson(route($route, $model->id), $dbAttributes);
        
        $response->assertStatus(Response::HTTP_OK);
        $response->assertJson([
            "success" => true,
            "status" => Response::HTTP_OK,
            "payload" => $dbAttributes,
        ]);

        $model = new $model;
        $dbAttributes = !empty($dbAttributes) ? $dbAttributes : $attributes;

        $this->assertDatabaseHas($model->getTable(), $dbAttributes);
        return $response;
    }
}
