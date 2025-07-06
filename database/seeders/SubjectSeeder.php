<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Subject;

class SubjectSeeder extends Seeder
{
    public function run()
    {
        $subjects = ['رياضيات', 'علوم', 'لغة عربية', 'لغة إنجليزية'];

        foreach ($subjects as $subject) {
            Subject::create(['name' => $subject]);
        }
    }
}
