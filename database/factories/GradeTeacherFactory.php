<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Teacher;
use App\Models\Grade;
use App\Models\SchoolGrade;
class GradeTeacherFactory extends Factory
{
    protected $model = \App\Models\GradeTeacher::class;

    public function definition()
    {
        return [
            'teacher_id' => Teacher::inRandomOrder()->first()->id,

'school_grade_id' => SchoolGrade::inRandomOrder()->first()->id,

        ];
    }
}
