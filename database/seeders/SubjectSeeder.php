<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SubjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
            $subjects = ['رياضيات', 'فيزياء', 'كيمياء', 'أحياء', 'لغة عربية'];

    foreach ($subjects as $name) {
        \App\Models\Subject::firstOrCreate(['name' => $name]);
    }}
}
