<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Grade;
use App\Models\Student;
use App\Models\ParentModel;
use App\Models\Teacher;
use App\Models\Subject;

class StudentSeeder extends Seeder
{
    public function run(): void
    {
        $parents  = ParentModel::all();
        $teachers = Teacher::all();
        $grades   = Grade::all();

        // تحقق من وجود بيانات أساسية قبل التشغيل
        if ($parents->isEmpty() || $teachers->isEmpty() || $grades->isEmpty()) {
            $this->command->error('❌ تأكد من وجود بيانات في جداول: الآباء، المدرسين، والفصول الدراسية قبل تشغيل Seeder الطلاب.');
            return;
        }

        // طباعة للتوضيح
        $this->command->info('📚 الفصول الدراسية: ' . $grades->pluck('id')->implode(', '));
        $this->command->info('👨‍👩‍👧‍👦 الآباء: ' . $parents->pluck('id')->implode(', '));
        $this->command->info('👨‍🏫 المدرسون: ' . $teachers->pluck('id')->implode(', '));

        // إنشاء 10 طلاب مع ربطهم
        Student::factory(100)->create()->each(function (Student $student) use ($parents, $teachers, $grades) {
            // تحديث بيانات الطالب: ولي أمر + فصل دراسي
            $student->update([
                'parent_id' => $parents->random()->id,
                'grade_id'  => $grades->random()->id,
            ]);

            // اختيار 1 لـ 3 مدرسين عشوائيًا
            $randomTeachers = $teachers->random(rand(1, 3));

            $randomTeachers->each(function (Teacher $teacher) use ($student, $grades) {
                $randomSubject = Subject::inRandomOrder()->first();
                $randomGrade   = $grades->random();

                if ($randomSubject && $randomGrade) {
                    $student->teachers()->attach($teacher->id, [
                        'subject_id' => $randomSubject->id,
                        'grade_id'   => $randomGrade->id,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            });

            $teacherNames = $randomTeachers->pluck('name')->implode(', ');
            $this->command->info("✅ الطالب {$student->name} تم ربطه بالمدرسين: {$teacherNames}");
        });

        $this->command->info('🎉 تم إنشاء وربط الطلاب بنجاح.');
    }
}
