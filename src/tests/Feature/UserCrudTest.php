<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserCrudTest extends TestCase
{
    use RefreshDatabase;


    /** @test */
    public function testUserCanBeCreated()
    {
        $this->withoutMiddleware();

        $response = $this->post('/api/v1/users', [
            'first_name' => 'Test',
            'last_name' => 'User',
            'email' => 'test@test.com',
            'password' => 'password',
            'phone_number' => '1234567890'
        ]);

        $response->assertCreated();

        $this->assertCount(1, User::all());

        $response->assertJsonStructure([
            'data' => [
                'id',
                'name',
                'email',
                'phone_number',
                'is_admin'
            ]
        ]);
    }

    public function testCanShowUser()
    {
        $this->withoutMiddleware();

        $user = \App\Models\User::factory(1)->create()[0];

        $response = $this->get("/api/v1/users/{$user->id}");

        $response->assertStatus(200);

        $response->assertJsonStructure([
            'data' => [
                'id',
                'name',
                'email',
                'phone_number',
                'is_admin'
            ]
        ]);
    }

    /** @test */
    public function testUserCanBeUpdated()
    {
        $this->withoutMiddleware();

        $user = \App\Models\User::factory(1)->create()[0];

        $data = [
            'first_name' => 'New',
            'last_name' => 'Name',
            'is_admin' => 1,
            'email' => 'newemail@test.com',
            'phone_number' => '0987654321'
        ];

        $response = $this->put("/api/v1/users/{$user->id}", $data )->assertStatus(204);

        $updated = User::find($user->id);


        $this->assertEquals('New Name', $updated->name);
        $this->assertEquals('newemail@test.com', $updated->email);
        $this->assertEquals('0987654321', $updated->phone_number);
        $this->assertEquals(1, $updated->is_admin);
    }

    public function testUsersCanBeRetrieved()
    {
        $this->withoutMiddleware();

         $users = \App\Models\User::factory(10)->create();


         $response = $this->get("/api/v1/users");

         $response->assertStatus(200);
            $response->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'name',
                        'email',
                        'phone_number'
                    ]
                ]
         ]);
    }

    /** @test */
    public function testUserCanBeDeleted()
    {
        $this->withoutMiddleware();

        $this->post('/api/v1/users', [
            'first_name' => 'Test',
            'last_name' => 'User',
            'email' => 'test@test.com',
            'password' => 'password',
            'phone_number' => '1234567890'
        ]);

        $user = User::first();

        $response = $this->delete('/api/v1/users/' . $user->id);

        $response->assertStatus(204);
        $this->assertCount(0, User::all());
    }

    public function testCanLoginUser()
    {
        $user = User::factory(1)->create()[0];

        $response = $this->post('api/v1/auth/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $response->assertStatus(200);

        $response->assertJsonStructure([
            'data' => [
                'id',
                'name',
                'email',
                'phone_number',
                'is_admin'
            ],
            'token'
        ]);

        // Checking that the Sanctum cookie was set
        $this->assertTrue($response->headers->getCookies()[0]->getName() === 'booking_token');
    }

    public function testCanRegisterUser()
    {
        $user = User::factory(1)->create()[0];

        $response = $this->post('api/v1/auth/register', [
            'first_name' => 'Test',
            'last_name' => 'User',
            'email' => 'test@test.com',
            'password' => 'password',
            'phone_number' => '1234567890'
        ]);

        $response->assertStatus(201);

        $response->assertJsonStructure([
            'data' => [
                'id',
                'name',
                'email',
                'phone_number',
                'is_admin'
            ],
            'token'
        ]);

        // Checking that the Sanctum cookie was set
        $this->assertTrue($response->headers->getCookies()[0]->getName() === 'booking_token');
    }
}
