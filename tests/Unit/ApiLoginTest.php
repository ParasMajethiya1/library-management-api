<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Laravel\Passport\Passport;
use Spatie\Permission\Models\Role;

class ApiLoginTest extends TestCase
{
    /** @test */
    public function a_user_can_login_successfully()
    {
        // Create a test user
        $user = User::factory()->create([]);

        // Authenticate user for Passport
        Passport::actingAs($user);

        // Send API login request
        $response = $this->postJson('/api/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        // Assertions
        $response->assertStatus(200)
                 ->assertJsonStructure(['message', 'token', 'user']);
    }

    /** @test */
    public function login_fails_with_invalid_credentials()
    {
        // Create a test user
        $user = User::factory()->create([]);

        $userRole = Role::where('name', 'user')->first();
        if ($userRole) {
            $user->assignRole($userRole);
        }

        // Attempt to login with incorrect password
        $response = $this->postJson('/api/login', [
            'email' => $user->email,
            'password' => 'wrongpassword',
        ]);

        // Assertions
        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['email']);
    }

    /** @test */
    public function login_requires_email_and_password()
    {
        // Attempt to login without credentials
        $response = $this->postJson('/api/login', []);

        // Assertions
        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['email', 'password']);
    }
}