<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;

class UserAuthControllerTest extends TestCase
{
    /**
     * A basic unit test example.
     */
    public function test_example(): void
    {
        $this->assertTrue(true);
    }

    // public function test_register_new_user()
    // {
    //     $userData = [
    //         'name' => 'Salma Ezzouina',
    //         'email' => 'salmaEzzouina@example.com',
    //         'password' => 'password',
    //         'password_confirmation' => 'password', // Add password confirmation
    //     ];

    //     $response = $this->postJson('/api/register', $userData);

    //     $response->assertStatus(200)
    //         ->assertJsonStructure([
    //             'status',
    //             'message',
    //             'user' => [
    //                 'id',
    //                 'name',
    //                 'email',
    //                 // Add other fields if needed
    //             ],
    //             'authorisation' => [
    //                 'token',
    //                 'type',
    //             ]
    //         ]);

    //     $this->assertDatabaseHas('users', ['email' => 'john9@example.com']);
    // }

    public function test_login_existing_user()
    {
        $email = 'test40_' . uniqid() . '@example.com'; // Generate unique email address
    User::factory()->create([
        'email' => $email,
        'password' => bcrypt('password'),
    ]);

    $loginData = [
        'email' => $email,
        'password' => 'password',
    ];

    $response = $this->postJson('/api/login', $loginData);

    $response->assertStatus(200)
        ->assertJsonStructure([
            'status',
            'user' => [
                'id',
                'name',
                'email',
                // Add other fields if needed
            ],
            'authorisation' => [
                'token',
                'type',
            ]
        ]);
    }

}
