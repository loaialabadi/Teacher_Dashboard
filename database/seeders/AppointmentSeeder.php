<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Appointment;
use App\Models\Group;
use App\Models\Teacher;

class AppointmentSeeder extends Seeder
{
    public function run()
    {
        $groups = Group::all();
        $teachers = Teacher::all();

        if ($groups->isEmpty() || $teachers->isEmpty()) {
            $this->command->error("تأكد من وجود مجموعات ومدرسين قبل إضافة المواعيد.");
            return;
        }

        Appointment::factory(10)->make()->each(function ($appointment) use ($groups, $teachers) {
            $appointment->group_id = $groups->random()->id;
            $appointment->teacher_id = $teachers->random()->id;
            $appointment->save();

            $this->command->info("تم إنشاء موعد لمجموعة #{$appointment->group_id} مع مدرس #{$appointment->teacher_id} بتاريخ {$appointment->date}");
        });
    }
}
