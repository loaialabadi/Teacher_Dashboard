<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Grade;
use App\Models\Student;
use App\Models\ParentModel;
use App\Models\Teacher;

class StudentSeeder extends Seeder
{
    public function run(): void
    {
        $parents  = ParentModel::all();
        $teachers = Teacher::all();
        $grades   = Grade::all();

        if ($parents->isEmpty() || $teachers->isEmpty() || $grades->isEmpty()) {
            $this->command->error('❌ تأكد من وجود بيانات في جداول الآباء، المدرسين، والفصول الدراسية قبل تشغيل Seeder الطلاب.');
            return;
        }

        $this->command->info('📚 الفصول الدراسية: ' . $grades->pluck('id')->implode(', '));
        $this->command->info('👨‍👩‍👧‍👦 الآباء: ' . $parents->pluck('id')->implode(', '));
        $this->command->info('👨‍🏫 المدرسون: ' . $teachers->pluck('id')->implode(', '));

        // إنشاء 20 طالب مع الربط بالآباء، الفصول، المعلمين، والمواد
Student::factory(20)->create()->each(function ($student) use ($parents, $teachers, $grades) {
    $student->update([
        'parent_id' => $parents->random()->id,
        'grade_id'  => $grades->random()->id,
    ]);

    $randomTeachers = $teachers->random(rand(1, 3));
    $randomTeachers->each(function ($teacher) use ($student, $grades) {
        $randomSubject = \App\Models\Subject::inRandomOrder()->first();
        $randomGrade = $grades->random();  // هنا تم تعريف $randomGrade

        if ($randomSubject && $randomGrade) {
            $student->teachers()->attach($teacher->id, [
                'subject_id' => $randomSubject->id,
                'grade_id' => $randomGrade->id,  // نستخدم المتغير الآن بعد تعريفه
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    });

    $teacherNames = $randomTeachers->pluck('name')->implode(', ');
    $this->command->info("✅ الطالب {$student->name} تم ربطه بـ: {$teacherNames}");
});


        $this->command->info('🎉 تم إنشاء وربط الطلاب بنجاح.');
    }
}
