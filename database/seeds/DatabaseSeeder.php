<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(BuildingsTableSeeder::class);
        $this->call(UnitsTableSeeder::class);
    }
}
