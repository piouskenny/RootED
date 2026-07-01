<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $instructors = \App\Models\User::where('role', 'instructor')->get();

        if ($instructors->isEmpty()) {
            return;
        }

        $dummyCourses = [
            [
                'title' => 'Yoruba Oral Literature & Modern Storytelling',
                'tag' => 'yoruba',
                'langs' => ['EN', 'YO'],
                'modules_count' => 4,
                'students_count' => 247,
                'culture_items' => ['yoruba' => 64],
                'avg_completion' => 70,
                'status' => 'Published',
            ],
            [
                'title' => 'Cassava-to-Market: Smallholder Agriculture',
                'tag' => 'hausa',
                'langs' => ['EN', 'HA'],
                'modules_count' => 3,
                'students_count' => 412,
                'culture_items' => ['hausa' => 48],
                'avg_completion' => 65,
                'status' => 'Published',
            ],
            [
                'title' => 'Introduction to Web Development',
                'tag' => 'universal',
                'langs' => ['EN', 'IG'],
                'modules_count' => 4,
                'students_count' => 1184,
                'culture_items' => ['igbo' => 32, 'universal' => 18],
                'avg_completion' => 60,
                'status' => 'Draft',
            ],
            [
                'title' => 'Pan-African Business Ethics',
                'tag' => 'panafrican',
                'langs' => ['EN'],
                'modules_count' => 3,
                'students_count' => 318,
                'culture_items' => ['panafrican' => 22],
                'avg_completion' => 62,
                'status' => 'Draft',
            ],
        ];

        foreach ($instructors as $instructor) {
            foreach ($dummyCourses as $course) {
                \App\Models\Course::firstOrCreate(
                    [
                        'instructor_id' => $instructor->id,
                        'title' => $course['title'],
                    ],
                    $course
                );
            }
        }
    }
}
