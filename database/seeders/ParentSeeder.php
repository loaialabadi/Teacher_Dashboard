<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ParentModel;  // إذا اسم الموديل Parents أو ParentModel
use Illuminate\Support\Facades\Hash;

class ParentSeeder extends Seeder
{
    public function run()
    {
        ParentModel::create([
            'name' => 'Mohamed Ali',
            'phone' => '0123456789',
            'password' => Hash::make('parentpass'),
        ]);
    }
}
