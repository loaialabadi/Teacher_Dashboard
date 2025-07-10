<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Teacher;
use App\Models\Group;
use App\Models\Grade; // تأكد من استيراد الموديل المناسب

class GroupSeeder extends Seeder
{
    public function run(): void
    {
        $teachers = Teacher::all();
        $grades = Grade::all();

        if ($teachers->isEmpty() || $grades->isEmpty()) {
            $this->command->error("تأكد من وجود مدرسين وفصول دراسية قبل إنشاء المجموعات.");
            return;
        }

        foreach (range(1, 10) as $i) {
            Group::create([
                'name' => 'مجموعة ' . $i,
                'teacher_id' => $teachers->random()->id,
'grade_id' => $grades->random()->id,

            ]);
        }
    }
}
