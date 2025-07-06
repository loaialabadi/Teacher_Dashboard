<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Student;
use App\Models\ParentModel;

class StudentSeeder extends Seeder
{
    public function run()
    {
        $parent = ParentModel::first();
$classId = \App\Models\SchoolClass::inRandomOrder()->first()->id;

        Student::create([
            'name' => 'Sara Ahmed',
            'phone' => '01122334455',
            'parent_id' => $parent->id,
                'class_id' => $classId, // ✅ الحل

        ]);
    }
}
