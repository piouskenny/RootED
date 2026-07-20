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
        // Create a demo admin account
        User::firstOrCreate(
            ['email' => 'rootedadmin@gmail.com'],
            [
                'name'     => 'Funmi Adesina',
                'password' => Hash::make('password123'),
                'role'     => 'admin',
                'email_verified_at' => now(),
            ]
        );

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

        // Create several mock learners to populate dashboard dynamically
        $names = [
            'Amina Bello', 'Kofi Mensah', 'Chioma Nwachukwu', 'Olumide Bakare', 
            'Fatoumata Diallo', 'Kwame Nkrumah', 'Ngozi Okonjo', 'Yemi Alade', 
            'Chinedu Ikedieze', 'Babajide Sanwo', 'Zainab Ibrahim', 'Tunde Folawiyo'
        ];
        foreach ($names as $index => $name) {
            User::firstOrCreate(
                ['email' => 'learner' . ($index + 1) . '@demo.com'],
                [
                    'name' => $name,
                    'password' => Hash::make('password'),
                    'role' => 'learner',
                    'email_verified_at' => now(),
                ]
            );
        }

        $this->call(CourseSeeder::class);

        // Dynamically enroll these learners in random courses
        $learners = User::where('role', 'learner')->get();
        $courses = \App\Models\Course::all();

        foreach ($learners as $learner) {
            // Enroll in 2 to 5 random courses
            $randomCourses = $courses->random(rand(2, 5));
            foreach ($randomCourses as $course) {
                $learner->enrolledCourses()->syncWithoutDetaching([
                    $course->id => [
                        'completed_contents' => json_encode([]),
                        'progress' => rand(10, 100),
                    ]
                ]);
            }
        }
    }
}
