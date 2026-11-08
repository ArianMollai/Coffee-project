<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'first_name' => 'arian',
            'last_name' => 'mollai',
            'email' => 'arian@gmail.com',
            'password' => bcrypt('123456789a'),
            'level' => 'creator',
            'phone_number' => '09225546827'
        ]);
    }
}
