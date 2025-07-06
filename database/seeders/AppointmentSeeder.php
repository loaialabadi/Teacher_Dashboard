<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Appointment;
use App\Models\Group;

class AppointmentSeeder extends Seeder
{
    public function run()
    {
        $group = Group::first();

        Appointment::create([
            'group_id' => $group->id,
                'teacher_id' => 1,  // مثال: معرف المعلم

            'start_time' => now()->addDays(1)->setTime(9, 0),
            'end_time' => now()->addDays(1)->setTime(10, 0),
            'subject' => 'رياضيات',
        ]);
    }
}
