<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Book;
use Laravel\Passport\Passport;
use Spatie\Permission\Models\Role;

class BookApiTest extends TestCase
{
    /** @test */
    public function guest_cannot_access_protected_routes()
    {
        $this->getJson('/api/books')->assertUnauthorized();
        $this->postJson('/api/books')->assertUnauthorized();
    }

    /** @test */
    public function authenticated_user_can_view_books()
    {
        Passport::actingAs(User::factory()->create());

        $response = $this->getJson('/api/books');

        $response->assertStatus(200);
    }

    /** @test */
    public function admin_can_create_books()
    {
        $admin = User::factory()->create([]);
        $userRole = Role::where('name', 'admin')->first();
        if ($userRole) {
            $admin->assignRole($userRole);
        }
        Passport::actingAs($admin);

        $response = $this->postJson('/api/books', [
            'title' => 'Laravel Testing',
            'author' => 'Taylor Otwell',
        ]);

        $response->assertStatus(201);
    }

    /** @test */
    public function user_cannot_create_books()
    {
        $user = User::factory()->create([]);
        $userRole = Role::where('name', 'user')->first();
        if ($userRole) {
            $user->assignRole($userRole);
        }
        Passport::actingAs($user);

        $response = $this->postJson('/api/books', [
            'title' => 'Unauthorized Book',
            'author' => 'John Doe',
            'published_at' => now()->toDateString(),
        ]);

        $response->assertForbidden();
    }
}
