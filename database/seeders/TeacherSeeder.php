<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class TeacherSeeder extends Seeder
{
    public function run()
    {
        $user = User::create([
            'name' => 'Ahmed Mohamed',
            'email' => 'ahmed@example.com',
            'password' => Hash::make('secret123'),
        ]);

        Teacher::create([
            'user_id' => $user->id,
            'name' => 'أحمد محمد',
            'phone' => '01012345678',
        ]);
    }
}
