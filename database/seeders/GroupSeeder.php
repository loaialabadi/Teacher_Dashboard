<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Teacher;
use App\Models\SchoolGrade;
use App\Models\Group;

class GroupSeeder extends Seeder
{
    public function run(): void
    {
        $teachers = Teacher::all();
        $classes = SchoolGrade::all();

        if ($teachers->isEmpty() || $classes->isEmpty()) {
            $this->command->error("تأكد من وجود مدرسين وفصول دراسية قبل إنشاء المجموعات.");
            return;
        }

        foreach (range(1, 10) as $i) {
            Group::create([
                'name' => 'مجموعة ' . $i,
                'teacher_id' => $teachers->random()->id,
'class_id' => $classes->random()->id,

            ]);
        }
    }
}
