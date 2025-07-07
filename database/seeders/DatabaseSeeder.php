<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Teacher;
use App\Models\Student;
use App\Models\Group;
use App\Models\Appointment;
use App\Models\SchoolGrade;
use App\Models\ClassTeacher;
use App\Models\GradeTeacher;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
    $this->call([
       SchoolGradeSeeder::class,

        ParentSeeder::class,
        TeacherSeeder::class,
        StudentSeeder::class,
        GroupSeeder::class,
        AppointmentSeeder::class,
                     GroupStudentSeeder::class,


    ]);
$someTeacherId = \App\Models\Teacher::inRandomOrder()->first()->id;
$someGradeId = \App\Models\SchoolGrade::inRandomOrder()->first()->id;

GradeTeacher::factory()->create([
    'teacher_id' => $someTeacherId,
    'school_grade_id' => $someGradeId,
]);



}}
