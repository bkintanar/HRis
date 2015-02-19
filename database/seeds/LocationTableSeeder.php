<?php

use HRis\Location;
use Illuminate\Database\Seeder;

class LocationTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('locations')->truncate();

        DB::table('locations')->insert(
            [
                ['id' => 0, 'name' => '--- Select ---'],
                ['id' => 1, 'name' => 'Unit 203'],
                ['id' => 2, 'name' => 'Unit 606'],
            ]
        );

        $location = Location::whereName('--- Select ---')->first();
        $location->id = 0;
        $location->save();
    }
}