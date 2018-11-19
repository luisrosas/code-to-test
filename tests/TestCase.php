<?php

namespace Tests;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication, DatabaseMigrations;

    private $preNameRouteApi = '';

    protected function request($routeName, $method, $param = null, $query = null, $data = [])
    {
        $response = $this->json(
            $method,
            route($this->preNameRouteApi . $routeName, $param) . $query,
            $data
        );

        return $response;
    }

    protected function createUser($count = 1, $data = [])
    {
        return factory(\App\Models\User::class, $count)->create($data);
    }

    protected function createCity($count = 1, $data = [])
    {
        return factory(\App\Models\City::class, $count)->create($data);
    }

    protected function createDepartment($count = 1, $data = [])
    {
        return factory(\App\Models\Department::class, $count)->create($data);
    }
}
