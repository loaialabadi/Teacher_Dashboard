<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\SchoolGrade;
use App\Models\Teacher;
class TeacherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Teacher::factory(5)->create();

            Teacher::factory(5)->create()->each(function ($teacher) {
        // أنشئ 2 فصل دراسي لكل معلم
     
    });

    }
}
