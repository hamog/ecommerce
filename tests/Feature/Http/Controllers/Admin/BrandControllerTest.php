<?php

namespace Tests\Feature\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Spatie\Permission\Models\Permission;
use Tests\TestCase;

class BrandControllerTest extends TestCase
{
    use RefreshDatabase, withFaker;

    /**
     * Test that the admin user index page is accessible to super admins.
     *
     * @return void
     */
    public function test_can_see_admin_brand_index_page_if_user_is_super_admin(): void
    {
        $this->actingAs($this->superAdminUser())
            ->get(route('admin.brands.index'))
            ->assertStatus(200)
            ->assertViewIs('admin.brands.index')
            ->assertSee('Brands')
            ->assertViewHas('brands');
    }

    /**
     * Test that a user cannot see the admin user index page if they are not a super admin.
     *
     * @return void
     */
    public function test_cannot_see_admin_brand_index_page_if_user_is_not_super_admin(): void
    {
        $this->actingAs($this->user())
            ->get(route('admin.brands.index'))
            ->assertForbidden();
    }

    /**
     * Test that the user is redirected to the login page if they are not logged in.
     *
     * @return void
     */
    public function test_cannot_see_admin_brand_index_page_if_user_is_not_logged_in(): void
    {
        $this->get(route('admin.brands.index'))->assertRedirect(route('login'));
    }

    /**
     * Test that the admin user index page is accessible if user has the permission
     *
     * @return void
     */
    public function test_can_see_admin_brand_index_page_if_user_has_permission(): void
    {
        $user = $this->user();
        $user->givePermissionTo([
            Permission::findOrCreate('view all brands'),
            Permission::findOrCreate('view admin dashboard'),
        ]);

        $this->actingAs($user)
            ->get(route('admin.brands.index'))
            ->assertStatus(200)
            ->assertViewIs('admin.brands.index')
            ->assertSee('Brands');
    }

    /**
     * Test that the admin user create page is accessible to super admins.
     *
     * @return void
     */
    public function test_can_display_create_brand_page_if_user_is_super_admin(): void
    {
        $this->actingAs($this->superAdminUser())
            ->get(route('admin.brands.create'))
            ->assertStatus(200)
            ->assertViewIs('admin.brands.create')
            ->assertSee('Create Brand');
    }

    /**
     * Test that a user cannot see the admin user create page if they are not a super admin.
     *
     * @return void
     */
    public function test_cannot_display_create_brand_page_if_user_is_not_super_admin(): void
    {
        $this->actingAs($this->user())
            ->get(route('admin.brands.create'))
            ->assertForbidden();
    }

    /**
     * Test that the user is redirected to the login page if they are not logged in.
     *
     * @return void
     */
    public function test_cannot_display_create_brand_page_if_user_is_not_logged_in(): void
    {
        $this->get(route('admin.brands.create'))->assertRedirect(route('login'));
    }

    /**
     * Test that the admin user create page is accessible if user has the permission
     *
     * @return void
     */
    public function test_can_display_create_brand_page_if_user_has_permission(): void
    {
        $user = $this->user();
        $user->givePermissionTo(
            Permission::findOrCreate('create brand'),
            Permission::findOrCreate('view admin dashboard'),
        );

        $this->actingAs($user)
            ->get(route('admin.brands.create'))
            ->assertStatus(200)
            ->assertViewIs('admin.brands.create')
            ->assertSee('Create Brand');
    }

    /**
     * Test that the admin user create page is not accessible if user does not have the permission
     *
     * @return void
     */
    public function test_cannot_display_create_brand_page_if_user_does_not_have_permission(): void
    {
        $user = $this->user();

        $this->actingAs($user)
            ->get(route('admin.brands.create'))
            ->assertForbidden();
    }

    /**
     * Test that the admin user store page is accessible to super admins.
     *
     * @return void
     */
    public function test_can_store_user_if_user_is_super_admin(): void
    {
        $this->actingAs($this->superAdminUser())
            ->post(route('admin.users.store'), [
                'name' => 'Test User',
                'email' => $this->faker()->safeEmail,
                'password' => 'password',
                'password_confirmation' => 'password',
            ])
            ->assertRedirect(route('admin.users.index'))
            ->assertSessionHas('success', 'User created successfully.')
            ->assertSessionMissing('error');

        $this->assertCount(2, User::all());
    }

    /**
     * Test that a user cannot store a user if they are not a super admin.
     *
     * @return void
     */
    public function test_cannot_store_user_if_user_is_not_super_admin(): void
    {
        $this->actingAs($this->user())
            ->post(route('admin.users.store'), [
                'name' => 'Test User',
                'email' => $this->faker()->safeEmail,
                'password' => 'password',
                'password_confirmation' => 'password',
            ])
            ->assertForbidden();
    }

    /**
     * Test that the user is redirected to the login page if they are not logged in.
     *
     * @return void
     */
    public function test_cannot_store_user_if_user_is_not_logged_in(): void
    {
        $this->post(route('admin.users.store'), [
            'name' => 'Test User',
            'email' => $this->faker()->safeEmail,
            'password' => 'password',
            'password_confirmation' => 'password',
        ])->assertRedirect(route('login'));
    }

    /**
     * Test that the admin user store page is accessible if user has the permission
     *
     * @return void
     */
    public function test_can_store_user_if_user_has_permission(): void
    {
        $user = $this->user();
        $user->givePermissionTo(
            Permission::findOrCreate('create user'),
            Permission::findOrCreate('view admin dashboard'),
        );

        $this->actingAs($user)
            ->post(route('admin.users.store'), [
                'name' => 'Test User',
                'email' => $this->faker()->safeEmail,
                'password' => 'password',
                'password_confirmation' => 'password',
            ])
            ->assertRedirect(route('admin.users.index'))
            ->assertSessionHas('success', 'User created successfully.')
            ->assertSessionMissing('error');

        $this->assertCount(2, User::all());
    }

    /**
     * Test that the admin user store page is not accessible if user does not have the permission
     *
     * @return void
     */
    public function test_cannot_store_user_if_user_does_not_have_permission(): void
    {
        $user = $this->user();

        $this->actingAs($user)
            ->post(route('admin.users.store'), [
                'name' => 'Test User',
                'email' => $this->faker()->safeEmail,
                'password' => 'password',
                'password_confirmation' => 'password',
            ])
            ->assertForbidden();
    }

    /**
     * Test that the request is validated when creating a user.
     *
     * @return void
     */
    public function test_can_validate_user_store_request(): void
    {
        $this->actingAs($this->superAdminUser())
            ->post(route('admin.users.store'), [
                'name' => '',
                'email' => '',
                'password' => '',
                'password_confirmation' => '',
            ])
            ->assertSessionHasErrors(['name', 'email', 'password']);
    }

    /**
     * Test that the admin user edit page is accessible to super admins.
     *
     * @return void
     */
    public function test_can_display_edit_user_page_if_user_is_super_admin(): void
    {
        $user = $this->user();

        $this->actingAs($this->superAdminUser())
            ->get(route('admin.users.edit', $user))
            ->assertStatus(200)
            ->assertViewIs('admin.users.edit')
            ->assertSee('Edit User');
    }

    /**
     * Test that a user cannot see the admin user edit page if they are not a super admin.
     *
     * @return void
     */

    public function test_cannot_display_edit_user_page_if_user_is_not_super_admin(): void
    {
        $user = $this->user();

        $this->actingAs($this->user())
            ->get(route('admin.users.edit', $user))
            ->assertForbidden();
    }

    /**
     * Test that the user is redirected to the login page if they are not logged in.
     *
     * @return void
     */
    public function test_cannot_display_edit_user_page_if_user_is_not_logged_in(): void
    {
        $user = $this->user();

        $this->get(route('admin.users.edit', $user))->assertRedirect(
            route('login'),
        );
    }

    /**
     * Test that the admin user edit page is accessible if user has the permission
     *
     * @return void
     */
    public function test_can_display_edit_user_page_if_user_has_permission(): void
    {
        $user = $this->user();
        $user->givePermissionTo(
            Permission::findOrCreate('update user'),
            Permission::findOrCreate('view admin dashboard'),
        );

        $this->actingAs($user)
            ->get(route('admin.users.edit', $user))
            ->assertStatus(200)
            ->assertViewIs('admin.users.edit')
            ->assertSee('Edit User');
    }

    /**
     * Test that the admin user edit page is not accessible if user does not have the permission
     *
     * @return void
     */
    public function test_cannot_display_edit_user_page_if_user_does_not_have_permission(): void
    {
        $user = $this->user();

        $this->actingAs($user)
            ->get(route('admin.users.edit', $user))
            ->assertForbidden();
    }

    /**
     * Test that the admin user update page is accessible to super admins.
     *
     * @return void
     */
    public function test_can_update_user_if_user_is_super_admin(): void
    {
        $user = $this->user();

        $this->actingAs($this->superAdminUser())
            ->put(route('admin.users.update', $user), [
                'name' => 'Test User',
                'email' => $this->faker()->safeEmail,
            ])
            ->assertRedirect(route('admin.users.index'))
            ->assertSessionHas('success', 'User updated successfully.')
            ->assertSessionMissing('error');

        $this->assertEquals('Test User', $user->fresh()->name);
        $this->assertNotEquals($user->email, $user->fresh()->email);
    }

    /**
     * Test that a user cannot update a user if they are not a super admin.
     *
     * @return void
     */
    public function test_cannot_update_user_if_user_is_not_super_admin(): void
    {
        $user = $this->user();

        $this->actingAs($this->user())
            ->put(route('admin.users.update', $user), [
                'name' => 'Test User',
                'email' => $this->faker()->safeEmail,
            ])
            ->assertForbidden();

        $this->assertNotEquals('Test User', $user->fresh()->name);
        $this->assertEquals($user->email, $user->fresh()->email);
    }

    /**
     * Test that the user is redirected to the login page if they are not logged in.
     *
     * @return void
     */
    public function test_cannot_update_user_if_user_is_not_logged_in(): void
    {
        $user = $this->user();

        $this->put(route('admin.users.update', $user), [
            'name' => 'Test User',
            'email' => $this->faker()->safeEmail,
        ])->assertRedirect(route('login'));
    }

    /**
     * Test that the admin user update page is accessible if user has the permission
     *
     * @return void
     */
    public function test_can_update_user_if_user_has_permission(): void
    {
        $user = $this->user();
        $user->givePermissionTo(
            Permission::findOrCreate('update user'),
            Permission::findOrCreate('view admin dashboard'),
        );

        $this->actingAs($user)
            ->put(route('admin.users.update', $user), [
                'name' => 'Test User',
                'email' => $this->faker()->safeEmail,
            ])
            ->assertRedirect(route('admin.users.index'))
            ->assertSessionHas('success', 'User updated successfully.')
            ->assertSessionMissing('error');

        $this->assertEquals('Test User', $user->fresh()->name);
        $this->assertNotEquals($user->email, $user->fresh()->email);
    }

    /**
     * Test that the admin user update page is not accessible if user does not have the permission
     *
     * @return void
     */
    public function test_cannot_update_user_if_user_does_not_have_permission(): void
    {
        $user = $this->user();

        $this->actingAs($user)
            ->put(route('admin.users.update', $user), [
                'name' => 'Test User',
                'email' => $this->faker()->safeEmail,
            ])
            ->assertForbidden();
    }

    /**
     * Test that the admin user delete page is accessible to super admins.
     *
     * @return void
     */
    public function test_can_delete_user_if_user_is_super_admin(): void
    {
        $user = $this->user();

        $this->actingAs($this->superAdminUser())
            ->delete(route('admin.users.destroy', $user))
            ->assertRedirect(route('admin.users.index'))
            ->assertSessionHas('success', 'User deleted successfully.')
            ->assertSessionMissing('error');
    }

    /**
     * Test that a user cannot delete a user if they are not a super admin.
     *
     * @return void
     */
    public function test_cannot_delete_user_if_user_is_not_super_admin(): void
    {
        $user = $this->user();

        $this->actingAs($this->user())
            ->delete(route('admin.users.destroy', $user))
            ->assertForbidden();
    }

    /**
     * Test that the user is redirected to the login page if they are not logged in.
     *
     * @return void
     */
    public function test_cannot_delete_user_if_user_is_not_logged_in(): void
    {
        $user = $this->user();

        $this->delete(route('admin.users.destroy', $user))->assertRedirect(
            route('login'),
        );
    }

    /**
     * Test that the admin user delete page is accessible if user has the permission
     *
     * @return void
     */
    public function test_can_delete_user_if_user_has_permission(): void
    {
        $user = $this->user();
        $user->givePermissionTo(
            Permission::findOrCreate('delete user'),
            Permission::findOrCreate('view admin dashboard'),
        );

        $this->actingAs($user)
            ->delete(route('admin.users.destroy', $user))
            ->assertRedirect(route('admin.users.index'))
            ->assertSessionHas('success', 'User deleted successfully.')
            ->assertSessionMissing('error');
    }

    /**
     * Test that the admin user delete page is not accessible if user does not have the permission
     *
     * @return void
     */
    public function test_cannot_delete_user_if_user_does_not_have_permission(): void
    {
        $user = $this->user();

        $this->actingAs($user)
            ->delete(route('admin.users.destroy', $user))
            ->assertForbidden();
    }
}
