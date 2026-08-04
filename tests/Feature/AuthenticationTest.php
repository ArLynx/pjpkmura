<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_page_can_be_opened(): void
    {
        $this->get(route('login'))->assertOk();
    }

    public function test_active_user_can_login_with_username(): void
    {
        $user = User::factory()->superadmin()->create([
            'username' => 'superadmin',
            'password' => 'Secret123!',
        ]);

        $response = $this->post(route('login.store'), [
            'login' => 'superadmin',
            'password' => 'Secret123!',
        ]);

        $response->assertRedirect(route('admin.dashboard'));
        $this->assertAuthenticatedAs($user);
    }

    public function test_inactive_user_cannot_login(): void
    {
        User::factory()->inactive()->create([
            'username' => 'nonaktif',
            'password' => 'Secret123!',
        ]);

        $this->post(route('login.store'), [
            'login' => 'nonaktif',
            'password' => 'Secret123!',
        ])->assertSessionHasErrors('login');

        $this->assertGuest();
    }

    public function test_guest_is_redirected_from_admin_page(): void
    {
        $this->get(route('admin.dashboard'))->assertRedirect(route('login'));
    }

    public function test_authenticated_user_can_logout(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->post(route('logout'))
            ->assertRedirect(route('login'));

        $this->assertGuest();
    }
}
