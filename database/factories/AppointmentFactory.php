<?php

namespace Database\Factories;

use App\Models\Appointment;
use App\Models\Group;
use Illuminate\Database\Eloquent\Factories\Factory;

class AppointmentFactory extends Factory
{
    protected $model = Appointment::class;

    public function definition()
    {
        // ننشئ مجموعة أولاً (تتضمن teacher_id)
        $group = Group::factory()->create();

        return [
            'group_id' => $group->id,
            'teacher_id' => $group->teacher_id, // نأخذ teacher_id من المجموعة
            'start_time' => $this->faker->dateTimeBetween('now', '+1 month'),
            'end_time' => $this->faker->dateTimeBetween('+1 month', '+2 months'),
        ];
    }
}
