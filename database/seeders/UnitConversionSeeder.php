<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\UnitConversion;

class UnitConversionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $conversions =[
            ['from_unit_id' => 2, 'to_unit_id' => 1 , 'multiplier' => 1000],
            ['from_unit_id' => 3, 'to_unit_id' => 1, 'multiplier' => 1000000],
            ['from_unit_id' => 4, 'to_unit_id' => 1, 'multiplier' => 1000000000],
            ['from_unit_id' => 3, 'to_unit_id' => 2, 'multiplier' => 1000],
            ['from_unit_id' => 4, 'to_unit_id' => 2, 'multiplier' => 1000000],
            ['from_unit_id' => 4, 'to_unit_id' => 3, 'multiplier' => 1000],
            ['from_unit_id' => 6, 'to_unit_id' => 5, 'multiplier' => 1000],
            ['from_unit_id' => 7, 'to_unit_id' => 5, 'multiplier' => 1000000],
            ['from_unit_id' => 7, 'to_unit_id' => 6, 'multiplier' => 1000] 
        ];

        foreach($conversions as $conversion){
            UnitConversion::updateOrCreate([
                'from_unit_id' => $conversion['from_unit_id'],
                'to_unit_id' => $conversion['to_unit_id'],
                'multiplier' => $conversion['multiplier']
            ]);
        }

    }
}
