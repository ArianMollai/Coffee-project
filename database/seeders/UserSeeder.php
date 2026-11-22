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
        User::updateOrCreate(
            ['email' => env('CREATOR_EMAIL')],
            [
                'first_name' => env('CREATOR_FIRST_NAME'),
                'last_name' => env('CREATOR_LAST_NAME'),
                'password' => bcrypt(env('CREATOR_PASSWORD')),
                'level' => 'creator',
                'phone_number' => env('CREATOR_PHONE_NUMBER')
            ]
        );
    }
}
