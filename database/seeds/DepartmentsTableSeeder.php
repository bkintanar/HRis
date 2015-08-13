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

class DepartmentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     * @author Bertrand Kintanar
     */
    public function run()
    {
        DB::table('departments')->delete();

        DB::table('departments')->insert(
            [
                ['id' => 1, 'name' => 'Administration'],
                ['id' => 2, 'name' => 'Human Resource'],
                ['id' => 3, 'name' => 'Development'],
                ['id' => 4, 'name' => 'Call Center'],
                ['id' => 5, 'name' => 'Customer Service'],
            ]
        );
    }
}
