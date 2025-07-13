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
            $this->command->error("تأكد من وجود مجموعات ومدرسين قبل إضافة المحاضرات.");
            return;
        }

        Lecture::factory(10)->make()->each(function ($lecture) use ($groups, $teachers) {
            // اختر مجموعة واحدة عشوائياً
            $group = $groups->random();

            // اختر مدرس عشوائي
            $teacher = $teachers->random();

            // عيّن القيم من نفس المجموعة والمدرس
            $lecture->group_id = $group->id;
            $lecture->teacher_id = $teacher->id;
            $lecture->subject_id = $group->subject_id; // تأكد أن subject_id موجود في جدول groups

            // تحقق من وجود subject_id لمنع الخطأ
            if (!$lecture->subject_id) {
                $this->command->error("المجموعة #{$group->id} لا تحتوي على subject_id. تخطّي هذه المحاضرة.");
                return; // تخطى هذه الدورة من foreach ولا تضفها
            }

            $lecture->save();

            $this->command->info("تم إنشاء محاضرة للمجموعة #{$lecture->group_id} مع مدرس #{$lecture->teacher_id}");
        });
    }
}
