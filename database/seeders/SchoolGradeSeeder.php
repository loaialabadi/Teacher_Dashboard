<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SchoolGrade;
use Illuminate\Support\Facades\DB;

class SchoolGradeSeeder extends Seeder
{
    public function run(): void
    {
        // حذف البيانات دون كسر علاقات Foreign Key
        SchoolGrade::query()->delete();
        DB::statement('ALTER TABLE school_grades AUTO_INCREMENT = 1');

        $grades = [
            'المرحلة الأولى',
            'المرحلة الثانية',
            'المرحلة الثالثة',
            'المرحلة الرابعة',
            'المرحلة الخامسة'
        ];

        foreach ($grades as $name) {
            SchoolGrade::create(['name' => $name]);
        }
    }
}
