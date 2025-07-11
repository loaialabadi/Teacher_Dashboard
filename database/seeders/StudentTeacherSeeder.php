<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\Subject;
use App\Models\Grade;

class StudentTeacherSeeder extends Seeder
{
    public function run(): void
    {
        $students = Student::all();
        $teachers = Teacher::all();

        foreach ($students as $student) {
            $randomTeachers = $teachers->random(rand(1, 3));
            foreach ($randomTeachers as $teacher) {
                $subject = Subject::inRandomOrder()->first();
                $grade = Grade::inRandomOrder()->first();

                $student->teachers()->syncWithoutDetaching([
                    $teacher->id => [
                        'subject_id' => $subject->id,
                        'grade_id'   => $grade->id,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]
                ]);
            }
        }
    }
}
