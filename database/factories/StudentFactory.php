<?php

namespace Database\Factories;

use App\Models\Student;
use App\Models\ParentModel;
use App\Models\Teacher;
use App\Models\Grade;
use Illuminate\Database\Eloquent\Factories\Factory;

class StudentFactory extends Factory
{
    protected $model = Student::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'phone' => '01' . $this->faker->numberBetween(100000000, 999999999),
            'parent_id' => ParentModel::inRandomOrder()->first()?->id ?? ParentModel::factory(),
            'grade_id' => Grade::inRandomOrder()->first()?->id ?? Grade::factory(),
        ];
    }
}
