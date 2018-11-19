<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DepartmentTest extends TestCase
{
    public function testListDepartments()
    {
        $department = $this->createDepartment(10)->first();
        $response = $this->request(
            'departments.index',
            'GET'
        );

        $this->assertEquals(count($response->original), 10);
        $response
            ->assertStatus(200)
            ->assertJsonFragment([
                'id' => $department->id,
                'name' => $department->name,
                'description' => $department->description,
                'created_at' => $department->created_at->toDateTimeString(),
                'updated_at' => $department->updated_at->toDateTimeString()
            ]);
    }

    public function testShowDepartment()
    {
        $department = $this->createDepartment(10)->random();
        $response = $this->request(
            'departments.show',
            'GET',
            $department->id
        );

        $response
            ->assertStatus(200)
            ->assertJson([
                'id' => $department->id,
                'name' => $department->name,
                'description' => $department->description,
                'created_at' => $department->created_at->toDateTimeString(),
                'updated_at' => $department->updated_at->toDateTimeString()
            ]);
    }

    public function testCreateDepartment()
    {
        $response = $this->request(
            'departments.store',
            'POST',
            null,
            null,
            [
                'name' => 'Atlantico',
                'description' => 'Bla Bla Bla'
            ]
        );

        $response->assertStatus(201)
            ->assertJsonFragment([
                'name' => 'Atlantico'
            ])
            ->assertJsonFragment([
                'description' => 'Bla Bla Bla'
            ]);
    }

    public function testUpdateDepartment()
    {
        $department = $this->createDepartment(10)->random();
        $response = $this->request(
            'departments.update',
            'PUT',
            $department->id,
            null,
            [
                'name' => 'Bolivar',
                'description' => 'bla bla bla',
            ]
        );

        $response->assertStatus(200)
            ->assertJsonFragment([
                'id' => $department->id,
                'name' => 'Bolivar',
                'description' => 'bla bla bla',
                'created_at' => $department->created_at->toDateTimeString(),
                'updated_at' => $department->updated_at->toDateTimeString()
            ]);
    }

    public function testDeleteDepartment()
    {
        $department = $this->createDepartment(5)->random();
        $response = $this->request(
            'departments.destroy',
            'DELETE',
            $department->id
        );

        $response->assertStatus(200);

        $response = $this->request(
            'departments.index',
            'GET'
        );

        $this->assertEquals(count($response->original), 4);
    }

    public function testValidationFields()
    {
        $response = $this->request(
            'departments.store',
            'POST'
        );

        $response->assertStatus(422);
    }
}
