<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Teacher;
use App\Models\Student;
use App\Models\Group;
use App\Models\Appointment;
use App\Models\SchoolGrade;
use App\Models\GradeTeacher;
use App\Models\Subject;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            ParentSeeder::class,
            TeacherSeeder::class,
            StudentSeeder::class,
            GroupSeeder::class,
            AppointmentSeeder::class,
            GroupStudentSeeder::class,
            GradeSeeder::class,
        ]);
        $this->call(SubjectSeeder::class);

Student::factory()->count(20)->create();

        // ربط المعلم بأحد الفصول الدراسية
        $someTeacherId = Teacher::inRandomOrder()->first()->id;
        $someGradeId = \App\Models\Grade::inRandomOrder()->first()->id;

        GradeTeacher::factory()->create([
            'teacher_id' => $someTeacherId,
            'grade_id' => $someGradeId,
        ]);

        // ربط المعلم ببعض المواد الدراسية
        $teacher = Teacher::inRandomOrder()->first();
        $subjects = Subject::inRandomOrder()->limit(3)->pluck('id');
        $teacher->subjects()->sync($subjects);  // تأكد إن العلاقة موجودة في موديل Teacher
    }
}
