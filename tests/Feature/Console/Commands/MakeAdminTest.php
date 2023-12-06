<?php

namespace Tests\Feature\Console\Commands;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MakeAdminTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_can_make_admin_user_even_if_user_does_not_exist(): void
    {
        $this->artisan('make:admin')
            ->expectsQuestion(
                'What is the email of the user you want to make admin?',
                'admin@example.com',
            )
            ->expectsQuestion('What is their name?', 'Admin')
            ->expectsQuestion(
                'What is the password of the user you want to make admin?',
                'password',
            )
            ->expectsQuestion(
                'Please confirm the password of the user you want to make admin?',
                'password',
            )
            ->expectsOutput(
                'User admin@example.com now has full access to your site.',
            )
            ->assertExitCode(0);

        $this->assertDatabaseHas('users', [
            'email' => 'admin@example.com',
        ]);

        $this->assertContains(
            'super admin',
            User::where('email', 'admin@example.com')
                ->first()
                ->roles->pluck('name'),
        );
    }

    public function test_can_make_admin_if_user_exists(): void
    {
        $user = User::factory()->create();

        $this->artisan('make:admin')
            ->expectsQuestion(
                'What is the email of the user you want to make admin?',
                $user->email,
            )
            ->expectsOutput(
                'User ' . $user->email . ' now has full access to your site.',
            );
    }
}
