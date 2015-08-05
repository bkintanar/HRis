<?php

use Illuminate\Database\Seeder;

class LocationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('locations')->delete();

        DB::table('locations')->insert(
            [
                ['id' => 1, 'name' => 'Unit 203'],
                ['id' => 2, 'name' => 'Unit 606'],
            ]
        );
    }
}
