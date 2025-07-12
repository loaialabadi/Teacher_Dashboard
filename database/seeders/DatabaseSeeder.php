<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ParentModel;
use App\Models\Teacher;
use App\Models\Grade;
use App\Models\Student;
use App\Models\Group;
use App\Models\Lecture;
use App\Models\Subject;
use App\Models\GradeTeacher;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. ننشئ أولاً بيانات الآباء
        $this->call([
            ParentSeeder::class,
        ]);

        // 2. ننشئ بيانات المعلمين
        $this->call([
            TeacherSeeder::class,
        ]);

        // 3. ننشئ بيانات الفصول الدراسية (Grades)
        $this->call([
            GradeSeeder::class,
        ]);

                $this->call([
            SubjectSeeder::class,
        ]);
        // 4. ننشئ بيانات الطلاب مع الربط بالآباء والمعلمين والفصول
        $this->call([
            StudentSeeder::class,
        ]);

        // 5. ننشئ بيانات المجموعات المرتبطة بالمعلمين والطلاب
        $this->call([
            GroupSeeder::class,
            GroupStudentSeeder::class,
        ]);

        // 6. ننشئ بيانات المواعيد (Lectures)
        $this->call([
            LectureSeeder::class,
        ]);

        // 7. ننشئ بيانات المواد الدراسية


        $this->call(StudentTeacherSeeder::class);

        // 8. ربط المعلم مع فصل معين (GradeTeacher)
        $someTeacherId = Teacher::inRandomOrder()->first()->id;
        $someGradeId = Grade::inRandomOrder()->first()->id;

        GradeTeacher::factory()->create([
            'teacher_id' => $someTeacherId,
            'grade_id' => $someGradeId,
        ]);

        // 9. ربط المعلم ببعض المواد الدراسية عشوائياً
        $teacher = Teacher::inRandomOrder()->first();
        $subjects = Subject::inRandomOrder()->limit(3)->pluck('id');
        $teacher->subjects()->sync($subjects);  // تأكد أن العلاقة موجودة في موديل Teacher

$student = Student::inRandomOrder()->first();

        $randomSubjects = Subject::all()->random(rand(1, 3));
if ($student) {
    $randomSubjects = Subject::all()->random(rand(1, 3));
    $student->subjects()->attach($randomSubjects->pluck('id'));
}
    }
}
