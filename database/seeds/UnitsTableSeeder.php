<?php

use Illuminate\Database\Seeder;

class UnitsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('units')->insert([
            'type' => 'archer',
            'name' => 'Archer',
            'attack' => 100,
            'defence' => 80,
            'health' => 120,
            'required_gold' => 60,
            'required_food' => 30,
            'required_time' => 60,
            'building_level' => 1
        ]);

        DB::table('units')->insert([
            'type' => 'swordsman',
            'name' => 'Swordsman',
            'attack' => 180,
            'defence' => 120,
            'health' => 160,
            'required_gold' => 80,
            'required_food' => 40,
            'required_time' => 80,
            'building_level' => 3
        ]);

        DB::table('units')->insert([
            'type' => 'knight',
            'name' => 'Knight',
            'attack' => 260,
            'defence' => 160,
            'health' => 210,
            'required_gold' => 120,
            'required_food' => 40,
            'required_time' => 150,
            'building_level' => 5
        ]);
    }
}
