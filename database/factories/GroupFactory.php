<?php

namespace Database\Factories;

use App\Models\Group;
use App\Models\Teacher;
use Illuminate\Database\Eloquent\Factories\Factory;

class GroupFactory extends Factory
{
    protected $model = Group::class;

    public function definition(): array
    {
        $arabicGroupNames = [
            'مجموعة النخبة',
            'مجموعة التفوق',
            'مجموعة الإبداع',
            'مجموعة الريادة',
            'مجموعة المستقبل',
            'مجموعة التميز',
            'مجموعة الأمل',
            'مجموعة الطموح',
            'مجموعة الإنجاز',
            'مجموعة الفجر الجديد',
        ];

        return [
            'teacher_id' => Teacher::factory(),
'name' => $this->faker->randomElement($arabicGroupNames),
        ];
    }
}
