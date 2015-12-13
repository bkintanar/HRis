<?php

/**
 * This file is part of the HRis Software package.
 *
 * HRis - Human Resource and Payroll System
 *
 * @link    http://github.com/HB-Co/HRis
 */
use Illuminate\Database\Seeder;

class MaritalStatusesTableSeeder extends Seeder
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
        DB::table('marital_statuses')->delete();

        DB::table('marital_statuses')->insert(
            [
                ['id' => 1, 'name' => 'Single'],
                ['id' => 2, 'name' => 'Married'],
                ['id' => 3, 'name' => 'Other'],
            ]
        );
    }
}
