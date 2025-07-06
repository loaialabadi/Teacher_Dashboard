<?php

namespace Database\Factories;

use App\Models\Student;
use App\Models\ParentModel;
use Illuminate\Database\Eloquent\Factories\Factory;

class StudentFactory extends Factory
{
    protected $model = Student::class;

    public function definition(): array
    {
        return [
            'parent_id' => ParentModel::factory(),
            'name' => $this->faker->name,
            'phone' => $this->faker->phoneNumber,
        ];
    }
}
