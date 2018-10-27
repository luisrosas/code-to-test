<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    public function testListUsers()
    {
        $user = $this->createUser(10)->first();
        $this->createUser(5, ['active' => 0]);
        $response = $this->request(
            'users.index',
            'GET'
        );

        $this->assertEquals(count($response->original), 10);
        $response
            ->assertStatus(200)
            ->assertJsonFragment([
                'name' => $user->name,
                'email' => $user->email,
                'active' => $user->active,
                'created_at' => $user->created_at->toDateTimeString(),
                'updated_at' => $user->updated_at->toDateTimeString()
            ]);
    }

    public function testShowUser()
    {
        $user = $this->createUser(10)->random();
        $response = $this->request(
            'users.show',
            'GET',
            $user->id
        );

        $response
            ->assertStatus(200)
            ->assertJson([
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'active' => $user->active,
                'created_at' => $user->created_at->toDateTimeString(),
                'updated_at' => $user->updated_at->toDateTimeString()
            ]);
    }

    public function testCreateUser()
    {
        $response = $this->request(
            'users.store',
            'POST',
            null,
            null,
            [
                'name' => 'Usuario nuevo',
                'email' => 'UsuAriO.nuevo@email.com'
            ]
        );

        $response->assertStatus(201)
            ->assertJsonFragment([
                'email' => 'usuario.nuevo@email.com'
            ]);
    }

    public function testUpdateUser()
    {
        $user = $this->createUser(10)->random();
        $response = $this->request(
            'users.update',
            'PUT',
            $user->id,
            null,
            [
                'name' => 'Usuario actualizado',
                'email' => 'UsuAriO.ActuAlizAdO@email.com',
                'active' => 0
            ]
        );

        $response->assertStatus(200)
            ->assertJsonFragment([
                'id' => $user->id,
                'name' => 'USUARIO ACTUALIZADO',
                'email' => 'usuario.actualizado@email.com',
                'active' => 0,
                'created_at' => $user->created_at->toDateTimeString(),
                'updated_at' => $user->updated_at->toDateTimeString()

            ]);
    }

    public function testDeleteUser()
    {
        $user = $this->createUser(10)->random();
        $response = $this->request(
            'users.destroy',
            'DELETE',
            $user->id
        );

        $response->assertStatus(200);

        $response = $this->request(
            'users.index',
            'GET'
        );

        $this->assertEquals(count($response->original), 9);
    }

    public function testValidationFields()
    {
        $response = $this->request(
            'users.store',
            'POST'
        );

        $response->assertStatus(422);

        $response = $this->request(
            'users.store',
            'POST',
            null,
            null,
            [
                'name' => 'Usuario actualizado'
            ]
        );

        $response->assertStatus(422);
    }
}
