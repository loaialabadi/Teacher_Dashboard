<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Teacher;
use App\Models\Grade;

class GradeTeacherFactory extends Factory
{
    protected $model = \App\Models\GradeTeacher::class;

    public function definition()
    {
        return [
            'teacher_id' => Teacher::inRandomOrder()->first()->id,
            'grade_id' => Grade::inRandomOrder()->first()->id,
        ];
    }
}
