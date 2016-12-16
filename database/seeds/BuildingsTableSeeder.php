<?php

use Illuminate\Database\Seeder;

class BuildingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('buildings')->insert([
            'type' => 'castle',
            'name' => 'Castle',
            'updateable' => false,
            'position_x' => 3,
            'position_y' => 3
        ]);

        DB::table('buildings')->insert([
            'type' => 'farm',
            'name' => 'Farm',
            'wood_needed' => 400,
            'stone_needed' => 200,
            'time_required' => 90,
            'position_x' => 2,
            'position_y' => 4
        ]);

        DB::table('buildings')->insert([
            'type' => 'mine',
            'name' => 'Mine',
            'wood_needed' => 500,
            'stone_needed' => 100,
            'time_required' => 180,
            'position_x' => 4,
            'position_y' => 4
        ]);

        DB::table('buildings')->insert([
            'type' => 'wood',
            'name' => 'Wood Factory',
            'wood_needed' => 150,
            'stone_needed' => 0,
            'time_required' => 70,
            'position_x' => 2,
            'position_y' => 2
        ]);

        DB::table('buildings')->insert([
            'type' => 'stone',
            'name' => 'Stone Factory',
            'wood_needed' => 300,
            'stone_needed' => 100,
            'time_required' => 90,
            'position_x' => 4,
            'position_y' => 2
        ]);

        DB::table('buildings')->insert([
            'type' => 'fortress',
            'name' => 'Barracks',
            'wood_needed' => 150,
            'stone_needed' => 300,
            'time_required' => 170,
            'position_x' => 5,
            'position_y' => 3
        ]);

        DB::table('buildings')->insert([
            'type' => 'tower',
            'name' => 'Tower',
            'wood_needed' => 50,
            'stone_needed' => 400,
            'time_required' => 210,
            'position_x' => 1,
            'position_y' => 3
        ]);
    }
}
