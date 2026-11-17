<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Unit;

class UnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $units = [
            ['id' => 1, 'name' => 'mili gram', 'abbreviation' => 'mg'],
            ['id' => 2, 'name' => 'gram', 'abbreviation' => 'g'],
            ['id' => 3, 'name' => 'kilo-gram', 'abbreviation' => 'kg'],
            ['id' => 4, 'name' => 'ton', 'abbreviation' => 't'],
            ['id' => 5, 'name' => 'mili-liter', 'abbreviation' => 'ml'],
            ['id' => 6, 'name' => 'liter', 'abbreviation' => 'l'],
            ['id' => 7, 'name' => 'galon', 'abbreviation' => 'g']
        ];

        foreach($units as $unit){
            Unit::updateOrCreate(
                ['id' => $unit['id']],
                [
                    'name' => $unit['name'],
                    'abbreviation' => $unit['abbreviation']
                ]
            );
        }
    }
}
