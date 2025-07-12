<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Lecture;
use App\Models\Group;
use App\Models\Teacher;

class LectureSeeder extends Seeder
{
    public function run()
    {
        $groups = Group::all();
        $teachers = Teacher::all();

        if ($groups->isEmpty() || $teachers->isEmpty()) {
            $this->command->error("تأكد من وجود مجموعات ومدرسين قبل إضافة المواعيد.");
            return;
        }

        Lecture::factory(10)->make()->each(function ($Lecture) use ($groups, $teachers) {
            $Lecture->group_id = $groups->random()->id;
            $Lecture->teacher_id = $teachers->random()->id;
            $Lecture->save();

            $this->command->info("تم إنشاء موعد لمجموعة #{$Lecture->group_id} مع مدرس #{$Lecture->teacher_id} بتاريخ {$Lecture->date}");
        });
    }
}
