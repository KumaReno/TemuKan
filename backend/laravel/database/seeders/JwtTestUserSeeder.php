<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class JwtTestUserSeeder extends Seeder
{
    public function run(): void
    {
        if (! app()->environment('local')) {
            return;
        }

        $email = config('jwt.test_user.email');
        $password = config('jwt.test_user.password');

        if (! is_string($email) || $email === '' || ! is_string($password) || $password === '') {
            $this->command?->warn('JWT test user skipped: set JWT_TEST_USER_EMAIL and JWT_TEST_USER_PASSWORD in .env.');

            return;
        }

        User::query()->updateOrCreate(
            ['email' => $email],
            [
                'name' => 'TemuKan API Tester',
                'password' => $password,
            ]
        );

        $this->command?->info('Local JWT test user is ready.');
    }
}
