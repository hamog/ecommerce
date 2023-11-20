<?php

namespace Tests\Feature\Http\Controllers\Admin;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Spatie\Permission\Models\Permission;
use Tests\TestCase;

class HomeControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test that the admin home page is accessible to super admins.
     *
     * @return void
     */
    public function test_can_see_admin_home_page_if_user_is_super_admin(): void
    {
        $this->actingAs($this->superAdminUser())
            ->get(route('admin.home.index'))
            ->assertStatus(200)
            ->assertViewIs('admin.home.index')
            ->assertSee('Dashboard');
    }

    /**
     * Test that a user cannot see the admin home page if they are not a super admin.
     *
     * @return void
     */
    public function test_cannot_see_admin_home_page_if_user_is_not_super_admin(): void
    {
        $this->actingAs($this->user())
            ->get(route('admin.home.index'))
            ->assertForbidden();
    }

    /**
     * Test that the user is redirected to the login page if they are not logged in.
     *
     * @return void
     */
    public function test_cannot_see_admin_home_page_if_user_is_not_logged_in(): void
    {
        $this->get(route('admin.home.index'))->assertRedirect(route('login'));
    }

    /**
     * Test that the admin home page is accessible if user has the permission
     *
     * @return void
     */
    public function test_can_see_admin_home_page_if_user_has_permission(): void
    {
        $user = $this->user();
        $user->givePermissionTo(
            Permission::findOrCreate('view admin dashboard'),
        );

        $this->actingAs($user)
            ->get(route('admin.home.index'))
            ->assertStatus(200)
            ->assertViewIs('admin.home.index')
            ->assertSee('Dashboard');
    }
}
