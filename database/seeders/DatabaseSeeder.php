<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create a demo instructor account
        User::firstOrCreate(
            ['email' => 'instructor@demo.com'],
            [
                'name'     => 'Demo Instructor',
                'password' => Hash::make('password'),
                'role'     => 'instructor',
                'email_verified_at' => now(),
            ]
        );

        // Create a demo learner account
        User::firstOrCreate(
            ['email' => 'learner@demo.com'],
            [
                'name'     => 'Demo Learner',
                'password' => Hash::make('password'),
                'role'     => 'learner',
                'email_verified_at' => now(),
            ]
        );

        $this->call(CourseSeeder::class);
    }
}
