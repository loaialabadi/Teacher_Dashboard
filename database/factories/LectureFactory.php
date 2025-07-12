<?php

namespace Database\Factories;

use App\Models\Lecture;
use App\Models\Group;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class LectureFactory extends Factory
{
    protected $model = Lecture::class;

    public function definition(): array
    {
        $start = $this->faker->dateTimeBetween('-1 week', '+1 week');
        return [
            'group_id' => Group::inRandomOrder()->first()?->id ?? 1, // تأكد من وجود بيانات أو ضع رقم مجموعة موجود
            'title' => $this->faker->sentence(3),
            'description' => $this->faker->optional()->paragraph(),
            'start_time' => $start,
            'end_time' => Carbon::parse($start)->addHour(),
        ];
    }
}
