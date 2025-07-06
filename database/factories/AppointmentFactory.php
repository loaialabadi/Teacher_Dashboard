<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Appointment>
 */
class AppointmentFactory extends Factory
{
    public function definition()
    {
        // تاريخ عشوائي خلال الشهر القادم
        $date = $this->faker->dateTimeBetween('now', '+1 month');

        // وقت بداية عشوائي في نفس يوم التاريخ
        $start_time = $this->faker->dateTimeBetween($date->format('Y-m-d 08:00:00'), $date->format('Y-m-d 16:00:00'));

        // وقت نهاية بعد ساعة إلى 3 ساعات من وقت البداية
        $end_time = (clone $start_time)->modify('+'.rand(1,3).' hours');

        return [
            'group_id' => 1,  // سيتم تعديلها في Seeder أو اختبارك الخاص
            'teacher_id' => 1, // سيتم تعديلها في Seeder أو اختبارك الخاص
            'date' => $date->format('Y-m-d'),
            'start_time' => $start_time->format('Y-m-d H:i:s'),
            'end_time' => $end_time->format('Y-m-d H:i:s'),
            'subject' => $this->faker->word(),
            'description' => $this->faker->sentence(),
        ];
    }
}
