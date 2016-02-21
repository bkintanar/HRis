<?php

/**
 * This file is part of the HRis Software package.
 *
 * HRis - Human Resource and Payroll System
 *
 * @link http://github.com/HB-Co/HRis
 */
use Illuminate\Database\Seeder;

class LocationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     *
     * @author Bertrand Kintanar
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
