<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Teacher;
use App\Models\Student;
use App\Models\Group;
use App\Models\Appointment;
use App\Models\SchoolClass;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $classes = SchoolClass::all(); // جلب الفصول الدراسية

        // أنشئ 5 معلمين مع مجموعاتهم ومواعيدهم
        Teacher::factory(5)->create()->each(function ($teacher) use ($classes) {
            // لكل معلم، أنشئ 5 مجموعات
            $groups = Group::factory(5)->create([
                'teacher_id' => $teacher->id,
                'class_id'   => $classes->random()->id, // ربط المجموعة بفصل عشوائي
            ]);

            $groups->each(function ($group) {
                // لكل مجموعة، أنشئ 4 مواعيد
                Appointment::factory(4)->create([
                    'group_id' => $group->id,
                ]);
            });

            // لكل معلم، أنشئ 10 طلاب مرتبطين به
            Student::factory(10)->create([
                'teacher_id' => $teacher->id,
                'class_id'   => $classes->random()->id, // ✅ ربط الطالب بفصل عشوائي
            ])->each(function ($student) use ($groups) {
                // ربط كل طالب بمجموعتين كحد أقصى
                $studentGroups = $groups->random(rand(1, 2));
                $student->groups()->attach(
                    is_iterable($studentGroups) ? $studentGroups->pluck('id')->toArray() : [$studentGroups->id]
                );
            });
        });
    }
}
