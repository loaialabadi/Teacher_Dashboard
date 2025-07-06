<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SchoolClass;
use Illuminate\Support\Facades\DB;

class SchoolClassSeeder extends Seeder
{
    public function run(): void
    {
        // حذف البيانات دون كسر علاقات Foreign Key
        SchoolClass::query()->delete();
        DB::statement('ALTER TABLE school_classes AUTO_INCREMENT = 1');

        $classes = [
            'الفصل الأول',
            'الفصل الثاني',
            'الفصل الثالث',
            'الفصل الرابع',
            'الفصل الخامس'
        ];

        foreach ($classes as $name) {
            SchoolClass::create(['name' => $name]);
        }
    }
}
