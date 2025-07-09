<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Grade;

class GradeSeeder extends Seeder
{
    public function run()
    {
        $grades = [
            'الأول الابتدائي',
            'الثاني الابتدائي',
            'الثالث الابتدائي',
            'الرابع الابتدائي',
            'الخامس الابتدائي',
            'السادس الابتدائي',
            'الأول الإعدادي',
            'الثاني الإعدادي',
            'الثالث الإعدادي',
            'الأول الثانوي',
            'الثاني الثانوي',
            'الثالث الثانوي',
        ];

        foreach ($grades as $gradeName) {
            Grade::firstOrCreate(['name' => $gradeName]);
        }
    }
}
