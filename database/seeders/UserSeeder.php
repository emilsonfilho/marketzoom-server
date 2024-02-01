<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'user_type_id' => 1,
            'name' => 'Administrator',
            'username' => 'admin',
            'email' => 'admin@email.com',
            'password' => 'admin',
        ]);
    }
}
