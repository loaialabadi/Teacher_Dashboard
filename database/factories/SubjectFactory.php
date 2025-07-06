<?php

namespace Database\Factories;

use App\Models\Subject;
use Illuminate\Database\Eloquent\Factories\Factory;

class SubjectFactory extends Factory
{
    protected $model = Subject::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->unique()->randomElement([
                'الرياضيات',
                'اللغة العربية',
                'العلوم',
                'اللغة الإنجليزية',
                'الدراسات الاجتماعية',
                'الحاسب الآلي',
                'التربية الدينية',
            ]),
        ];
    }
}
