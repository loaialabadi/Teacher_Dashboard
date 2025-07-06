<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\SchoolClass;

class SchoolClassFactory extends Factory
{
    protected $model = SchoolClass::class;

    public function definition()
    {
        return [
            'name' => 'الفصل ' . $this->faker->unique()->numberBetween(1, 20),
        ];
    }
}
