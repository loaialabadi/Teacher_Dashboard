<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Teacher;
use App\Models\Student;
use App\Models\Group;
use App\Models\Appointment;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // أنشئ 5 معلمين مع مجموعاتهم ومواعيدهم
        Teacher::factory(5)->create()->each(function ($teacher) {
            // لكل معلم، أنشئ 3 مجموعات
            $groups = Group::factory(5)->create([
                'teacher_id' => $teacher->id,
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
            ])->each(function ($student) use ($groups) {
                // ربط كل طالب مع مجموعات مختلفة للمعلم (من 1 إلى 2 مجموعات)
                $studentGroups = $groups->random(rand(1, 2));
                $student->groups()->attach(
                    is_iterable($studentGroups) ? $studentGroups->pluck('id')->toArray() : [$studentGroups->id]
                );
            });
        });
    }
}
