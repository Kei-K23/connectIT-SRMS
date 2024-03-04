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

        $defaultAdminUser = \App\Models\User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        $defaultInstructorUser = \App\Models\User::factory()->create([
            'name' => 'Jack',
            'email' => 'jack@example.com',
        ]);
        $defaultStudentUser = \App\Models\User::factory()->create([
            'name' => 'Kei',
            'email' => 'kei@example.com',
        ]);

        \App\Models\Administrator::create([
            'user_id' => $defaultAdminUser->id,
        ]);

        $course_1 =  \App\Models\Course::create([
            'name' => 'Course 1',
            'duration' => '6 months',
            'description' => "This is the first course",
            'fee' => 1000,
        ]);

        \App\Models\Subject::create([
            'name' => 'Cou-1:Sub-1',
            'description' => "This is the first subject",
            'start_time' => '10:00:00',
            'end_time' => '11:00:00',
            'course_id' => $course_1->id,
        ]);
        \App\Models\Subject::create([
            'name' => 'Cou-1:Sub-2',
            'description' => "This is the second subject",
            'start_time' => '11:00:00',
            'end_time' => '12:00:00',
            'course_id' => $course_1->id,
        ]);
        \App\Models\Subject::create([
            'name' => 'Cou-1:Sub-3',
            'description' => "This is the third subject",
            'start_time' => '12:00:00',
            'end_time' => '13:00:00',
            'course_id' => $course_1->id,
        ]);

        $section1 = \App\Models\Section::create([
            'name' => 'Section 1',
            'description' => "This is the first section",
            'start_date' => '04/01/2024',
            'end_date' => '10/01/2024',
            'course_id' => $course_1->id,
        ]);

        \App\Models\Instructor::create([
            'user_id' => $defaultInstructorUser->id,
            'section_id' => $section1->id,
        ]);
        \App\Models\Student::create([
            'user_id' => $defaultStudentUser->id,
            'section_id' => $section1->id,
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

        \App\Models\Subject::create([
            'name' => 'Cou-2:Sub-1',
            'description' => "This is the first subject",
            'start_time' => '8:00:00',
            'end_time' => '9:00:00',
            'course_id' => $course_2->id,
        ]);
        \App\Models\Subject::create([
            'name' => 'Cou-2:Sub-2',
            'description' => "This is the second subject",
            'start_time' => '10:00:00',
            'end_time' => '11:00:00',
            'course_id' => $course_2->id,
        ]);
        \App\Models\Subject::create([
            'name' => 'Cou-2:Sub-3',
            'description' => "This is the third subject",
            'start_time' => '12:00:00',
            'end_time' => '13:00:00',
            'course_id' => $course_2->id,
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

        \App\Models\Subject::create([
            'name' => 'Cou-3:Sub-1',
            'description' => "This is the first subject",
            'start_time' => '14:00:00',
            'end_time' => '15:00:00',
            'course_id' => $course_3->id,
        ]);
        \App\Models\Subject::create([
            'name' => 'Cou-3:Sub-2',
            'description' => "This is the second subject",
            'start_time' => '15:00:00',
            'end_time' => '16:00:00',
            'course_id' => $course_3->id,
        ]);
        \App\Models\Subject::create([
            'name' => 'Cou-3:Sub-3',
            'description' => "This is the third subject",
            'start_time' => '16:00:00',
            'end_time' => '17:00:00',
            'course_id' => $course_3->id,
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
