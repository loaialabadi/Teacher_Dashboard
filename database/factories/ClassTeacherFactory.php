<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Teacher;
use App\Models\SchoolClass;

class ClassTeacherFactory extends Factory
{
    protected $model = \App\Models\ClassTeacher::class;

    public function definition()
    {
        return [
            'teacher_id' => Teacher::inRandomOrder()->first()->id,
            'school_class_id' => SchoolClass::inRandomOrder()->first()->id,
        ];
    }
}
