<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CityTest extends TestCase
{
    public function testListCities()
    {
        $city = $this->createCity(10)->first();
        $response = $this->request(
            'cities.index',
            'GET'
        );

        $this->assertEquals(count($response->original), 10);
        $response
            ->assertStatus(200)
            ->assertJsonFragment([
                'id' => $city->id,
                'name' => $city->name,
                'created_at' => $city->created_at->toDateTimeString(),
                'updated_at' => $city->updated_at->toDateTimeString()
            ]);
    }

    public function testShowCity()
    {
        $city = $this->createCity(10)->random();
        $response = $this->request(
            'cities.show',
            'GET',
            $city->id
        );

        $response
            ->assertStatus(200)
            ->assertJson([
                'id' => $city->id,
                'name' => $city->name,
                'created_at' => $city->created_at->toDateTimeString(),
                'updated_at' => $city->updated_at->toDateTimeString()
            ]);
    }

    public function testCreateCity()
    {
        $response = $this->request(
            'cities.store',
            'POST',
            null,
            null,
            [
                'name' => 'Cartagena'
            ]
        );

        $response->assertStatus(201)
            ->assertJsonFragment([
                'name' => 'Cartagena'
            ]);
    }

    public function testUpdateCity()
    {
        $city = $this->createCity(10)->random();
        $response = $this->request(
            'cities.update',
            'PUT',
            $city->id,
            null,
            [
                'name' => 'Pasto'
            ]
        );

        $response->assertStatus(200)
            ->assertJsonFragment([
                'id' => $city->id,
                'name' => 'Pasto',
                'created_at' => $city->created_at->toDateTimeString(),
                'updated_at' => $city->updated_at->toDateTimeString()
            ]);
    }

    public function testDeleteCity()
    {
        $city = $this->createCity(5)->random();
        $response = $this->request(
            'cities.destroy',
            'DELETE',
            $city->id
        );

        $response->assertStatus(200);

        $response = $this->request(
            'cities.index',
            'GET'
        );

        $this->assertEquals(count($response->original), 4);
    }

    public function testValidationFields()
    {
        $response = $this->request(
            'cities.store',
            'POST'
        );

        $response->assertStatus(422);
    }
}
