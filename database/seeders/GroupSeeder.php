<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Group;
use App\Models\Teacher;

class GroupSeeder extends Seeder
{
    public function run()
    {
        $teacher = Teacher::first();

        Group::create([
            'teacher_id' => $teacher->id,
            'name' => 'المجموعة الأولى',
            'grade_id' => null, // ضع الرقم المناسب إذا عندك جدول للفصول الدراسية
        ]);
    }
}
