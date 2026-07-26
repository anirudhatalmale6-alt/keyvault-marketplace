<?php

namespace Tests\Feature;

use App\Models\User;
use App\Services\Appearance;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminAppearanceTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(\Database\Seeders\RolePermissionSeeder::class);
    }

    private function admin(): User
    {
        $user = User::factory()->create(['role' => 'admin']);
        $user->assignRole('Admin');

        return $user;
    }

    public function test_non_admin_cannot_access_admin(): void
    {
        $user = User::factory()->create(['role' => 'customer']);

        $this->actingAs($user)->get('/admin')->assertForbidden();
    }

    public function test_admin_can_open_appearance_page(): void
    {
        $this->actingAs($this->admin())
            ->get('/admin/appearance')
            ->assertOk()
            ->assertInertia(fn ($page) => $page->component('Admin/Appearance'));
    }

    public function test_admin_can_update_appearance(): void
    {
        $payload = array_merge(Appearance::defaults(), [
            'logo_text'     => 'GameHub',
            'color_primary' => '#e11d48',
            'color_buy'     => '#f59e0b',
            'font'          => 'Montserrat',
            'announcement_enabled' => true,
        ]);

        $this->actingAs($this->admin())
            ->put('/admin/appearance', $payload)
            ->assertRedirect();

        $this->assertEquals('GameHub', Appearance::all()['logo_text']);
        $this->assertEquals('#e11d48', Appearance::all()['color_primary']);
    }

    public function test_appearance_validation_rejects_bad_color(): void
    {
        $payload = array_merge(Appearance::defaults(), ['color_primary' => 'not-a-color']);

        $this->actingAs($this->admin())
            ->put('/admin/appearance', $payload)
            ->assertSessionHasErrors('color_primary');
    }
}
