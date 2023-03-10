<?php

namespace Tests;

use App\Models\User;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Symfony\Component\HttpFoundation\Response;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    use RefreshDatabase;

    protected $baseRoute = null;
    protected $baseModel = null;


    protected function setBaseRoute($route)
    {
        $this->baseRoute = $route;
    }

    protected function setBaseModel($model)
    {
        $this->baseModel = $model;
    }

    protected function signIn($user = null)
    {
        $user = $user ?? User::factory()->create();
        $this->actingAs($user, 'sanctum');
        return $this;
    }

    protected function create($attributes = [], $dbAttributes = [], $model = '', $route = '')
    {
        $this->withoutExceptionHandling();

        $model = $this->baseModel ?? $model;
        $route = $this->baseRoute ? "{$this->baseRoute}.store" : $route;

        if(! auth()->user()){
            $this->expectException(AuthenticationException::class);
        }
        $response = $this->postJson(route($route), $attributes)->assertSuccessful();
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


}
