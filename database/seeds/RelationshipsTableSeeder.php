<?php

/**
 * This file is part of the HRis Software package.
 *
 * HRis - Human Resource and Payroll System
 *
 * @link    http://github.com/HB-Co/HRis
 *
 */

use Illuminate\Database\Seeder;

class RelationshipsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     * @author Bertrand Kintanar
     */
    public function run()
    {
        DB::table('relationships')->delete();

        DB::table('relationships')->insert(
            [
                ['id' => 1, 'name' => 'Father'],
                ['id' => 2, 'name' => 'Mother'],
                ['id' => 3, 'name' => 'Brother'],
                ['id' => 4, 'name' => 'Sister'],
                ['id' => 5, 'name' => 'Spouse'],
                ['id' => 6, 'name' => 'Child'],
                ['id' => 7, 'name' => 'Grandfather'],
                ['id' => 8, 'name' => 'Grandmother'],
                ['id' => 10, 'name' => 'Other'],
            ]
        );
    }
}
