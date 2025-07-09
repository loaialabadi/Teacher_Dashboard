<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Grade;
class StudentSeeder extends Seeder
{
    public function run(): void
    {
        $parents = \App\Models\ParentModel::all();
        $teachers = \App\Models\Teacher::all();
        $grades = Grade::all();  // << غيرت هنا من $classId إلى $grades

        if ($parents->isEmpty() || $teachers->isEmpty() || $grades->isEmpty()) {
            $this->command->error('تأكد من وجود بيانات للآباء، المدرسين، والفصول قبل تشغيل Seeder الطلاب.');
            return;
        }

        $this->command->info('الفصول الموجودة: ' . $grades->pluck('id')->implode(', '));
        $this->command->info('الآباء الموجودون: ' . $parents->pluck('id')->implode(', '));
        $this->command->info('المدرسون الموجودون: ' . $teachers->pluck('id')->implode(', '));

        \App\Models\Student::factory(20)->make()->each(function ($student) use ($parents, $teachers, $grades) {
            
            // اختيار قيم عشوائية
            $student->parent_id = $parents->random()->id;
            $student->teacher_id = $teachers->random()->id;
            $student->class_id = $grades->random()->id;

            // تحقق من وجود القيم قبل الحفظ
            if (
                $parents->where('id', $student->parent_id)->count() > 0 &&
                $teachers->where('id', $student->teacher_id)->count() > 0 &&
                $grades->where('id', $student->class_id)->count() > 0
            ) {
                $this->command->info("إنشاء طالب مرتبط بالفصل {$student->class_id}");
                $student->save();
            } else {
                $this->command->error("خطأ: parent_id أو teacher_id أو class_id غير موجودة.");
            }
        });
    }
}
