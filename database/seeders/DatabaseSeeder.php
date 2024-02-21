<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        $defaultUser = \App\Models\User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        \App\Models\Administrator::create([
            'user_id' => $defaultUser->id,
        ]);

        $course_1 =  \App\Models\Course::create([
            'name' => 'Course 1',
            'duration' => '6 months',
            'description' => "This is the first course",
            'fee' => 1000,
        ]);

        \App\Models\Section::create([
            'name' => 'Section 1',
            'description' => "This is the first section",
            'start_date' => '04/01/2024',
            'end_date' => '10/01/2024',
            'course_id' => $course_1->id,
        ]);
        \App\Models\Section::create([
            'name' => 'Section 2',
            'description' => "This is the second section",
            'start_date' => '05/01/2024',
            'end_date' => '11/01/2024',
            'course_id' => $course_1->id,
        ]);

        $course_2 = \App\Models\Course::create([
            'name' => 'Course 2',
            'duration' => '2 months',
            'description' => "This is the second course",
            'fee' => 500,
        ]);

        \App\Models\Section::create([
            'name' => 'Section 3',
            'description' => "This is the third section",
            'start_date' => '04/01/2024',
            'end_date' => '6/01/2024',
            'course_id' => $course_2->id,
        ]);
        \App\Models\Section::create([
            'name' => 'Section 4',
            'description' => "This is the fourth section",
            'start_date' => '6/01/2024',
            'end_date' => '8/01/2024',
            'course_id' => $course_2->id,
        ]);

        $course_3 = \App\Models\Course::create([
            'name' => 'Course 3',
            'duration' => '3 months',
            'description' => "This is the third course",
            'fee' => 700,
        ]);

        \App\Models\Section::create([
            'name' => 'Section 5',
            'description' => "This is the fifth section",
            'start_date' => '04/01/2024',
            'end_date' => '7/01/2024',
            'course_id' => $course_3->id,
        ]);
        \App\Models\Section::create([
            'name' => 'Section 6',
            'description' => "This is the sixth section",
            'start_date' => '6/01/2024',
            'end_date' => '9/01/2024',
            'course_id' => $course_3->id,
        ]);
    }
}
