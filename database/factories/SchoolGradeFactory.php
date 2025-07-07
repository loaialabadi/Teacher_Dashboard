<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\SchoolGrade;  // أو Grade حسب اسم الموديل الصحيح

class SchoolGradeFactory extends Factory
{
    protected $model = SchoolGrade::class;  // تأكد من اسم الموديل الصحيح

    public function definition()
    {
        return [
            'name' => 'الفصل ' . $this->faker->unique()->numberBetween(1, 20),
        ];
    }
}
