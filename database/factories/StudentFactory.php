<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Student>
 */
class StudentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
                      'name' => $this->faker->name,
            'phone' => $this->faker->unique()->phoneNumber,
            // سيتم ملؤها في Seeder:
            'parent_id' => 1,
            'teacher_id' => 1,
            'class_id' => 1,
        ];
    }
}
