<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Teacher;
use App\Models\Student;
use App\Models\Group;
use App\Models\Appointment;
use App\Models\SchoolClass;
use App\Models\ClassTeacher;
class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
    $this->call([
        SchoolClassSeeder::class,
        ParentSeeder::class,
        TeacherSeeder::class,
        StudentSeeder::class,
        GroupSeeder::class,
        AppointmentSeeder::class,
                     GroupStudentSeeder::class,


    ]);
         ClassTeacher::factory()->count(10)->create();


}}
