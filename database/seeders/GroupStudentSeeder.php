<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Group;
use App\Models\Student;

class GroupStudentSeeder extends Seeder
{
    public function run(): void
    {
        $groups = Group::all();
        $students = Student::all();

        if ($groups->isEmpty() || $students->isEmpty()) {
            $this->command->error('لا توجد مجموعات أو طلاب.');
            return;
        }

        foreach ($students as $student) {
            // اربط كل طالب بـ 1 إلى 3 مجموعات عشوائية (أو حسب رغبتك)
            $randomGroups = $groups->random(rand(1, 3))->pluck('id')->toArray();

            // ربط الطالب بالمجموعات
            $student->groups()->syncWithoutDetaching($randomGroups);
        }
    }
}
