<?php

namespace Tests\Feature;

use App\Models\Pilar;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminCrudTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_admin_can_create_pilar(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->post(route('admin.pilars.store'), [
                'nama' => 'Pilar Pembangunan Keluarga',
                'urutan' => 1,
            ])
            ->assertRedirect(route('admin.pilars.index'));

        $this->assertDatabaseHas('pilars', [
            'nama' => 'Pilar Pembangunan Keluarga',
            'urutan' => 1,
        ]);
    }

    public function test_regular_admin_cannot_manage_users(): void
    {
        $user = User::factory()->create(['role' => 'admin']);

        $this->actingAs($user)
            ->get(route('admin.users.index'))
            ->assertForbidden();
    }

    public function test_superadmin_can_manage_users(): void
    {
        $user = User::factory()->superadmin()->create();

        $this->actingAs($user)
            ->get(route('admin.users.index'))
            ->assertOk();
    }
}
