<?php

namespace Tests;

use App\Models\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Spatie\Permission\Models\Role;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    /**
     * Create a super admin user.
     *
     * @return User
     */
    protected function superAdminUser(): User
    {
        $user = User::factory()->create();
        $user->assignRole(Role::findOrCreate('super admin'));

        return $user;
    }

    /**
     * Create a user.
     *
     * @return User
     */
    protected function user(): User
    {
        return User::factory()->create();
    }
}
