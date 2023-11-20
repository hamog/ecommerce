<?php

namespace App\Console\Commands;

use App\Actions\Fortify\PasswordValidationRules;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Spatie\Permission\Models\Role;

class MakeAdmin extends Command
{
    use PasswordValidationRules;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:admin';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a user with super admin access';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $user = $this->getUserInfo();

        if (!$user) {
            return 0;
        }

        $this->assignRole($user);

        $this->info(
            'User ' . $user->email . ' now has full access to your site.',
        );

        return 1;
    }

    /**
     * Get the user information from the user.
     *
     * @return bool|User
     * @throws ValidationException
     */
    public function getUserInfo(): bool|User
    {
        $email = $this->ask(
            'What is the email of the user you want to make admin?',
        );

        $user = User::where('email', $email)->first();

        if (!is_null($user)) {
            return $user;
        }

        $name = $this->ask('What is their name?');
        $password = $this->secret(
            'What is the password of the user you want to make admin?',
        );

        $passwordConfirmation = $this->secret(
            'Please confirm the password of the user you want to make admin?',
        );

        $validator = Validator::make(
            [
                'name' => $name,
                'email' => $email,
                'password' => $password,
                'password_confirmation' => $passwordConfirmation,
            ],
            [
                'name' => ['required', 'string', 'max:255'],
                'email' => [
                    'required',
                    'string',
                    'email',
                    'max:255',
                    'unique:users',
                ],
                'password' => $this->passwordRules(),
            ],
        );

        if ($validator->fails()) {
            $this->error('Operation failed. Please check errors below:');

            foreach ($validator->errors()->all() as $error) {
                $this->error($error);
            }

            return false;
        }

        return User::create([
            ...$validator->validated(),
            'password' => Hash::make($password),
        ]);
    }

    public function assignRole(User $user): void
    {
        $role = Role::findOrCreate('super admin');
        $user->assignRole($role);
    }
}
